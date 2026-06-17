<?php

/*
 * db.php
 */

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/db/DbController.php';
require_once __DIR__ . '/db/DbService.php';
require_once __DIR__ . '/db/DbRepository.php';
require_once __DIR__ . '/db/NovotrisHttpException.php';

const NOVOTRIS_LEVEL_MIN = 1;
const NOVOTRIS_LEVEL_MAX = 8;
const NOVOTRIS_MODE_MIN = 1;
const NOVOTRIS_MODE_MAX = 2;
const NOVOTRIS_LOG_VALUE_MAX_LENGTH = 512;

// -----------------------------------------------------------------------------

function sanitizeLogText($value)
{
  $text = (string)$value;

  // Mask common secret-bearing key/value patterns.
  $patterns = [
    '/(password\s*[=:]\s*)([^\s,;\]\}]+)/i',
    '/(user_password\s*[=:]\s*)([^\s,;\]\}]+)/i',
    '/(token\s*[=:]\s*)([^\s,;\]\}]+)/i',
    '/(activation_code\s*[=:]\s*)([^\s,;\]\}]+)/i',
    '/(db_name\s*[=:]\s*)([^\s,;\]\}]+)/i',
    '/(NOVOTRIS_DB_PASSWORD\s*[=:]\s*)([^\s,;\]\}]+)/i'
  ];

  $replacements = [
    '$1[REDACTED]',
    '$1[REDACTED]',
    '$1[REDACTED]',
    '$1[REDACTED]',
    '$1[REDACTED]',
    '$1[REDACTED]'
  ];

  $text = preg_replace($patterns, $replacements, $text);

  if (strlen($text) > NOVOTRIS_LOG_VALUE_MAX_LENGTH) {
    $text = substr($text, 0, NOVOTRIS_LOG_VALUE_MAX_LENGTH) . '...[TRUNCATED]';
  }

  return $text;
}

// -----------------------------------------------------------------------------

function normalizeLogValue($value)
{
  if ($value === null) {
    return 'null';
  }

  if (is_bool($value)) {
    return $value ? 'true' : 'false';
  }

  if (is_scalar($value)) {
    return sanitizeLogText((string)$value);
  }

  $encoded = json_encode($value);
  if ($encoded === false) {
    return '[UNSERIALIZABLE]';
  }

  return sanitizeLogText($encoded);
}

// -----------------------------------------------------------------------------

function dbLog($msg, array $context = [])
{
  $timestamp = date('Y-m-d H:i:s', time());
  $line = sanitizeLogText((string)$msg);

  if (!empty($context)) {
    $parts = [];
    foreach ($context as $key => $value) {
      $keyName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', (string)$key);
      if ($keyName === '') {
        $keyName = 'ctx';
      }
      $parts[] = $keyName . '=' . normalizeLogValue($value);
    }
    $line = $line . ' | ' . implode(' ', $parts);
  }

  file_put_contents('db-log.txt', "[" . $timestamp . "]" . "\t" . $line . PHP_EOL, FILE_APPEND | LOCK_EX);
}

// -----------------------------------------------------------------------------

function dbLogEvent($event, $status = 'ok', array $context = [])
{
  $baseContext = [
    'status' => $status
  ];
  dbLog('event=' . sanitizeLogText((string)$event), array_merge($baseContext, $context));
}

// -----------------------------------------------------------------------------

function loadEnvFile($filePath)
{
  if (!is_readable($filePath)) {
    return;
  }

  $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  if ($lines === false) {
    return;
  }

  foreach ($lines as $line) {
    $trimmed = trim($line);
    if ($trimmed === '' || strpos($trimmed, '#') === 0) {
      continue;
    }

    $pos = strpos($trimmed, '=');
    if ($pos === false) {
      continue;
    }

    $key = trim(substr($trimmed, 0, $pos));
    $value = trim(substr($trimmed, $pos + 1));

    if ($key === '') {
      continue;
    }

    if (strlen($value) >= 2) {
      $first = $value[0];
      $last = $value[strlen($value) - 1];
      if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
        $value = substr($value, 1, -1);
      }
    }

    if (getenv($key) === false) {
      putenv($key . '=' . $value);
      $_ENV[$key] = $value;
      $_SERVER[$key] = $value;
    }
  }
}

// -----------------------------------------------------------------------------

function bootstrapEnv()
{
  static $loaded = false;
  if ($loaded) {
    return;
  }

  $loaded = true;

  // Shared hosting fallback: load local .env if process env is not available.
  loadEnvFile(__DIR__ . '/../../.env');
  loadEnvFile(__DIR__ . '/../.env');
}

// -----------------------------------------------------------------------------

function getRequiredEnv($name)
{
  bootstrapEnv();

  $value = getenv($name);
  if ($value === false || trim($value) === '') {
    throw new RuntimeException('Missing required environment variable: ' . $name);
  }

  return $value;
}

// -----------------------------------------------------------------------------

function getEnvOrDefault($name, $default)
{
  bootstrapEnv();

  $value = getenv($name);
  if ($value === false || trim($value) === '') {
    return $default;
  }

  return $value;
}

// -----------------------------------------------------------------------------

function getGameplayConfig()
{
  static $config = null;
  if ($config !== null) {
    return $config;
  }

  $levelMin = NOVOTRIS_LEVEL_MIN;
  $levelMax = NOVOTRIS_LEVEL_MAX;
  $modeMin = NOVOTRIS_MODE_MIN;
  $modeMax = NOVOTRIS_MODE_MAX;

  // Fallbacks keep API output stable if constants are changed to invalid values.
  if ($levelMin < 1 || $levelMax < $levelMin) {
    $levelMin = 1;
    $levelMax = 8;
  }

  if ($modeMin < 1 || $modeMax < $modeMin) {
    $modeMin = 1;
    $modeMax = 2;
  }

  $config = [
    'level_min' => $levelMin,
    'level_max' => $levelMax,
    'level_count' => $levelMax - $levelMin + 1,
    'mode_min' => $modeMin,
    'mode_max' => $modeMax,
    'mode_count' => $modeMax - $modeMin + 1
  ];

  return $config;
}

// -----------------------------------------------------------------------------

function createPdo()
{
  global $pdo;
  $v_db_name = getEnvOrDefault('NOVOTRIS_DB_NAME', 'novotris_work');
  $db_user = getRequiredEnv('NOVOTRIS_DB_USER');
  $db_password = getRequiredEnv('NOVOTRIS_DB_PASSWORD');
  $pdo = new PDO(
    'mysql:host=localhost;dbname=' . $v_db_name . ';charset=utf8mb4',
    $db_user,
    $db_password,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false
    ]
  );
  return $pdo;
}

// -----------------------------------------------------------------------------

function getIp()
{
  $keys = [
    'HTTP_CLIENT_IP',
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_FORWARDED',
    'HTTP_FORWARDED_FOR',
    'HTTP_FORWARDED',
    'REMOTE_ADDR'
  ];

  foreach ($keys as $k) {
    if (isset($_SERVER[$k]) && !empty($_SERVER[$k]) && filter_var($_SERVER[$k], FILTER_VALIDATE_IP)) {
      return $_SERVER[$k];
    }
  }

  return null;
}

// -----------------------------------------------------------------------------

function detectMobileFlagFromUserAgent()
{
  $agent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');

  if ($agent === '') {
    return 'N';
  }

  // Keep detection intentionally broad to avoid missing common mobile devices.
  if (
    strpos($agent, 'android') !== false ||
    strpos($agent, 'iphone') !== false ||
    strpos($agent, 'ipod') !== false ||
    strpos($agent, 'ipad') !== false ||
    strpos($agent, 'mobile') !== false ||
    strpos($agent, 'opera mini') !== false ||
    strpos($agent, 'windows phone') !== false
  ) {
    return 'Y';
  }

  return 'N';
}

// -----------------------------------------------------------------------------

function resolveMobileFlag()
{
  // Server-side user-agent detection is the single source of truth for the mobile flag.
  // Client-provided mobile values are ignored intentionally to keep assignment deterministic.
  return detectMobileFlagFromUserAgent();
}

// -----------------------------------------------------------------------------

function hashPasswordValue($plainPassword)
{
  return password_hash((string)$plainPassword, PASSWORD_DEFAULT);
}

// -----------------------------------------------------------------------------

function verifyPasswordValue($plainPassword, $storedHash, $legacySalt)
{
  if (!is_string($storedHash) || $storedHash === '') {
    return false;
  }

  if (password_verify((string)$plainPassword, $storedHash)) {
    return true;
  }

  if ($legacySalt !== '') {
    return hash_equals($storedHash, crypt((string)$plainPassword, $legacySalt));
  }

  return false;
}

// -----------------------------------------------------------------------------

function needsPasswordRehash($storedHash)
{
  if (!is_string($storedHash) || $storedHash === '') {
    return true;
  }

  return password_get_info($storedHash)['algo'] === null || password_needs_rehash($storedHash, PASSWORD_DEFAULT);
}

// -----------------------------------------------------------------------------

function hashTokenValue($token)
{
  return password_hash((string)$token, PASSWORD_DEFAULT);
}

// -----------------------------------------------------------------------------

function createPlainToken()
{
  return bin2hex(random_bytes(32));
}

// -----------------------------------------------------------------------------

function verifyTokenValue($plainToken, $storedHash, $legacySalt)
{
  if (!is_string($storedHash) || $storedHash === '') {
    return false;
  }

  if (password_verify((string)$plainToken, $storedHash)) {
    return true;
  }

  if ($legacySalt !== '') {
    return hash_equals($storedHash, crypt((string)$plainToken, $legacySalt));
  }

  return false;
}

// -----------------------------------------------------------------------------

function findUserByActivationToken(PDO $pdo, $token, $legacySalt, $onlyInactive)
{
  if ($onlyInactive) {
    $statement = $pdo->prepare("SELECT id, old_user_id, activation_code FROM nov_user WHERE active = 'N' AND activated_at IS NULL AND activation_code IS NOT NULL AND activation_expiry IS NOT NULL AND activation_expiry >= now() AND activation_used_at IS NULL");
  } else {
    $statement = $pdo->prepare("SELECT id, old_user_id, activation_code FROM nov_user WHERE active = 'Y' AND activation_code IS NOT NULL AND activation_expiry IS NOT NULL AND activation_expiry >= now() AND activation_used_at IS NULL");
  }

  $statement->execute();

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    if (verifyTokenValue($token, $row['activation_code'], $legacySalt)) {
      return $row;
    }
  }

  return null;
}

// -----------------------------------------------------------------------------

function jsonError($statusCode, $errorCode, $message)
{
  http_response_code($statusCode);
  echo json_encode([
    'error' => $errorCode,
    'message' => $message
  ]);
  exit;
}

// -----------------------------------------------------------------------------

function handleThrowableAsJson(Throwable $e)
{
  if ($e instanceof NovotrisHttpException) {
    jsonError($e->getStatusCode(), $e->getErrorCode(), $e->getMessage());
  }

  if ($e instanceof InvalidArgumentException) {
    jsonError(400, 'bad_request', $e->getMessage());
  }

  if ($e instanceof RuntimeException) {
    jsonError(400, 'bad_request', $e->getMessage());
  }

  dbLogEvent('unhandled_exception', 'error', [
    'exception_class' => get_class($e)
  ]);
  jsonError(500, 'internal_error', 'Unexpected server error');
}

// -----------------------------------------------------------------------------

function emitSuccessResponse($payload)
{
  if ($payload === null) {
    http_response_code(204);
    return;
  }

  if (is_array($payload) || is_object($payload)) {
    echo json_encode($payload);
    return;
  }

  echo (string)$payload;
}

// -----------------------------------------------------------------------------

function normalizeRequestPayload()
{
  $rawBody = file_get_contents('php://input');
  $jsonPayload = [];

  if (is_string($rawBody) && trim($rawBody) !== '') {
    $decoded = json_decode($rawBody, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
      $jsonPayload = $decoded;
    }
  }

  // Backward compatible: POST values are accepted but normalized to one payload.
  return array_merge($_POST, $jsonPayload);
}

// -----------------------------------------------------------------------------

function validateRequiredRequestFields($functionname, array $request)
{
  $requiredByAction = [
    'logToDb' => ['nov_release', 'aktion', 'params', 'log_order'],
    'readHighscoreFromDb' => ['level', 'mobile', 'user_id', 'mode', 'period'],
    'readRankingPosition' => ['level', 'mobile', 'user_id', 'mode'],
    'getUserFromDb' => ['mobile'],
    'saveUserNameToDb' => ['id', 'name'],
    'saveUserSettingsToDb' => ['id', 'mode'],
    'startGameOnDb' => ['user_id', 'nov_release', 'level', 'mode'],
    'stopGameOnDb' => ['game_id', 'score'],
    'updateGameOnDb' => ['game_id', 'score'],
    'saveLevelToDb' => ['user_id', 'level'],
    'createUserOnDb' => ['user_name', 'user_email', 'user_password', 'mobile', 'activation_code', 'old_user_id'],
    'login' => ['user_name', 'password', 'mobile'],
    'activate' => ['activation_code'],
    'resetPassword' => ['user_name', 'user_email', 'mobile', 'activation_code'],
    'getChangePasswordUser' => ['activation_code'],
    'updatePassword' => ['activation_code', 'user_password'],
    'saveLanguageToDb' => ['user_id', 'language'],
    'getUserInfo' => ['user_id'],
    'getNovotrisInfo' => []
  ];

  if (!array_key_exists($functionname, $requiredByAction)) {
    return;
  }

  foreach ($requiredByAction[$functionname] as $fieldName) {
    if (!array_key_exists($fieldName, $request)) {
      throw new NovotrisHttpException(400, 'bad_request', 'Missing required field: ' . $fieldName);
    }
  }
}

// -----------------------------------------------------------------------------

function getAuthenticatedUserIdOrNull()
{
  if (!isset($_SESSION['nov_user_id'])) {
    return null;
  }

  return (int)$_SESSION['nov_user_id'];
}

// -----------------------------------------------------------------------------

function requireAuthenticatedUserId()
{
  $userId = getAuthenticatedUserIdOrNull();
  if ($userId === null || $userId <= 0) {
    jsonError(401, 'unauthorized', 'Authentication required');
  }

  return $userId;
}

// -----------------------------------------------------------------------------

function setAuthenticatedUserId($userId)
{
  session_regenerate_id(true);
  $_SESSION['nov_user_id'] = (int)$userId;
  $_SESSION['nov_last_auth_at'] = time();
}

// -----------------------------------------------------------------------------

function requestValue($input, $key)
{
  if (is_array($input) && array_key_exists($key, $input)) {
    return $input[$key];
  }

  if (isset($_POST[$key])) {
    return $_POST[$key];
  }

  return null;
}

// -----------------------------------------------------------------------------

function requireOwnerByField($input, $fieldName)
{
  $authenticatedUserId = requireAuthenticatedUserId();
  $targetUserId = (int)requestValue($input, $fieldName);

  if ($targetUserId <= 0 || $targetUserId !== $authenticatedUserId) {
    jsonError(403, 'forbidden', 'Access denied for requested user');
  }
}

// -----------------------------------------------------------------------------

function requireGameOwner($gameId)
{
  global $pdo;

  $authenticatedUserId = requireAuthenticatedUserId();
  $statement = $pdo->prepare("SELECT user_id FROM game WHERE id = ?");
  $statement->execute([(int)$gameId]);
  $row = $statement->fetch(PDO::FETCH_ASSOC);

  if ($row === false) {
    jsonError(404, 'not_found', 'Game not found');
  }

  if ((int)$row['user_id'] !== $authenticatedUserId) {
    jsonError(403, 'forbidden', 'Access denied for requested game');
  }
}

// -----------------------------------------------------------------------------

function enforceAuthorization($functionname, $input)
{
  switch ($functionname) {
    case 'saveLevelToDb':
      requireOwnerByField($input, 'user_id');
      break;
    case 'saveUserSettingsToDb':
      requireOwnerByField($input, 'id');
      break;
    case 'saveLanguageToDb':
      requireOwnerByField($input, 'user_id');
      break;
    case 'saveUserNameToDb':
      requireOwnerByField($input, 'id');
      break;
    case 'getUserInfo':
      requireOwnerByField($input, 'user_id');
      break;
    case 'startGameOnDb':
      requireOwnerByField($input, 'user_id');
      break;
    case 'stopGameOnDb':
      requireGameOwner(requestValue($input, 'game_id'));
      break;
    case 'updateGameOnDb':
      requireGameOwner(requestValue($input, 'game_id'));
      break;
    default:
      break;
  }
}

// -----------------------------------------------------------------------------

function logToDb($nov_release, $aktion, $params, $log_order)
{
  global $pdo;
  $datetime = date('Y-m-d H:i:s');
  $safeParams = sanitizeLogText($params);
  $safeAction = sanitizeLogText($aktion);
  $statement = $pdo->prepare("INSERT INTO nov_log (timestamp, ip, nov_release, aktion, params, log_order) VALUES (?,?,?,?,?,?)");
  $statement->execute([$datetime, getIp(), $nov_release, $safeAction, $safeParams, $log_order]);
}

// -----------------------------------------------------------------------------

function resolveAllowedScoreTable($table)
{
  $allowedTables = [
    'highscore',
    'score'
  ];

  $normalized = trim((string)$table);
  if (!in_array($normalized, $allowedTables, true)) {
    throw new InvalidArgumentException('Invalid table name for score persistence');
  }

  return $normalized;
}

// -----------------------------------------------------------------------------

function saveScoreToDb($table, $nov_release, $level, $score, $user_id)
{
  global $pdo;
  $datetime = date('Y-m-d H:i:s');
  $safeTable = resolveAllowedScoreTable($table);
  $sql = "INSERT INTO {$safeTable} (timestamp, ip, nov_release, level, score, user_id) VALUES (?,?,?,?,?,?)";
  $statement = $pdo->prepare($sql);
  $statement->execute([$datetime, getIp(), $nov_release, $level, $score, $user_id]);
}

// -----------------------------------------------------------------------------


function readHighscoreFromDb($level, $mobile, $user_id, $mode, $period)
{
  global $pdo;
  $sql = null;
  $params = [];
  $i = 0;
  $myArray = array();

  dbLogEvent('readHighscoreFromDb', 'ok', [
    'level' => (int)$level,
    'mode' => (int)$mode,
    'period' => (int)$period
  ]);

  if ($user_id > 0) {
    $sql = "SELECT ende, nov_release, game.level, score, name FROM game LEFT JOIN nov_user ON game.user_id = nov_user.id";
    $sql = $sql . " WHERE score > 0";

    if ($level > 0) {
      $sql = $sql . " AND game.level = ?";
      $params[] = (int)$level;
    }

    if ($period == 0) {
      $sql = $sql . " and game.beginn > NOW() - INTERVAL 12 MONTH";
    }

    $sql = $sql . " AND game.user_id = ?";
    $params[] = (int)$user_id;
    $sql = $sql . " AND mobile = ?";
    $params[] = $mobile;
    $sql = $sql . " AND nov_mode = ?";
    $params[] = (int)$mode;
    $sql = $sql . " ORDER BY score DESC, name LIMIT 50";
  } else {
    $sql = "select u.id, u.name, nov_level.level, g.score, g.ende";
    $sql = $sql . " from nov_user as u inner join game as g on g.user_id = u.id";
    $sql = $sql . " inner join nov_level on g.level = nov_level.level";
    $sql = $sql . " where g.score > 0  and g.score = (select max(g1.score) from game as g1";
    $sql = $sql . "   where g1.user_id = u.id";
    if ($period == 0) {
      $sql = $sql . " and g1.beginn > NOW() - INTERVAL 12 MONTH";
    }
    $sql = $sql . "     and g1.level = nov_level.level and g1.nov_mode = ?)";
    $params[] = (int)$mode;
    $sql = $sql . " and u.mobile = ?";
    $params[] = $mobile;

    if ($period == 0) {
      $sql = $sql . " and g.beginn > NOW() - INTERVAL 12 MONTH";
    }


    if ($level > 0) {
      $sql = $sql . " and nov_level.level = ?";
      $params[] = (int)$level;
    }

    $sql = $sql . " and nov_mode = ? order by g.score desc, name LIMIT 50";
    $params[] = (int)$mode;
  }

  $statement = $pdo->prepare($sql);
  $statement->execute($params);
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $i = $i + 1;
    $time = strtotime($row['ende']);
    $formatTime = date("d.m.y", $time);

    $myObj = new stdClass();

    $myObj->timestamp = $formatTime;
    $myObj->timestampmobile = $formatTime;
    $myObj->level = $row['level'];
    $myObj->score = $row['score'];
    $myObj->user_name = $row['name'];

    $myArray[] = $myObj;
  }

  return $myArray;
}

// -----------------------------------------------------------------------------


function readRankingPosition($level, $mobile, $user_id, $mode)
{
  global $pdo;
  $sql = null;
  $params = [];
  $i = 0;
  $position = -1;

  $sql = "select u.id";
  $sql = $sql . " from nov_user as u inner join game as g on g.user_id = u.id";
  $sql = $sql . " inner join nov_level on g.level = nov_level.level";
  $sql = $sql . " where g.score > 0  and g.score = (select max(g1.score) from game as g1";
  $sql = $sql . " where g1.user_id = u.id AND g1.level = nov_level.level and g1.beginn > NOW() - INTERVAL 12 MONTH and g1.nov_mode = ?)";
  $params[] = (int)$mode;
  $sql = $sql . " AND u.mobile = ?";
  $params[] = $mobile;
  $sql = $sql . " and nov_level.level = ?";
  $params[] = (int)$level;
  $sql = $sql . " and g.nov_mode = ?";
  $params[] = (int)$mode;
  $sql = $sql . " order by g.score desc LIMIT 100";

  dbLogEvent('readRankingPosition', 'ok', [
    'level' => (int)$level,
    'mode' => (int)$mode
  ]);

  $statement = $pdo->prepare($sql);
  $statement->execute($params);
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $i = $i + 1;

    if ($row['id'] == $user_id) {
      $position = $i;
      break;
    }
  }

  return $position;
}

// -----------------------------------------------------------------------------

function createGuestUser($mobile)
{
  global $pdo;
  $user_id = null;
  $mobile = resolveMobileFlag();

  try {
    $pdo->beginTransaction();

    $statement = $pdo->prepare("INSERT INTO nov_user (mobile) VALUES (?)");
    $statement->execute([$mobile]);
    $user_id = $pdo->lastInsertId();

    $statement = $pdo->prepare("UPDATE nov_user set name = ?, created = now() WHERE id = ?");
    $statement->execute(['guest' . $user_id, (int)$user_id]);

    $pdo->commit();
  } catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    throw $exception;
  }

  return $user_id;
}

// -----------------------------------------------------------------------------

function readUserScoresFromDb($userId)
{
  global $pdo;
  $gameplayConfig = getGameplayConfig();
  $levelMin = $gameplayConfig['level_min'];
  $levelMax = $gameplayConfig['level_max'];
  $levelCount = $gameplayConfig['level_count'];
  $modeMin = $gameplayConfig['mode_min'];
  $modeMax = $gameplayConfig['mode_max'];
  $modeCount = $gameplayConfig['mode_count'];

  $scores = [];
  for ($modeIndex = 0; $modeIndex < $modeCount; $modeIndex++) {
    $scores[] = array_fill(0, $levelCount, 0);
  }

  $statement = $pdo->prepare(
    "SELECT level, nov_mode, MAX(score) AS max_score
     FROM game
     WHERE user_id = ? AND level BETWEEN ? AND ? AND nov_mode BETWEEN ? AND ?
     GROUP BY level, nov_mode"
  );
  $statement->execute([(int)$userId, $levelMin, $levelMax, $modeMin, $modeMax]);

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $modeIndex = (int)$row['nov_mode'] - $modeMin;
    $levelIndex = (int)$row['level'] - $levelMin;

    if ($modeIndex >= 0 && $modeIndex < $modeCount && $levelIndex >= 0 && $levelIndex < $levelCount) {
      $score = $row['max_score'];
      $scores[$modeIndex][$levelIndex] = $score === null ? 0 : (int)$score;
    }
  }

  return $scores;
}

// -----------------------------------------------------------------------------

function readUserProfileById($userId)
{
  global $pdo;

  $statement = $pdo->prepare("SELECT id, name, credits, level, language, mode FROM nov_user WHERE id = ?");
  $statement->execute([(int)$userId]);
  $row = $statement->fetch(PDO::FETCH_ASSOC);

  if ($row === false) {
    return null;
  }

  return $row;
}

// -----------------------------------------------------------------------------

function updateUserMobileFlagIfProvided($userId, $mobile)
{
  global $pdo;

  if ($userId == null) {
    return;
  }

  if ($mobile === 'Y' || $mobile === 'N') {
    $statement = $pdo->prepare("UPDATE nov_user SET mobile = ? WHERE id = ?");
    $statement->execute([$mobile, (int)$userId]);
  }
}

// -----------------------------------------------------------------------------

function normalizeUserCredits($credits)
{
  if ($credits == null) {
    return 0;
  }

  return (int)$credits;
}

// -----------------------------------------------------------------------------

function getUserFromDb($id, $mobile)
{
  global $pdo;
  $authenticatedUserId = getAuthenticatedUserIdOrNull();
  $lookupUserId = $authenticatedUserId !== null ? (int)$authenticatedUserId : 0;

  $user_id = null;
  $user_name = null;
  $user_scores = array();
  $user_credits = null;
  $user_level = null;
  $user_language = null;
  $user_mode = null;
  $user_games = 0;

  if ($lookupUserId > 0) {
    $userProfile = readUserProfileById($lookupUserId);
    if ($userProfile !== null) {
      $user_id = $userProfile['id'];
      $user_name = $userProfile['name'];
      $user_credits = $userProfile['credits'];
      $user_level = $userProfile['level'];
      $user_language = $userProfile['language'];
      $user_mode = $userProfile['mode'];
    }
  }

  // Keep the persisted device flag in sync with the current client.
  updateUserMobileFlagIfProvided($user_id, $mobile);

  if ($user_id == null) {
    $user_id = createGuestUser($mobile);
    setAuthenticatedUserId($user_id);

    $userProfile = readUserProfileById((int)$user_id);
    if ($userProfile !== null) {
      $user_id = $userProfile['id'];
      $user_name = $userProfile['name'];
      $user_credits = $userProfile['credits'];
      $user_level = $userProfile['level'];
      $user_language = $userProfile['language'];
      $user_mode = $userProfile['mode'];
    }
  }

  dbLogEvent('getUserFromDb', 'ok', [
    'user_mode' => $user_mode
  ]);

  $retValue = new stdClass();
  $retValue->user_id = $user_id;
  $retValue->user_name = $user_name;
  $retValue->user_credits = normalizeUserCredits($user_credits);
  $retValue->user_level = $user_level;
  $retValue->user_language = $user_language;
  $retValue->user_mode = $user_mode;

  $user_scores = readUserScoresFromDb((int)$user_id);

  $statement = $pdo->prepare("SELECT count(*) as cnt FROM game WHERE ende is not null AND user_id = ?");
  $statement->execute([(int)$user_id]);
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $user_games = (int)$row['cnt'];
    break;
  }

  $retValue->user_scores = $user_scores;
  $retValue->user_games = $user_games;
  return $retValue;
}

// -----------------------------------------------------------------------------

function createUserOnDb($user_name, $user_email, $user_password, $mobile, $activation_code, $old_user_id)
{
  global $pdo;
  $user_id = null;
  $retValue = new stdClass();
  $mobile = resolveMobileFlag();

  $user_id = -1;
  $statement = $pdo->prepare("SELECT id FROM nov_user WHERE name = ?");
  $statement->execute([$user_name]);
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $user_id = $row['id'];
    break;
  }

  if ($user_id > 0) {
    // name already exists:
    $retValue->user_id = 0;
    $retValue->error_message = "Der Benutzer existiert bereits."; // error_message wird nicht verarbeitet
    return $retValue;
  }

  $user_id = -1;
  $statement = $pdo->prepare("SELECT id FROM nov_user WHERE email = ? AND mobile = ?");
  $statement->execute([$user_email, $mobile]);
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $user_id = $row['id'];
    break;
  }

  if ($user_id > 0) {
    // email already exists:
    $retValue->user_id = 0;
    $retValue->error_message = "Die EMail-Adresse existiert bereits."; // error_message wird nicht verarbeitet
    return $retValue;
  }

  try {
    $pdo->beginTransaction();

    $statement = $pdo->prepare("INSERT INTO nov_user (uuid) VALUES (?)");
    $statement->execute(['no_uuid']);
    $user_id = $pdo->lastInsertId();

    $statement = $pdo->prepare(
      "UPDATE nov_user set name = ?, email = ?, password = ?, mobile = ?, activation_code = ?, activation_expiry = DATE_ADD(now(), INTERVAL 72 HOUR), activation_used_at = NULL, active = 'N', created = now(), level = 1, credits = 0, old_user_id = ?, language = 'de' WHERE id = ?"
    );
    $statement->execute([
      $user_name,
      $user_email,
      hashPasswordValue($user_password),
      $mobile,
      hashTokenValue($activation_code),
      (int)$old_user_id,
      (int)$user_id
    ]);

    $pdo->commit();
  } catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    throw $exception;
  }

  $retValue->user_id = $user_id;
  $retValue->error_message = null;

  return $retValue;
}

// -----------------------------------------------------------------------------

function resetPassword($user_name, $user_email, $mobile, $activation_code)
{
  global $pdo;
  $user_id = null;
  $retValue = new stdClass();


  $user_id = -1;
  $statement = $pdo->prepare("SELECT id FROM nov_user WHERE name = ? AND email = ? AND mobile = ? AND active = 'Y'");
  $statement->execute([$user_name, $user_email, $mobile]);
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $user_id = $row['id'];
    break;
  }

  if ($user_id != -1) {
    $statement = $pdo->prepare("UPDATE nov_user set activation_code = ?, activation_expiry = DATE_ADD(now(), INTERVAL 2 HOUR), activation_used_at = NULL WHERE id = ?");
    $statement->execute([hashTokenValue($activation_code), (int)$user_id]);
  }

  $retValue->user_id = $user_id;
  return $retValue;
}

// -----------------------------------------------------------------------------

function login($user_name, $password, $mobile, $legacySalt)
{
  global $pdo;
  $salt = (string)$legacySalt;
  $user_id = null;
  $user_password = null;
  $user_scores = array();
  $retValue = new stdClass();

  $user_id = -1;
  $statement = $pdo->prepare("SELECT id, password, credits, level, language FROM nov_user WHERE name = ? AND active = 'Y'");
  $statement->execute([$user_name]);

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $user_id = $row['id'];
    $user_password = $row['password'];
    $user_credits = $row['credits'];
    $user_level = $row['level'];
    $user_language = $row['language'];
    break;
  }

  if ($user_id == -1 || !verifyPasswordValue($password, $user_password, $salt)) {
    $retValue->error_message = "Diese Kombination aus Username und Passwort ist ungültig."; // error_message wird nicht verarbeitet
    $retValue->user_id = 0;
    return $retValue;
  }

  setAuthenticatedUserId($user_id);

  if (needsPasswordRehash($user_password)) {
    $statement = $pdo->prepare("UPDATE nov_user SET password = ? WHERE id = ?");
    $statement->execute([hashPasswordValue($password), (int)$user_id]);
  }

  updateUserMobileFlagIfProvided($user_id, $mobile);

  $retValue->error_message = null;
  $retValue->user_id = $user_id;
  $retValue->user_name = $user_name;
  $retValue->user_credits = normalizeUserCredits($user_credits);
  $retValue->user_level = $user_level;
  $retValue->user_language = $user_language;

  $user_scores = readUserScoresFromDb((int)$user_id);

  $retValue->user_scores = $user_scores;

  return $retValue;
}


// -----------------------------------------------------------------------------

function saveLevelToDb($user_id, $level)
{
  global $pdo;
  $statement = $pdo->prepare("UPDATE nov_user set level = ? WHERE id = ?");
  $statement->execute([(int)$level, (int)$user_id]);
}

// -----------------------------------------------------------------------------

function saveUserNameToDb($id, $name)
{
  global $pdo;

  // Prevent guest usernames
  if (strtolower(substr($name, 0, 4)) === "user") {
    return "N";
  }


  // check if the user name already exists:
  $statement = $pdo->prepare("SELECT id FROM nov_user WHERE id <> ? AND lower(name) = lower(?)");
  $statement->execute([(int)$id, $name]);
  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    return "N";
  }

  // update user name:
  $statement = $pdo->prepare("UPDATE nov_user set name = ? WHERE id = ?");
  $statement->execute([$name, (int)$id]);
  return "Y";
}

// -----------------------------------------------------------------------------

function saveUserSettingsToDb($id, $mode)
{
  global $pdo;

  dbLogEvent('saveUserSettingsToDb', 'ok', [
    'mode' => (int)$mode
  ]);

  // update current playing mode:
  $statement = $pdo->prepare("UPDATE nov_user set mode = ? WHERE id = ?");
  $statement->execute([$mode, (int)$id]);
  return "Y";
}

// -----------------------------------------------------------------------------

function startGameOnDb($user_id, $nov_release, $level, $mode)
{
  global $pdo;

  try {
    $pdo->beginTransaction();

    // Create initial record and use the generated ID directly to avoid race conditions.
    $statement = $pdo->prepare("INSERT INTO game (user_id, ip) VALUES (?,?)");
    $statement->execute([$user_id, getIp()]);
    $game_id = (int)$pdo->lastInsertId();

    // Update record with game details.
    $statement = $pdo->prepare("UPDATE game SET nov_release = ?, level = ?, beginn = now(), nov_mode = ? WHERE id = ?");
    $statement->execute([$nov_release, $level, $mode, $game_id]);

    $pdo->commit();
    return $game_id;
  } catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    throw $exception;
  }
}

// -----------------------------------------------------------------------------

function stopGameOnDb($game_id, $score)
{
  global $pdo;
  $statement = $pdo->prepare("UPDATE game SET score = ?, ende = now() WHERE id = ? AND ende IS NULL");
  $statement->execute([$score, $game_id]);
  return getIp();
}

// -----------------------------------------------------------------------------

function updateGameOnDb($game_id, $score)
{
  global $pdo;
  $statement = $pdo->prepare("UPDATE game SET score_live = ?, timestamp_live = now() WHERE id = ? AND ende IS NULL");
  $statement->execute([$score, $game_id]);
  return getIp();
}

// -----------------------------------------------------------------------------

function activate($activation_code, $legacySalt)
{
  global $pdo;
  $salt = (string)$legacySalt;
  $user_id = 0;
  $old_user_id = 0;

  $user = findUserByActivationToken($pdo, $activation_code, $salt, true);

  if ($user != null) {
    $user_id = (int)$user['id'];
    $old_user_id = (int)$user['old_user_id'];
  }

  if ($user_id > 0) {
    try {
      $pdo->beginTransaction();

      $statement = $pdo->prepare("UPDATE nov_user SET activated_at = now(), active = 'Y', activation_used_at = now(), activation_code = NULL, activation_expiry = NULL WHERE id = ? AND activation_code IS NOT NULL AND activation_expiry IS NOT NULL AND activation_expiry >= now() AND activation_used_at IS NULL");
      $statement->execute([$user_id]);

      if ($statement->rowCount() !== 1) {
        $pdo->rollBack();
        return 0;
      }

      if ($old_user_id > 0) {
        $statement = $pdo->prepare("UPDATE game SET user_id = ? WHERE user_id = ?");
        $statement->execute([$user_id, $old_user_id]);
      }

      $pdo->commit();
    } catch (Throwable $exception) {
      if ($pdo->inTransaction()) {
        $pdo->rollBack();
      }
      throw $exception;
    }
  }

  return $user_id;
}

// -----------------------------------------------------------------------------

function getChangePasswordUser($activation_code, $legacySalt)
{
  global $pdo;
  $salt = (string)$legacySalt;
  $user_id = 0;
  $rotated_activation_code = null;

  $user = findUserByActivationToken($pdo, $activation_code, $salt, false);
  if ($user != null) {
    $user_id = (int)$user['id'];

    try {
      $pdo->beginTransaction();

      $rotated_activation_code = createPlainToken();
      $statement = $pdo->prepare("UPDATE nov_user SET activation_code = ?, activation_expiry = DATE_ADD(now(), INTERVAL 30 MINUTE), activation_used_at = NULL WHERE id = ? AND activation_code IS NOT NULL AND activation_expiry IS NOT NULL AND activation_expiry >= now() AND activation_used_at IS NULL");
      $statement->execute([hashTokenValue($rotated_activation_code), $user_id]);

      if ($statement->rowCount() !== 1) {
        $pdo->rollBack();
        $user_id = 0;
        $rotated_activation_code = null;
      } else {
        $pdo->commit();
      }
    } catch (Throwable $exception) {
      if ($pdo->inTransaction()) {
        $pdo->rollBack();
      }
      throw $exception;
    }
  }

  $retValue = new stdClass();
  $retValue->user_id = $user_id;
  $retValue->activation_code = $rotated_activation_code;
  return $retValue;
}

// -----------------------------------------------------------------------------

function updatePassword($activation_code, $user_password, $legacySalt)
{
  global $pdo;
  $salt = (string)$legacySalt;

  $user = findUserByActivationToken($pdo, $activation_code, $salt, false);
  if ($user == null) {
    return "invalid_token";
  }

  $statement = $pdo->prepare("UPDATE nov_user SET password = ?, activation_used_at = now(), activation_code = NULL, activation_expiry = NULL WHERE id = ? AND activation_code IS NOT NULL AND activation_expiry IS NOT NULL AND activation_expiry >= now() AND activation_used_at IS NULL");
  $statement->execute([hashPasswordValue($user_password), (int)$user['id']]);

  if ($statement->rowCount() !== 1) {
    return "invalid_token";
  }

  return "ok";
}

// -----------------------------------------------------------------------------

function saveLanguageToDb($user_id, $language)
{
  global $pdo;
  $statement = $pdo->prepare("UPDATE nov_user SET language = ? WHERE id = ?");
  $statement->execute([$language, $user_id]);
  return "ok";
}

// -----------------------------------------------------------------------------

// TODO: Implement IP geolocation lookup if needed

// -----------------------------------------------------------------------------

function novDateToString($date)
{
  if ($date == null)
    return ("-");
  else
    return date("d.m.y", strtotime($date));
}

// -----------------------------------------------------------------------------

function getUserInfo($user_id)
{
  global $pdo;
  $firstGame = null;
  $lastGame = null;
  $nrGames = null;

  $statement = $pdo->prepare("select min(g.beginn) as min_beginn from game as g where g.score > 0 and g.user_id = ?");
  $statement->execute([(int)$user_id]);

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $firstGame = novDateToString($row['min_beginn']);
    break;
  }

  $statement = $pdo->prepare("select max(g.beginn) as max_beginn from game as g where g.score > 0 and g.user_id = ?");
  $statement->execute([(int)$user_id]);

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $lastGame = novDateToString($row['max_beginn']);
    break;
  }

  $statement = $pdo->prepare("select count(*) as cnt from game as g where g.ende is not null and g.user_id = ?");
  $statement->execute([(int)$user_id]);

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $nrGames = $row['cnt'];
    break;
  }
  $response = [
    "firstGame" => $firstGame,
    "lastGame" => $lastGame,
    "nrGames" => $nrGames
  ];

  return $response;
}

// -----------------------------------------------------------------------------

function getNovotrisInfo()
{
  global $pdo;
  $nrUsers = null;
  $nrGames = null;

  $sql = "select count(*) as cnt";
  $sql = $sql . " from game as g";
  foreach ($pdo->query($sql) as $row) {
    $nrGames = $row['cnt'];
    break;
  }

  $sql = "select count(*) as cnt";
  $sql = $sql . " from nov_user as u";
  foreach ($pdo->query($sql) as $row) {
    $nrUsers = $row['cnt'];
    break;
  }

  $response = [
    "nrUsers" => $nrUsers,
    "nrGames" => $nrGames
  ];
  return $response;
}

// -----------------------------------------------------------------------------

// Prevent error messages from corrupting JSON response
header('Content-Type: application/json');

// Receive data from JavaScript
$request = normalizeRequestPayload();

$functionname = $request['functionname'] ?? null;

if (!is_string($functionname) || trim($functionname) === '') {
  jsonError(400, 'bad_request', 'Missing functionname');
}

dbLogEvent('dispatch', 'start', [
  'functionname' => $functionname
]);

$pwSalt = null;

try {
  $pwSalt = getEnvOrDefault('NOVOTRIS_PW_SALT', '');
  $pdo = createPdo();
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode([
    'error' => 'Server configuration error'
  ]);
  exit;
}

$repository = new DbRepository($pdo);
$service = new DbService($repository);
$controller = new DbController($service, [
  'logToDb' => function ($request) {
    logToDb($request['nov_release'], $request['aktion'], $request['params'], $request['log_order']);
    return null;
  },
  'readHighscoreFromDb' => function ($request) {
    return readHighscoreFromDb($request['level'], $request['mobile'], $request['user_id'], $request['mode'], $request['period']);
  },
  'readRankingPosition' => function ($request) {
    return readRankingPosition($request['level'], $request['mobile'], $request['user_id'], $request['mode']);
  },
  'getUserFromDb' => function ($request) {
    return getUserFromDb($request['id'] ?? null, $request['mobile'] ?? null);
  },
  'saveUserNameToDb' => function ($request) {
    return saveUserNameToDb($request['id'], $request['name']);
  },
  'saveUserSettingsToDb' => function ($request) {
    return saveUserSettingsToDb($request['id'], $request['mode']);
  },
  'startGameOnDb' => function ($request) {
    return startGameOnDb($request['user_id'], $request['nov_release'], $request['level'], $request['mode']);
  },
  'stopGameOnDb' => function ($request) {
    return stopGameOnDb($request['game_id'], $request['score']);
  },
  'updateGameOnDb' => function ($request) {
    return updateGameOnDb($request['game_id'], $request['score']);
  },
  'saveLevelToDb' => function ($request) {
    saveLevelToDb($request['user_id'], $request['level']);
    return null;
  },
  'createUserOnDb' => function ($request) {
    return createUserOnDb(
      $request['user_name'],
      $request['user_email'],
      $request['user_password'],
      $request['mobile'],
      $request['activation_code'],
      $request['old_user_id']
    );
  },
  'login' => function ($request) use ($pwSalt) {
    return login($request['user_name'], $request['password'], $request['mobile'], $pwSalt);
  },
  'activate' => function ($request) use ($pwSalt) {
    return activate($request['activation_code'], $pwSalt);
  },
  'resetPassword' => function ($request) {
    return resetPassword($request['user_name'], $request['user_email'], $request['mobile'], $request['activation_code']);
  },
  'getChangePasswordUser' => function ($request) use ($pwSalt) {
    return getChangePasswordUser($request['activation_code'], $pwSalt);
  },
  'updatePassword' => function ($request) use ($pwSalt) {
    return updatePassword($request['activation_code'], $request['user_password'], $pwSalt);
  },
  'saveLanguageToDb' => function ($request) {
    return saveLanguageToDb($request['user_id'], $request['language']);
  },
  'getUserInfo' => function ($request) {
    return getUserInfo($request['user_id']);
  },
  'getNovotrisInfo' => function ($request) {
    return getNovotrisInfo();
  }
]);

try {
  validateRequiredRequestFields($functionname, $request);
  $responsePayload = $controller->dispatch($functionname, $request);
  emitSuccessResponse($responsePayload);
} catch (Throwable $e) {
  handleThrowableAsJson($e);
}

// -----------------------------------------------------------------------------
