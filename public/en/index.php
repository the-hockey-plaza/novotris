<!DOCTYPE html>
<html lang="en">

<head>
	<title>Novotris, the better Tetris play online free</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description"
		content="Novotris: Play Tetris online for free in your browser, try out challenging variants, compete with other users and enter the rankings.">
	<meta name="keywords"
		content="tetris, novotris">
	<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
	<meta name="Author" content="Armin Steidlinger Softwareentwicklung">

	<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

	<link rel="alternate" hreflang="de" href="https://novotris.bplaced.net/de/index.php" />
	<link rel="alternate" hreflang="en" href="https://novotris.bplaced.net/en/index.php" />
	<link rel="alternate" hreflang="x-default" href="https://novotris.bplaced.net/de/index.php" />
	<link rel="canonical" href="https://novotris.bplaced.net/en/index.php" />

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
						<div class="marquee">This is your place to browse...Come and be amazed...Only for true Tetris fans...</div>
					</div>
				</div>

				<!-- 				<div id="lblTitle" style="flex: 80">Titel</div> -->

				<div style="flex: 20">
					<img src="../images/logo bing v8.jpg" width="135" height="auto"
						align="right" alt="novotris logo" alt="novotris logo">
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
								If you are interested in the history of Novotris or simply want
								to read interesting facts about Tetris, <a href="news.php">this</a>
								is the right place.
							</p>
						</td>
						<td width="40%">
							<p style="margin-top: 10" align="center">
								<a href="<?= $nov_url_news ?>"><img
										src="../images/newspaper-1753579_640.jpg" width="140"
										height="auto"></a>

							</p>
						</td>
					</tr>
				</table>

				<table>
					<tr>
						<td width="40%">
							<p style="margin-top: 25" align="center">
								<a href="<?= $nov_url_alternatives ?>"><img
										src="../images/running-78192_640.jpg" width="140"
										height="auto"></a>
							</p>
						</td>

						<td width="60%">
							<p
								style="margin-top: 15; padding-left: 8px; padding-right: 24px;">
								It doesn't hurt to take a look at the competition, because there are unbelievably
								many sites where you can play Tetris in the browser. A small
								selection you can find <a href="<?= $nov_url_alternatives ?>">here</a>.
							</p>
						</td>
					</tr>
				</table>

				<table>
					<tr>
						<td width="60%">
							<p
								style="margin-top: 10; padding-left: 28px;">
								<a href="bonanza.php">Here</a> you will find a large selection of
								articles about Tetris, which will probably amaze you. One
								hardly guess who has already dealt with it and who has
								illuminated the different aspects of this classic game.
						</td>
						<td width="40%">
							<p style="margin-top: 10" align="center">
								<a href="<?= $nov_url_bonanza ?>"><img
										src="../images/globe-967305_640.jpg" width="140"
										height="auto"></a>
							</p>
						</td>
					</tr>
				</table>
			</div>


			<div class="novFooter">
				<div class="row-footer-box">
					<a class="footer-label-only">Tetris World</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label"
						href="<?= $nov_url_play ?>" style="color: var(--play-color); cursor: pointer;">Play</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" style="cursor: pointer;"
						href="<?= $nov_url_ranking ?>">Rankings</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" style="cursor: pointer;"
						href="<?= $nov_url_help ?>">Help</a>
				</div>
			</div>

			<div class="novFooter"
				style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
				<div class="row-footer-box">
					<a id="footer-user" class="footer-label"
						style="cursor: pointer;" onclick="showUserInfoDialog();"></a>
				</div>
				<div class="row-footer-box">
					<a id="footer-login" class="footer-label"
						onclick="glUser.loginLogout('index.php')"
						style="cursor: pointer;"></a>
				</div>
				<div class="row-footer-box">
					<a id="footer-version" class="footer-label"
						style="cursor: pointer;" onclick="showNovotrisInfoDialog();">Version</a>
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

		mainUpdateFooter();
		classDialog.initMessages();
		classDialog.init();

		$("body").fadeIn("slow");
	</script>
</body>

</html>