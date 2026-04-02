<!DOCTYPE html>
<html lang="de">

<head>
	<title>Novotris, the better Tetris</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Novotris - das bessere Tetris! Kostenloses Online-Spiel mit herausfordernden Levels, Multiplayer-Ranking und täglich neuen Herausforderungen. Jetzt spielen!">
	<meta name="keywords" content="tetris, novotris, game, spiel, free, kostenlos, online, spielen,steidlinger">
	<meta name="copyright" content="Armin Steidlinger Softwareentwicklung">
	<meta name="author" content="Armin Steidlinger Softwareentwicklung">
	<link rel="icon" type="image/x-icon" href="icons/novotris-icon.png">
	<link rel="preconnect" href="https://www.googletagmanager.com">
	<link rel="preconnect" href="https://pagead2.googlesyndication.com">
	<link rel="preconnect" href="https://code.jquery.com">

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

	<script async
		src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3877246794602664"
		crossorigin="anonymous"></script>

</head>

<body>
	<!-- Fallback für Nutzer ohne JavaScript -->
	<noscript>
		<p style="text-align:center;padding:20px;">
			JavaScript ist erforderlich, um das Spiel zu spielen. Bitte aktivieren Sie JavaScript in Ihrem Browser.
		</p>
	</noscript>

	<script src="https://code.jquery.com/jquery-3.6.4.min.js"
		integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
		crossorigin="anonymous"></script>

	<script src="js/global.js?v=<?php echo @filemtime(__DIR__ . '/js/global.js') ?: time(); ?>"></script>
	<script src="js/user.js?v=<?php echo @filemtime(__DIR__ . '/js/user.js') ?: time(); ?>"></script>
	<script src="js/main.js?v=<?php echo @filemtime(__DIR__ . '/js/main.js') ?: time(); ?>"></script>


	<script>
		try {
			const urlParams = new URLSearchParams(window.location.search);
			const glUser = new User();

			glUser.init(false);

			if (urlParams.get('m') > 0)
				glIsMobile = true;
			else
				mainMobileAndTabletCheck();

			if (glIsMobile)
				window.location.href = 'de/no-mobile.html';
			else {
				const lang = glUser.getLanguage();
				let newUrl = lang + '/play.php';
				const resetParam = urlParams.get('reset');
				if (resetParam != null)
					newUrl += "?reset=" + resetParam;

				window.location.href = newUrl;
			}
		} catch (error) {
			console.error('Fehler beim Laden der Anwendung:', error);
			window.location.href = 'de/index.php';
		}
	</script>
</body>

</html>