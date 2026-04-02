<?php

const LOG_FILE = __DIR__ . '/logfile.txt';
const IP_KEYS = [
  'HTTP_CLIENT_IP',
  'HTTP_X_FORWARDED_FOR',
  'HTTP_X_FORWARDED',
  'HTTP_FORWARDED_FOR',
  'HTTP_FORWARDED',
  'REMOTE_ADDR'
];

function getIp()
{
  foreach (IP_KEYS as $key) {
    if (isset($_SERVER[$key]) && !empty($_SERVER[$key])) {
      if (filter_var($_SERVER[$key], FILTER_VALIDATE_IP)) {
        return $_SERVER[$key];
      }
    }
  }
  return null;
}

function myLog($msg)
{
  if (!is_string($msg) || empty($msg)) {
    return false;
  }

  $ip = getIp() ?? 'UNKNOWN';
  $timestamp = date('Y-m-d H:i:s a');
  $logEntry = sprintf("[%s]\t%s\t%s\n", $timestamp, $ip, $msg);

  if (@file_put_contents(LOG_FILE, $logEntry, FILE_APPEND | LOCK_EX) === false) {
    error_log("Logging failed: " . $logEntry);
    return false;
  }

  return true;
}

// Verarbeite eingehende Anfragen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['functionname'])) {
  if ($_POST['functionname'] === 'myLog' && isset($_POST['arguments'])) {
    myLog(trim($_POST['arguments']));
  }
}
