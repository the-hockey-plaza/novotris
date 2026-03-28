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
	content="tetris, novotris, game, spiel, free, kostenlos, online, spielen,steidlinger">
<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">

<meta name="Author" content="Armin Steidlinger Softwareentwicklung">

<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

<link rel="alternate" hreflang="de" href="https://novotris.bplaced.net/de/play.php" />
<link rel="alternate" hreflang="en" href="https://novotris.bplaced.net/en/play.php" />
<link rel="alternate" hreflang="x-default" href="https://novotris.bplaced.net/de/play.php/" />

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

<body>
	<div class="pseudoBody">
		<div class="container" id="div-container">
						<div class="novHeader"
				style="border-top-left-radius: 4px; border-top-right-radius: 4px;">
				<div id="divTitle" style="flex: 80">
					<a class="animatedTitle" id="animatedTitle">Spielen</a>
				</div>
				<div style="flex: 20">
					<img src="../logo bing v8.jpg" width="135" height="auto"
						align="right" alt="novotris logo">
				</div>
			</div>

			<div class="novBody" style="display: flex;">
				<div style="flex: 70" id="div-play-frame">
					<div>
						<canvas id="mainCanvas"
							style="z-index: 1; width: 100px; height: 100px;">		
						</canvas>
					</div>
				</div>
				<div style="flex: 30">

					<div id="lbl_rows" class="game-data-label" style="margin-top: 1px">Rows</div>
					<div id="txt_rows" class="game-data-text">1234</div>
					<div id="lbl_speed" class="game-data-label" style="margin-top: 3px">Speed</div>
					<div id="txt_speed" class="game-data-text">1234</div>
					<div id="lbl_score" class="game-data-label" style="margin-top: 3px">Score</div>
					<div id="txt_score" class="game-data-text">1234</div>
					<div id="lbl_highscore" class="game-data-label"
						style="margin-top: 3px">Highscore</div>
					<div id="txt_highscore" class="game-data-text">1234</div>

					<div style="padding-top: 3px;"></div>

					<div class="game-data-label">
						Level<br> <select id="drp-play-level" class="drpMenu"
							style="width: 75px;">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
						</select>
					</div>

					<div class="game-data-label">
						Mode<br> <select id="drp-play-mode" class="drpMenu"
							style="width: 75px;">
							<option>classic</option>
							<option>speed</option>
						</select>
					</div>

								<div style="text-align: center; margin-top: 32px;">
						<!--  button class="play-button" id="do_start" onclick="do_start();">Start</button> -->
						<button class="animated-border-btn" id="do_start" onclick="do_start();">Start</button>
					</div>

				</div>
			</div>


		<div class="novFooter">
				<div class="row-footer-box">
					<a class="footer-label" href="<?= $nov_url_index ?>">Tetris World</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label-only" style="color: var(--play-color);">Play</a>
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
  	document.addEventListener('contextmenu', event => event.preventDefault());
	  var glUser = new User();
  	mainInit();
	  glUser.init(true);

		classDialog.initMessages();
		classDialog.init();
		
		initLoginRendering();		
		initStaticRendering();

		if (glUser.getId() > 0) {
			novInit();
			choose_level();
			classDialog.showLevelDialog();
		}
		
		$("body").fadeIn("slow");	
	</script>
</body>
</html>