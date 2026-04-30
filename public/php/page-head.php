<?php
$pageLang = $pageLang ?? 'de';
$pageTitle = $pageTitle ?? 'Novotris, the better Tetris';
$pageDescription = $pageDescription ?? '';
$pageKeywords = $pageKeywords ?? '';
$canonicalUrl = $canonicalUrl ?? '';
$alternateDeUrl = $alternateDeUrl ?? '';
$alternateEnUrl = $alternateEnUrl ?? '';
$alternateXDefaultUrl = $alternateXDefaultUrl ?? '';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($pageLang, ENT_QUOTES, 'UTF-8') ?>">

<head>
	<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
	<meta name="keywords" content="<?= htmlspecialchars($pageKeywords, ENT_QUOTES, 'UTF-8') ?>">
	<meta name="copyright" content="Armin Steidlinger Softwareentwicklung">
	<meta name="author" content="Armin Steidlinger Softwareentwicklung">

	<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

	<link rel="alternate" hreflang="de" href="<?= htmlspecialchars($alternateDeUrl, ENT_QUOTES, 'UTF-8') ?>" />
	<link rel="alternate" hreflang="en" href="<?= htmlspecialchars($alternateEnUrl, ENT_QUOTES, 'UTF-8') ?>" />
	<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($alternateXDefaultUrl, ENT_QUOTES, 'UTF-8') ?>" />
	<link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>" />

	<link rel="preconnect" href="https://www.googletagmanager.com">
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async
		src="https://www.googletagmanager.com/gtag/js?id=G-9GL47VN2C7"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'G-9GL47VN2C7');
	</script>

	<link rel="stylesheet" type="text/css" href="../css/novotris.css" />

	<?php include '../php/navi.php'; ?>

</head>

<!-- ---------------------------------------------------- -->

<body>