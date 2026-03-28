<?php

/*
 * mail.php
 */

function sendActivationMail ($to, $activation_code, $user_name, $user_language) {
  $subject = "Registrierung Novotris";
 
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "From: novotris@steidlinger.de\r\n";
  $url = "https://novotris.bplaced.net/" . $user_language . "/index.php?activate=" . $activation_code;

  $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  				<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					</head>
					<body>
						<div>
							<p>Hallo ' . $user_name . ',<br><br>
								bitte klicke auf den folgenden Link, um deinen Novotris-Account zu aktivieren:<br><br>
  							<a href=' . $url . '>' . $url . '</a><br><br>
							  Vielen Dank f&uuml;r deine Beteiligung!
							</p>
						</div>
					</body>
 				</html>';

/*
  $body = 'Hallo,\n
			bitte klicke auf den folgenden Link, um deinen Novotris-Account zu aktivieren:\n
  		http://novotris.bplaced.net/home.html?activate=" . $activation_code;
*/

  mail($to, $subject, $body, $headers);

  echo "sendActivationMail ok";
}

// -----------------------------------------------------------------------------

function sendResetPasswordMail ($to, $activation_code, $user_name) {
  $subject = "Novotris Passwort Reset";
 
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "From: novotris@steidlinger.de" . "\r\n";
  $url = "https://novotris.bplaced.net/index.php?reset=" . $activation_code;

  $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  				<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					</head>
					<body>
						<div>
							<p>Hallo ' . $user_name . ',<br><br>
								bitte klicke auf den folgenden Link, um dein Novotris-Passwort neu zu setzen:<br><br>
  							<a href=' . $url . '>' . $url . '</a><br><br>
							  Weiterhin viel Spa&szlig; beim Spielen!
							</p>
						</div>
					</body>
 				</html>';

/*
  $body = 'Hallo,\n
			bitte klicke auf den folgenden Link, um deinen Novotris-Account zu aktivieren:\n
  		http://novotris.bplaced.net/home.html?activate=" . $activation_code;
*/

  mail($to, $subject, $body, $headers);

  echo "sendResetPasswordMail ok";
}

// -----------------------------------------------------------------------------

function sendSysLoadMail ($mail_content) {
  $subject = "Novotris Alert";
  $to = "armin@steidlinger.de";
 
echo "sendSysLoadMail mail_content = " . $mail_content;

  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "From: novotris@steidlinger.de" . "\r\n";
 
  $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  				<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					</head>
					<body>
						<div>
							<p>' . $mail_content . '
							</p>
						</div>
					</body>
 				</html>';

  mail($to, $subject, $body, $headers);

  echo "sendSysLoadMail ok";
}

// -----------------------------------------------------------------------------

 switch($_POST["functionname"]){
   
   case 'sendActivationMail':
	 	sendActivationMail($_POST['to'], $_POST['activation_code'], $_POST['user_name'], $_POST['user_language']);
       break;

   case 'sendResetPasswordMail':
	   sendResetPasswordMail($_POST['to'], $_POST['activation_code'], $_POST['user_name']);
     break;

   case 'sendSysLoadMail':
	   sendSysLoadMail($_POST['mail_content']);
     break;

    }


// -----------------------------------------------------------------------------


?>