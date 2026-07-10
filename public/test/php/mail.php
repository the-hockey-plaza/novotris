<?php

const FROM_EMAIL = 'novotris@steidlinger.de';
const BASE_URL = 'https://novotris.bplaced.net/';
const ADMIN_EMAIL = 'armin@steidlinger.de';

const MAIL_HEADERS = [
	'MIME-Version' => '1.0',
	'Content-type' => 'text/html; charset=UTF-8'
];

function getHtmlTemplate($title, $content)
{
	return "<!DOCTYPE html>\r\n" .
		"<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n" .
		"<head>\r\n" .
		"    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n" .
		"    <title>" . htmlspecialchars($title) . "</title>\r\n" .
		"</head>\r\n" .
		"<body>\r\n" .
		"    <div>" . $content . "</div>\r\n" .
		"</body>\r\n" .
		"</html>";
}

function buildHeaders($from = FROM_EMAIL)
{
	$headers = [];
	foreach (MAIL_HEADERS as $key => $value) {
		$headers[] = "$key: $value";
	}
	$headers[] = "From: $from";
	return implode("\r\n", $headers);
}

function sendMail($to, $subject, $body, $from = FROM_EMAIL)
{
	if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
		error_log('Invalid email: ' . $to);
		return false;
	}

	$headers = buildHeaders($from);
	return mail($to, $subject, $body, $headers);
}

function sendActivationMail($to, $activation_code, $user_name, $user_language)
{
	$user_name = htmlspecialchars($user_name);
	$url = BASE_URL . urlencode($user_language) . '/index.php?activate=' . urlencode($activation_code);

	$content = "<p>Hallo $user_name,<br /><br />" .
		"bitte klicke auf den folgenden Link, um deinen Novotris-Account zu aktivieren:<br /><br />" .
		"<a href=\"$url\">$url</a><br /><br />" .
		"Vielen Dank für deine Beteiligung!</p>";

	$body = getHtmlTemplate('Registrierung Novotris', $content);

	return sendMail($to, 'Registrierung Novotris', $body);
}

function sendResetPasswordMail($to, $activation_code, $user_name)
{
	$user_name = htmlspecialchars($user_name);
	$url = BASE_URL . 'index.php?reset=' . urlencode($activation_code);

	$content = "<p>Hallo $user_name,<br /><br />" .
		"bitte klicke auf den folgenden Link, um dein Novotris-Passwort neu zu setzen:<br /><br />" .
		"<a href=\"$url\">$url</a><br /><br />" .
		"Weiterhin viel Spaß beim Spielen!</p>";

	$body = getHtmlTemplate('Novotris Passwort Reset', $content);

	return sendMail($to, 'Novotris Passwort Reset', $body);
}

function sendSysLoadMail($mail_content)
{
	$body = getHtmlTemplate('Novotris Alert', "<p>$mail_content</p>");

	return sendMail(ADMIN_EMAIL, 'Novotris Alert', $body);
}

// Verarbeite eingehende Anfragen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['functionname'])) {
	$functionname = trim($_POST['functionname']);

	switch ($functionname) {
		case 'sendActivationMail':
			if (isset($_POST['to'], $_POST['activation_code'], $_POST['user_name'], $_POST['user_language'])) {
				sendActivationMail($_POST['to'], $_POST['activation_code'], $_POST['user_name'], $_POST['user_language']);
			}
			break;

		case 'sendResetPasswordMail':
			if (isset($_POST['to'], $_POST['activation_code'], $_POST['user_name'])) {
				sendResetPasswordMail($_POST['to'], $_POST['activation_code'], $_POST['user_name']);
			}
			break;

		case 'sendSysLoadMail':
			if (isset($_POST['mail_content'])) {
				sendSysLoadMail($_POST['mail_content']);
			}
			break;
	}
}
