<!DOCTYPE html>
<html>
<head>
<title>Novotris, the better Tetris play online free</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="description"
	content="Novotris: Play Tetris online for free in your browser, try out challenging variants, compete with other users and enter the rankings.">
<meta name="keywords"
	content="tetris, alternatives>
<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
<meta name="Author" content="Armin Steidlinger Softwareentwicklung">

<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

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
	<div class="pseudoBody">
		<div class="container" id="div-container">
			<div class="novHeader"
				style="border-top-left-radius: 4px; border-top-right-radius: 4px;">
				<div id="lblTitle"
					style="flex: 80; font-size: 36px; padding-top: 40px;">Novotris
					is not alone...</div>
				<div style="flex: 20">
					<img src="../logo bing v8.jpg" width="135" height="auto"
						align="right" alt="novotris logo">
				</div>
			</div>

			<div class="novBody">
				<div
					style="margin-top: 25; font-size: 16px; padding-left: 32px; padding-right: 32px;">
					There are an incredible number of variants of this classic game. We
					list some of them here; of course, all of the games shown here are
					games shown here are free and can be played directly online in the
					browser. <br>

					<ul style="line-height: 120%">
						<li>Reissued: <br> <a
							href="https://www.gamesbasis.com/games/classic/tetris/">gamesbasis</a></li>
						<br>
						<li>Not only for kids: <br> <a
							href="https://www.geo.de/geolino/spiele/13349-rtkl-onlinespiel-tetris">Tetris
								at Geolino</a></li>
						<br>
						<li>Not only for seniors: <br> <a
							href="https://www.50plus.de/spiele/tetris.html">The
								50plus-Games</a></li>
						<br>
						<li>Not a fairy tale: <br> <a
							href="https://www.1001spiele.de/g/tetris">1001 Games</a></li>
						<br>
						<li>At Migano in double pack: <br> <a
							href="https://migano.de/tetris.php">Tetris</a> <a
							href="https://migano.de/tetris_deluxe.php">Tetris Deluxe</a></li>
						<br>
						<li>Very popular: <br> <a
							href="https://tetris.com/play-tetris">Play Tetris</a></li>
						<br>
						<li>More than just games: <br> <a
							href="https://www.bernhard-gaul.de/spiele/tetris/tetris.php">Bernhard
								Gaul's website</a></li>
						<br>
						<li>Probably most users: <br> <a href="https://tetr.io">TETR.IO</a></li>
						<br>
						<li>Special Challenges: <br> <a
							href="https://kingofstackers.com/">King of Stackers</a></li>
						<br>
						<li>Schedule time for commercials: <br> <a
							href="https://spielspiele.de/tetris-spiel/">SPIELSPIELE</a></li>
						<br>
						<li>Rather not so exciting: <br> <a
							href="https://www.spielaffe.de/Spiel/Tetris/">spielaffe</a></li>
						<br>
						<li>There are variants with pre-filled fields: <br> <a
							href="https://de.games68.com/games.php?id=8836/">Games68</a></li>
						<br>
						<li>Apart from the nice 3D look, rather bland: <br> <a
							href="https://www.silvergames.com/de/tetris/">Silver Games</a></li>
						<br>
						<li>Well...<br> <a
							href="https://www.silvergames.com/de/tetris/">t-online calls
								it Tetra</a></li>
						<br>
					</ul>

					</ul>
				</div>
			</div>

			<div class="novFooter">
				<div class="row-footer-box">
					<a class="footer-label" href="<?= $nov_url_index ?>">Tetris
						World</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" onmouseover="this.style.cursor='pointer'"
						href="<?= $nov_url_play ?>" style="color: var(--play-color);">Play</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" onmouseover="this.style.cursor='pointer'"
						href="<?= $nov_url_ranking ?>">Rankings</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" onmouseover="this.style.cursor='pointer'"
						href="<?= $nov_url_help ?>">Help</a>
				</div>
			</div>

			<div class="novFooter"
				style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
				<div class="row-footer-box">
					<a id="footer-user" class="footer-label"
						onmouseover="this.style.cursor='pointer'"
						onclick="showUserInfoDialog();"></a>
				</div>
				<div class="row-footer-box">
					<a id="footer-login" class="footer-label"
						onclick="glUser.loginLogout('index.php')"
						onmouseover="this.style.cursor='pointer'"></a>
				</div>
				<div class="row-footer-box">
					<a id="footer-user3" class="footer-label"
						onmouseover="this.style.cursor='pointer'"
						onclick="showNovotrisInfoDialog();">Version</a>
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
	<script
		src="../js/novotris.js?v=<?php echo filemtime('../js/novotris.js'); ?>"></script>
	<script
		src="../js/dialog.js?v=<?php echo filemtime('../js/dialog.js'); ?>"></script>

	<script>
		document.addEventListener('DOMContentLoaded', onContentLoaded, false); // currently empty!
		var glUser = new User();

		mainInit();
		glUser.init(false);

		classDialog.initMessages();
		classDialog.init();

		mainUpdateFooter();
		$("body").fadeIn("slow");
	</script>
</body>
</html>