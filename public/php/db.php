<?php

/*
 * db.php
 */

// -----------------------------------------------------------------------------

function dbLog($msg)
{
  $timestamp = date('Y-m-d H:i:s', time());
  file_put_contents('db-log.txt', "[" . $timestamp . "]" . "\t" . $msg . PHP_EOL, FILE_APPEND | LOCK_EX);
}

// -----------------------------------------------------------------------------

function createPdo($db_name)
{
  global $pdo;

  $v_db_name = $db_name;

  if ($v_db_name == null)
    $v_db_name = 'novotris_work';

  // if ($pdo == null) 
  $pdo = new PDO('mysql:host=localhost;dbname=' . $v_db_name, 'novotris_admin', 'NovForEver');
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

function logToDb($nov_release, $aktion, $params, $log_order)
{
  global $pdo;
  $myDate = date('m/d/Y h:i:s a', time());
  $datetime = date_create()->format('Y-m-d H:i:s');
  $statement = $pdo->prepare("INSERT INTO nov_log (timestamp, ip, nov_release, aktion, params, log_order) VALUES (?,?,?,?,?,?)");
  $statement->execute(array($datetime, getIp(), $nov_release, $aktion, $params, $log_order));
}

// -----------------------------------------------------------------------------

function saveScoreToDb($table, $nov_release, $level, $score, $user_id)
{
  global $pdo;
  $myDate = date('m/d/Y h:i:s a', time());
  $datetime = date_create()->format('Y-m-d H:i:s');
  $sql = "INSERT INTO " . $table . " (timestamp, ip, nov_release, level, score, user_id)";
  $sql = $sql . " VALUES (?,?,?,?,?,?)";
  $statement = $pdo->prepare($sql);
  $statement->execute(array($datetime, getIp(), $nov_release, $level, $score, $user_id));
}

// -----------------------------------------------------------------------------


function readHighscoreFromDb($level, $mobile, $user_id, $mode, $period)
{
  global $pdo;
  $sql = null;
  $i = 0;
  $myArray = array();

  dbLog("readHighscoreFromDb");

  if ($user_id > 0) {
    $sql = "SELECT ende, nov_release, game.level, score, name FROM game LEFT JOIN nov_user ON game.user_id = nov_user.id";
    $sql = $sql . " WHERE score > 0";

    if ($level > 0) {
      $sql = $sql . " AND game.level = " . $level;
    }

    if ($period == 0) {
      $sql = $sql . " and game.beginn > NOW() - INTERVAL 12 MONTH";
    }

    $sql = $sql . " AND game.user_id = " . $user_id;
    $sql = $sql . " AND mobile = '" . $mobile . "'";
    $sql = $sql . " AND nov_mode = '" . $mode . "'";
    $sql = $sql . " ORDER BY score DESC, name";
  } else {
    $sql = "select u.id, u.name, nov_level.level, g.score, g.ende";
    $sql = $sql . " from nov_user as u inner join game as g on g.user_id = u.id";
    $sql = $sql . " inner join nov_level on g.level = nov_level.level";
    $sql = $sql . " where g.score > 0  and g.score = (select max(g1.score) from game as g1";
    $sql = $sql . "   where g1.user_id = u.id";
    if ($period == 0) {
      $sql = $sql . " and g1.beginn > NOW() - INTERVAL 12 MONTH";
    }
    $sql = $sql . "     and g1.level = nov_level.level and g1.nov_mode = " . $mode . ")";
    $sql = $sql . " and u.mobile = '" . $mobile . "'";

    if ($period == 0) {
      $sql = $sql . " and g.beginn > NOW() - INTERVAL 12 MONTH";
    }


    if ($level > 0) {
      $sql = $sql . " and nov_level.level = " . $level;
    }

    $sql = $sql . " and nov_mode = " . $mode . " order by g.score desc, name";
  }

  foreach ($pdo->query($sql) as $row) {
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

    if ($i >= 50)
      break;
  }

  echo json_encode($myArray);
}

// -----------------------------------------------------------------------------


function readRankingPosition($level, $mobile, $user_id, $mode)
{
  global $pdo;
  $sql = null;
  $i = 0;
  $position = -1;

  $sql = "select u.id";
  $sql = $sql . " from nov_user as u inner join game as g on g.user_id = u.id";
  $sql = $sql . " inner join nov_level on g.level = nov_level.level";
  $sql = $sql . " where g.score > 0  and g.score = (select max(g1.score) from game as g1";
  $sql = $sql . " where g1.user_id = u.id AND g1.level = nov_level.level)";
  $sql = $sql . " AND u.mobile = '" . $mobile . "'";
  $sql = $sql . " and nov_level.level = " . $level;
  $sql = $sql . " and g.nov_mode = " . $mode;
  $sql = $sql . " order by g.score desc";

  dbLog("readRankingPosition, sql = " .  $sql);


  foreach ($pdo->query($sql) as $row) {
    $i = $i + 1;

    if ($row['id'] == $user_id) {
      $position = $i;
      break;
    }

    if ($i >= 100)
      break;
  }

  echo $position;
}

// -----------------------------------------------------------------------------

function createGuestUser($mobile)
{
  global $pdo;
  $user_id = null;

  $sql = "INSERT INTO nov_user (mobile) VALUES ('" . $mobile . "')";
  $pdo->query($sql);
  $user_id = $pdo->lastInsertId();

  $sql = "UPDATE nov_user set name = 'guest" . $user_id . "', created = now() WHERE id = " . $user_id;
  $pdo->query($sql);

  return $user_id;
}

// -----------------------------------------------------------------------------

function getUserFromDb($id, $mobile)
{
  global $pdo;
  $sql = "SELECT id, name, credits, level, language FROM nov_user WHERE id = '" . $id . "'";
  $user_id = null;
  $user_name = null;
  $user_scores = array();
  $user_credits = null;
  $user_level = null;
  $user_language = null;

  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    $user_name = $row['name'];
    $user_credits = $row['credits'];
    $user_level = $row['level'];
    $user_language = $row['language'];
    break;
  }

  if ($user_id == null) {
    $user_id = createGuestUser($mobile);

    $sql = "SELECT id, name, credits, level, language FROM nov_user WHERE id = '" . $user_id . "'";
    foreach ($pdo->query($sql) as $row) {
      $user_id = $row['id'];
      $user_name = $row['name'];
      $user_credits = $row['credits'];
      $user_level = $row['level'];
      $user_language = $row['language'];
      break;
    }
  }

  $retValue = new stdClass();
  $retValue->user_id = $user_id;
  $retValue->user_name = $user_name;
  if ($user_credits == null)
    $user_credits = 0;
  $retValue->user_credits = $user_credits;
  $retValue->user_level = $user_level;
  $retValue->user_language = $user_language;


  /* TODO: anzahl levels dynamisch */
  /* TODO: anzahl modes dynamisch */

  for ($j = 0; $j <= 1; ++$j) {
    for ($i = 1; $i <= 8; ++$i) {
      $sql = "select u.id,
            (select max(g.score) 
             from game as g
             where g.user_id = u.id
               and g.level = " . $i . "
               and g.nov_mode = " . $j + 1 . "
               and u.id = " . $user_id . ") as score
            from nov_user as u
            order by score desc";

      foreach ($pdo->query($sql) as $row) {
        $score = $row['score'];
        if ($score == null)
          $score = 0;

        $user_scores[$j][] = $score;
        break;
      }
    }
  }

  $retValue->user_scores = $user_scores;
  echo json_encode($retValue);
}

// -----------------------------------------------------------------------------

function createUserOnDb($user_name, $user_email, $user_password, $mobile, $activation_code, $old_user_id)
{
  global $pdo;
  global $pw_salt;
  $sql = null;
  $user_id = null;
  $retValue = new stdClass();

  $user_id = -1;
  $sql = "SELECT id FROM nov_user WHERE name = '" . $user_name . "'";
  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    break;
  }

  if ($user_id > 0) {
    // name already exists:
    $retValue->user_id = 0;
    $retValue->error_message = "Der Benutzer existiert bereits."; // error_message wird nicht verarbeitet
    echo json_encode($retValue);
    return;
  }

  $user_id = -1;
  $sql = "SELECT id FROM nov_user WHERE email = '" . $user_email . "' AND mobile = '" . $mobile . "'";
  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    break;
  }

  if ($user_id > 0) {
    // email already exists:
    $retValue->user_id = 0;
    $retValue->error_message = "Die EMail-Adresse existiert bereits."; // error_message wird nicht verarbeitet
    echo json_encode($retValue);
    return;
  }

  $sql = "INSERT INTO nov_user (uuid) VALUES ('no_uuid')";
  $pdo->query($sql);
  $user_id = $pdo->lastInsertId();

  $sql = "UPDATE nov_user set name = '" . $user_name . "', email = '" . $user_email . "', password = '" . crypt($user_password, $pw_salt) . "', mobile =  '" . $mobile . "',";
  $sql = $sql . " activation_code = '" . crypt($activation_code, $pw_salt) . "',";
  $sql = $sql . " active = 'N', created = now(), level = 1, credits = 0, old_user_id = " . $old_user_id . ", language = 'de' WHERE id = " . $user_id;
  $pdo->query($sql);
  $retValue->user_id = $user_id;
  $retValue->error_message = null;

  echo json_encode($retValue);
}

// -----------------------------------------------------------------------------

function resetPassword($user_name, $user_email, $mobile, $activation_code)
{
  global $pdo;
  global $pw_salt;
  $sql = null;
  $user_id = null;
  $retValue = new stdClass();


  $user_id = -1;
  $sql = "SELECT id FROM nov_user WHERE name = '" . $user_name . "' AND email = '" . $user_email . "' AND mobile = '" . $mobile . "'";
  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    break;
  }

  if ($user_id != -1) {
    $sql = "UPDATE nov_user set activation_code = '" . crypt($activation_code, $pw_salt) . "' WHERE id = " . $user_id;
    $pdo->query($sql);
  }

  $retValue->user_id = $user_id;
  echo json_encode($retValue);
  return;
}

// -----------------------------------------------------------------------------

function login($user_name, $password, $mobile)
{
  global $pdo;
  global $pw_salt;
  $sql = null;
  $user_id = null;
  $user_password = null;
  $retValue = new stdClass();

  $user_id = -1;
  $sql = "SELECT id, password, credits, level, language FROM nov_user ";
  $sql =  $sql . "WHERE name = '" . $user_name . "' AND active = 'Y' AND mobile = '" . $mobile . "'";

  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    $user_password = $row['password'];
    $user_credits = $row['credits'];
    $user_level = $row['level'];
    $user_language = $row['language'];
    break;
  }

  if ($user_id == -1 || !password_verify($password, $user_password)) {
    $retValue->error_message = "Diese Kombination aus Username und Passwort ist ungültig."; // error_message wird nicht verarbeitet
    $retValue->user_id = 0;
    echo json_encode($retValue);
    return;
  }

  $retValue->error_message = null;
  $retValue->user_id = $user_id;
  $retValue->user_name = $user_name;
  if ($user_credits == null)
    $user_credits = 0;
  $retValue->user_credits = $user_credits;
  $retValue->user_level = $user_level;
  $retValue->user_language = $user_language;

  //TODO scores
  /* TODO: anzahl levels dynamisch */

  for ($j = 0; $j <= 1; ++$j) {
    for ($i = 1; $i <= 8; ++$i) {
      $sql = "select u.id,
            (select max(g.score) 
             from game as g
             where g.user_id = u.id
               and g.level = " . $i . "
               and g.nov_mode = " . $j + 1 . "
               and u.id = " . $user_id . ") as score
            from nov_user as u
            order by score desc";

      foreach ($pdo->query($sql) as $row) {
        $score = $row['score'];
        if ($score == null)
          $score = 0;

        $user_scores[$j][] = $score;
        break;
      }
    }
  }

  $retValue->user_scores = $user_scores;

  echo json_encode($retValue);
}


// -----------------------------------------------------------------------------

function saveLevelToDb($user_id, $level)
{
  global $pdo;
  $sql = "UPDATE nov_user set level = " . $level . " WHERE id = " . $user_id;
  $pdo->query($sql);
}

// -----------------------------------------------------------------------------

function saveUserNameToDb($id, $name)
{
  global $pdo;

  // check on invalid characters:
  /*
  if (!preg_match("[a-zA-Z0-9äöüßÄÖÜ]-", $name)) {
    echo "N";
    return;
  }
  */

  if (strcmp(strtolower(substr($name, 0, 4)), "user") == 0) {
    echo "N";
    return;
  }


  // check if the user name already exists:
  $sql = "SELECT id FROM nov_user WHERE  id <> " . $id . " AND lower (name) = lower ('" . $name . "')";
  foreach ($pdo->query($sql) as $row) {
    echo "N";
    return;
  }

  // update user name:
  $sql = "UPDATE nov_user set name = '" . $name . "' WHERE id = " . $id;
  $pdo->query($sql);
  echo "Y";
}

// -----------------------------------------------------------------------------

function startGameOnDb($user_id, $nov_release, $level, $mode)
{
  global $pdo;
  $game_id = null;

  // create initial record set:
  $statement = $pdo->prepare("INSERT INTO game (user_id) VALUES (?)");
  $statement->execute(array($user_id));

  // get id:
  $sql = "SELECT id FROM game WHERE user_id = '" . $user_id . "' AND level is null ORDER BY id desc";
  foreach ($pdo->query($sql) as $row) {
    $game_id = $row['id'];
    break;
  }

  // update record set with more values:
  $sql = "UPDATE game set nov_release = '" . $nov_release . "', level = " . $level . ", beginn = now(), nov_mode = " . $mode . " WHERE id = " . $game_id;
  $pdo->query($sql);

  echo $game_id;
}

// -----------------------------------------------------------------------------

function stopGameOnDb($game_id, $score)
{
  dbLog("stopGameOnDb, game_id = " . $game_id);

  global $pdo;
  $sql = "UPDATE game set score = " . $score . ", ende = now() WHERE id = " . $game_id . " AND ende is null";
  $pdo->query($sql);

  echo getIp();
}

// -----------------------------------------------------------------------------

function activate($activation_code)
{
  global $pdo;
  global $pw_salt;
  $user_id = 0;
  $old_user_id = 0;

  $sql = "SELECT id, old_user_id FROM nov_user WHERE activation_code = '" . crypt($activation_code, $pw_salt) . "'";
  $sql = $sql . " AND active = 'N' AND activated_at IS NULL";

  echo "db.php activate sql" . $sql;

  foreach ($pdo->query($sql) as $row) {
    $user_id =  $row['id'];
    $old_user_id =  $row['old_user_id'];

    break;
  }

  echo "db.php activate sql" . $user_id;


  if ($user_id > 0) {
    $sql = "UPDATE nov_user set activated_at = now(), active = 'Y' WHERE id = " . $user_id;
    $pdo->query($sql);
  }

  if ($old_user_id > 0) {
    $sql = "UPDATE game set user_id = " . $user_id . " WHERE user_id = " . $old_user_id;
    $pdo->query($sql);
  }

  echo ($user_id);
}

// -----------------------------------------------------------------------------

function getChangePasswordUser($activation_code)
{
  global $pdo;
  global $pw_salt;
  $user_id = 0;
  $retValue = new stdClass();

  $sql = "SELECT id FROM nov_user WHERE activation_code = '" . crypt($activation_code, $pw_salt) . "'";

  foreach ($pdo->query($sql) as $row) {
    $user_id =  $row['id'];
    break;
  }

  $retValue->user_id = $user_id;
  echo json_encode($retValue);
  return;
}

// -----------------------------------------------------------------------------

function updatePassword($activation_code, $user_password)
{
  global $pdo;
  global $pw_salt;

  $sql = "UPDATE nov_user set password = '" . crypt($user_password, $pw_salt) . "' WHERE activation_code = '" . crypt($activation_code, $pw_salt) . "'";
  $pdo->query($sql);

  echo "ok";
  return;
}

// -----------------------------------------------------------------------------

function saveLanguageToDb($user_id, $language)
{
  dbLog("saveLanguageToDb");
  dbLog("saveLanguageToDb, user_id = " .  $user_id . ", language = " .  $language);

  global $pdo;
  $sql = "UPDATE nov_user set language = '" . $language . "' WHERE id = " . $user_id;
  $pdo->query($sql);

  dbLog("vor return");
  echo "ok";
  return;
}

// -----------------------------------------------------------------------------

function updateIps()
{
  global $pdo;
  $retValue = new stdClass();

  /*
  $retValue->city = "Karlsruhe";  

  echo json_encode ($retValue);
*/

  $client = new HttpClient();
  $response = $client->get('http://ipinfo.io/66.249.70.123');

  echo $response->getStatusCode();

  /*
  echo $response->getBody();


  try {
	// get json
	$json = file_get_contents("");

  echo json_encode ($json);


	// convert json to object
	//$obj = json_decode($json);

  }catch (Exception $ex) {
	echo "ERROR: " . $ex->getMessage();
}
*/
}

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

  $sql = "select min(g.beginn) as min_beginn";
  $sql = $sql . " from game as g";
  $sql = $sql . " where g.score > 0  and g.user_id = " . $user_id;

  foreach ($pdo->query($sql) as $row) {
    $firstGame = novDateToString($row['min_beginn']);
    break;
  }

  $sql = "select max(g.beginn) as max_beginn";
  $sql = $sql . " from game as g";
  $sql = $sql . " where g.score > 0  and g.user_id = " . $user_id;

  foreach ($pdo->query($sql) as $row) {
    $lastGame = novDateToString($row['max_beginn']);
    break;
  }

  $sql = "select count(*) as cnt";
  $sql = $sql . " from game as g";
  $sql = $sql . " where g.ende is not null and g.user_id = " . $user_id;

  foreach ($pdo->query($sql) as $row) {
    $nrGames = $row['cnt'];
    break;
  }
  $response = [
    "firstGame" => $firstGame,
    "lastGame" => $lastGame,
    "nrGames" => $nrGames
  ];

  echo json_encode($response);
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




  echo json_encode($response);
}

// -----------------------------------------------------------------------------

function logRequestData($data)
{
  $logFile = 'request_log.txt';
  $timestamp = date('Y-m-d H:i:s');

  // Verwandelt das Array/Objekt in eine lesbare Struktur
  $formattedData = print_r($data, true);

  $entry = "[$timestamp] NEUE ANFRAGE:\n" . $formattedData . "\n" . str_repeat("-", 40) . "\n";

  // In die Datei schreiben (anhängen und sperren)
  file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
}

// -----------------------------------------------------------------------------


// Rohdaten vom Client empfangen
$rawInput = file_get_contents('php://input');
$decodedInput = json_decode($rawInput, true);

// Alles loggen, was ankommt:
/*
logRequestData([
    'URL' => $_SERVER['REQUEST_URI'],
    'METHOD' => $_SERVER['REQUEST_METHOD'],
    'RAW_JSON' => $rawInput,
    'DECODED' => $decodedInput
]);
*/

// Verhindert, dass Fehlermeldungen das JSON-Format zerstören
header('Content-Type: application/json');

// Hier empfangen wir die Daten vom JavaScript
$input = json_decode(file_get_contents('php://input'), true);

$functionname = $input['functionname'] ?? $_POST["functionname"];
$db_name = $input['db_name'] ?? $_POST["db_name"];

dbLog('functionname = ' . $functionname . ', db_name = ' . $db_name);

$user_id;
$language;
$pdo;
$activation_code;
$user_password;
$game_id;
$score;

//  $pw_hash = "$2y$10$SsMswRx3b467.KvMNXVI8e8ZtRiazudG8pTaWGQoupLVMdmMkpBX2"; 
$pw_salt = '$1$novotris$';

createPdo($db_name);

switch ($functionname) {

  // getestet:
  case 'logToDb':
    logToDb($_POST['nov_release'], $_POST['aktion'], $_POST['params'], $_POST['log_order']);
    break;

  // getestet:
  case 'readHighscoreFromDb':
    readHighscoreFromDb($_POST['level'], $_POST['mobile'], $_POST['user_id'], $_POST['mode'], $_POST['period']);
    break;

  // getestet:
  case 'readRankingPosition':
    readRankingPosition($_POST['level'], $_POST['mobile'], $_POST['user_id'], $_POST['mode']);
    break;

  // getestet:
  case 'getUserFromDb':
    getUserFromDb($_POST['id'], $_POST['mobile']);
    break;

  // getestet:
  case 'saveUserNameToDb':
    saveUserNameToDb($_POST['id'], $_POST['name']);
    break;

  // getestet:
  case 'startGameOnDb':
    startGameOnDb($_POST['user_id'], $_POST['nov_release'], $_POST['level'], $_POST['mode']);
    break;

  // getestet:
  case 'stopGameOnDb':
    $game_id = $input['game_id'] ?? $_POST["game_id"];
    $score = $input['score'] ?? $_POST["score"];
    stopGameOnDb($game_id, $score);
    break;

  // getestet:
  case 'saveLevelToDb':
    saveLevelToDb($_POST['user_id'], $_POST['level']);
    break;

  case 'createUserOnDb':
    createUserOnDb(
      $_POST['user_name'],
      $_POST['user_email'],
      $_POST['user_password'],
      $_POST['mobile'],
      $_POST['activation_code'],
      $_POST['old_user_id']
    );
    break;

  // getestet:
  case 'login':
    login($_POST['user_name'], $_POST['password'], $_POST['mobile']);
    break;

  case 'activate':
    activate($_POST['activation_code']);
    break;

  // getestet:
  case 'resetPassword':
    resetPassword($_POST['user_name'], $_POST['user_email'], $_POST['mobile'], $_POST['activation_code']);
    break;

  case 'getChangePasswordUser':
    getChangePasswordUser($_POST['activation_code']);
    break;

  case 'updatePassword':
    $activation_code = $input['activation_code'] ?? $_POST["activation_code"];
    $user_password = $input['user_password'] ?? $_POST["user_password"];
    updatePassword($activation_code, $user_password);
    break;

  // getestet:
  case 'saveLanguageToDb':
    $user_id = $input['user_id'] ?? $_POST["user_id"];
    $language = $input['language'] ?? $_POST["language"];
    saveLanguageToDb($user_id, $language);
    break;

  case 'updateIps':
    updateIps();
    break;

  // getestet:
  case 'getUserInfo':
    getUserInfo($input['user_id']);
    break;

  case 'getNovotrisInfo':
    getNovotrisInfo();
    break;
}

// -----------------------------------------------------------------------------
