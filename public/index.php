<?php
// Root entry point: immediately redirect to localized play page.
$lang = 'de';

if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
	$accepted = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	if ($accepted === 'en') {
		$lang = 'en';
	}
}

$target = $lang . '/play.php';

if (isset($_GET['reset']) && $_GET['reset'] !== '') {
	$target .= '?reset=' . rawurlencode($_GET['reset']);
}

header('Location: ' . $target, true, 302);
exit;
