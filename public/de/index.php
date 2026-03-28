<!DOCTYPE html>
<html lang="de">
<head>
<title>Novotris, the better Tetris kostenlos online spielen</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="description"
	content="Novotris: Tetris kostenlos online im Browser spielen, mit oder ohne Anmeldung, herausfordernde Varianten probieren, mit anderen Nutzern vergleichen und in Rangliste eintragen.">
<meta name="keywords"
	content="tetris, novotris">
<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
<meta name="Author" content="Armin Steidlinger Softwareentwicklung">

<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

<link rel="alternate" hreflang="de" href="https://novotris.bplaced.net/de/index.php" />
<link rel="alternate" hreflang="en" href="https://novotris.bplaced.net/en/index.php" />
<link rel="alternate" hreflang="x-default" href="https://novotris.bplaced.net/de/index.php/" />

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

<link rel="stylesheet" type="text/css" href="../novotris.css" />

<?php include '../php/navi.php'; ?>

</head>

<!-- ---------------------------------------------------- -->

<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id=G-9GL47VN2C7"
			height="0" width="0" style="display: none; visibility: hidden"></iframe>
	</noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div class="pseudoBody">
		<div class="container" id="div-container">
			<div class="novHeader"
				style="border-top-left-radius: 4px; border-top-right-radius: 4px;">

				<div style="flex: 70; display: flex; overflow: hidden;">

					<div class="marquee-container">
						<div class="marquee">Hier ist dein Platz zum Stöbern...Komm zum Staunen...Nur für echte Tetris-Fans...</div>
					</div>
				</div>

				<!-- 				<div id="lblTitle" style="flex: 80">Titel</div> -->

				<div style="flex: 20">
					<img src="../logo bing v8.jpg" width="135" height="auto"
						align="right" alt="novotris logo">
				</div>
			</div>

			<!-- 	<p>Spiele nur fÃ¼r dich oder messe dich mit anderen!</p> -->
			<!-- 					<p>Mache 1000 Punkte und gehe zum nÃ¤chsten Level!</p> -->
			<!-- 					<p>Sei gespannt auf neue Features!</p> -->

			<div class="novBody">
				<table style="margin-top: 40px;">
					<tr>
						<td width="60%">
							<p
								style="margin-top: 10; padding-left: 28px;">
								Alle News und Facts zu Novotris seit Beginn im Überblick. Wer
								Interesse an der Entstehungsgeschichte von Novotris hat oder
								einfach interessante Fakten zu Tetris nachlesen möchte, ist <a
									href="<?= $nov_url_news ?>">hier</a> genau richtig.
							</p>
						</td>
						<td width="40%">
							<p style="margin-top: 10" align="center">
								<a href="news.php"><img
									src="../pictures/newspaper-1753579_640.jpg" width="140"
									height="auto"></a>

							</p>
						</td>
					</tr>
				</table>

				<table>
					<tr>
						<td width="40%">
							<p style="margin-top: 25" align="center">
								<a href="alternatives.php"><img
									src="../pictures/running-78192_640.jpg" width="140"
									height="auto"></a>
							</p>
						</td>

						<td width="60%">
							<p
								style="margin-top: 15;  padding-left: 8px; padding-right: 24px;">
								Ein Blick zur Konkurrenz schadet nicht, denn es gibt unfassbar
								viele Seiten, wo man Tetris im Browser spielen kann. Eine kleine
								Auswahl findest du <a href="<?= $nov_url_alternatives ?>">hier</a>.
							</p>
						</td>
					</tr>
				</table>

				<table>
					<tr>
						<td width="60%">
							<p
								style="margin-top: 10; padding-left: 28px;">
								<a href="<?= $nov_url_bonanza ?>">Hier</a> findest du eine große Auswahl an
								Beiträgen rund um Tetris, die dich vermutlich staunen lassen.
								Man ahnt es kaum, wer sich schon alles mit damit auseinander
								gesetzt hat und die verschiedenen Aspekte dieses Klassikers
								beleuchtet hat.
						</td>
						<td width="40%">
							<p style="margin-top: 10" align="center">
								<a href="bonanza.php"><img
									src="../pictures/globe-967305_640.jpg" width="140"
									height="auto"></a>
							</p>
						</td>
					</tr>
				</table>
			</div>


				<div class="novFooter">
				<div class="row-footer-box">
					<a class="footer-label-only">Tetriswelt</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" onmouseover="this.style.cursor='pointer'"
						href="<?= $nov_url_play ?>" style="color: var(--play-color);">Spielen</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" onmouseover="this.style.cursor='pointer'"
						href="<?= $nov_url_ranking ?>">Ranglisten</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" onmouseover="this.style.cursor='pointer'"
						href="<?= $nov_url_help ?>">Anleitung</a>
				</div>
			</div>

			<div class="novFooter"
				style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
				<div class="row-footer-box">
					<a id="footer-user" class="footer-label"
						onmouseover="this.style.cursor='pointer'" onclick="showUserInfoDialog();"></a>
				</div>
				<div class="row-footer-box">
					<a id="footer-login" class="footer-label"
						onclick="glUser.loginLogout('index.php')"
						onmouseover="this.style.cursor='pointer'"></a>
				</div>
				<div class="row-footer-box">
					<a id="footer-version" class="footer-label"
						onmouseover="this.style.cursor='pointer'" onclick="showNovotrisInfoDialog();">Version</a>
				</div>
				<div class="row-footer-box" style="margin-left: 0px;">
					<!-- 									<a id="footer-label">footer-label</a> -->
					<select id="drp-language" class="footer-label"
						style="padding-left: 1.0em;">
						<option>deutsch</option>
						<option>english</option>
					</select>
				</div>
			</div>
		</div>

	</div>

	<!-- ---------------------------------------------------- -->

	<div class="standardmessage" id="div-message-dialog"
		style="position: absolute; z-index: 4; flex-direction: column; display: none; overflow: hidden;">
		<div
			style="flex: 15; font-size: 16pt; margin-top: 30px; margin-bottom: 1px; margin-left: 25px; margin-right: 25px">
			<span id="span-msg-header">msg-header</span>
		</div>
		<div
			style="flex: 70; overflow-y: auto; font-size: 12pt; margin-top: 1px; margin-left: 25px; margin-right: 25px">
			<span id="span-msg-text">msg-txt</span>
		</div>

		<div style="flex: 15; margin-top: 15px;">
			<button id="btn_msg_ok" class="dialog-button-modal"
				onclick="classDialog.msgDialogOk()">OK</button>
		</div>
	</div>

	<div id="div-cnv-message" style="position: absolute; z-index: 3;">
		<canvas id="cnv-message" style="z-index: 3;" hidden="true"></canvas>
	</div>


	<!-- ---------------------------------------------------- -->

	<script src="https://code.jquery.com/jquery-latest.js"></script>

	<script
		src="../js/global.js?v=<?php echo filemtime('../js/global.js'); ?>"></script>
	<script src="../js/user.js?v=<?php echo filemtime('../js/user.js'); ?>"></script>
	<script src="../js/main.js?v=<?php echo filemtime('../js/main.js'); ?>"></script>
	<script src="../js/data.js?v=<?php echo filemtime('../js/data.js'); ?>"></script>
	<script
		src="../js/highscore.js?v=<?php echo filemtime('../js/highscore.js'); ?>"></script>
	<script
		src="../js/rendering.js?v=<?php echo filemtime('../js/rendering.js'); ?>"></script>
	<script
		src="../js/preview.js?v=<?php echo filemtime('../js/preview.js'); ?>"></script>
	<script
		src="../js/novotris.js?v=<?php echo filemtime('../js/novotris.js'); ?>"></script>
	<script
		src="../js/swipe.js?v=<?php echo filemtime('../js/swipe.js'); ?>"></script>
	<script
		src="../js/dialog.js?v=<?php echo filemtime('../js/dialog.js'); ?>"></script>

	<script>
		document.addEventListener('DOMContentLoaded', onContentLoaded, false); // currently empty!
		var glUser = new User();

		mainParseURL();
		mainInit();


		glUser.init(false);
		classDialog.initMessages();
		classDialog.init();
		mainUpdateFooter();

		$("body").fadeIn("slow");
	</script>
</body>
</html>