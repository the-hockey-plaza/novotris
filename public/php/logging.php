<?php

function doSquare ($x) {
return $x*$x;
}

// -----------------------------------------------------------------------------

function getIp() {
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach($keys as $k) {
        if (isset($_SERVER[$k]) && !empty($_SERVER[$k]) && filter_var($_SERVER[$k], FILTER_VALIDATE_IP)) {
            return $_SERVER[$k];
        }
    }

    return null;
}


// -----------------------------------------------------------------------------

function myLog ($msg) {
$ip = getIp();
$hostname = gethostbyaddr ($ip);
$timestamp = date('Y-m-d H:i:s a', time());
//$location = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
//$location = file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip);
//$location = file_get_contents('http://google.com');
$location = "test";

$myfile = fopen("logfile.txt", "a") or die("Unable to open file!");
fwrite($myfile, "[" . $timestamp . "]" . "\t");
fwrite($myfile, $ip . "\t");
fwrite($myfile, $msg . "\n");
fclose($myfile);
}

/*
function clientIpAddress(){
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $address = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $ address = $_SERVER['REMOTE_ADDR'];
  }
  return $address;
}
*/

/*
<?php
$location = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
?>
*/

// -----------------------------------------------------------------------------

  $x = $_POST["x"];

  switch($_POST["functionname"]){

        case 'doSquare':
            doSquare($x);
            break;

        case 'myLog':
					myLog($_POST['arguments']);
            break;
    }



?>