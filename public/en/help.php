<!DOCTYPE html>
<html>

<head>
	<title>Tetris Instructions &amp; Rules – Novotris</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width">
	<meta name="description"
		content="Tetris rules and instructions for Novotris: getting started, level system, speed, game modes and highscore tips – all at a glance.">
	<meta name="keywords"
		content="tetris, instructions">
	<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
	<meta name="Author" content="Armin Steidlinger Softwareentwicklung">

	<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

	<link rel="alternate" hreflang="de" href="https://novotris.bplaced.net/de/help.php" />
	<link rel="alternate" hreflang="en" href="https://novotris.bplaced.net/en/help.php" />
	<link rel="alternate" hreflang="x-default" href="https://novotris.bplaced.net/de/help.php" />
	<link rel="canonical" href="https://novotris.bplaced.net/en/help.php" />

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
	<!-- Google Tag Manager (noscript) -->
	<noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id=G-9GL47VN2C7"
			height="0" width="0" style="display: none; visibility: hidden"></iframe>
	</noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div class="pseudoBody">
		<div class="container" id="div-container">
			<div class="novHeader nov-header-rounded">
				<h1 id="lblTitle" class="nov-title-area lbl-title-compact">Tetris Instructions &amp; Rules</h1>
				<div class="nov-logo-area">
					<picture>
						<source srcset="../images/novotris-logo.webp" type="image/webp">
						<img src="../images/novotris-logo.jpg" width="135" height="auto"
							align="right" alt="Novotris - Play Tetris for Free">
					</picture>
				</div>
			</div>

			<div class="novBody help-layout">

				<h2 class="help-header">Getting Started</h2>
				<div class="help-text">You can - without registration - as a
					guest play a little game right away. But it is recommended to create
					an account via "Login" in the footer and then "Register" to create
					an account. This way you are more independent and can play with this
					user on other computers. For mobile devices separate accounts and
					rankings are created. Furthermore your results are saved, even if
					you have deleted the browser history, for example.</div>

				<h2 class="help-header">Language selection</h2>
				<div class="help-text">At the bottom right of the start page
					there is a drop-down menu, with which you can set the desired
					language (german or English).</div>

				<h2 class="help-header">Playing</h2>
				<div class="help-text">
					From the start page you can get to the preview of the different
					levels by clicking on the different levels (selectable via the menu
					in the upper right corner). The right arrow symbol (or alternatively
					the "P" key) starts the game. If this button shows a pause symbol,
					you can pause the game and continue it afterwards (both with "P" as
					well). (both also using "P").<br> <br>During the game use
					<i>right arrow</i> and <i>left arrow</i> to move the falling stone
					horizontal. <i>Arrow up</i> you need to rotate the stone by 90
					degrees to the left. With <i>arrow down</i> you can accelerate the
					speed down. You can also use the space bar to drop the stone
					immediately.<br> <br> On mobile devices, these actions are
					performed by swiping or tapping on the screen. If you like, you can
					also use the icons above the footer. Just try it!
				</div>

				<h2 class="help-header">Speed</h2>
				<div class="help-text">After every 5 rows that are complete and
					therefore disappear from the game, the speed increases by 10
					percent. After all, it should not become boring. At the beginning,
					the speed is leisurely: it is one field per second. .</div>

				<h2 class="help-header">Level</h2>
				<div class="help-text">When you play Novotris for the first
					time, only the first level is available. As soon as you have a
					highscore of at least 1000 (750 for mobile devices), the next level
					will be unlocked.</div>

				<h2 class="help-header">Collecting Score Points</h2>
				<div class="help-text">Your score increases with each new stone
					that enters the game. The number of points varies depending on the
					difficulty level; this is especially interesting in the higher
					levels. The highscore is calculated for each level separately; but
					will only be saved when you finish the game.</div>

				<h2 class="help-header">Game mode</h2>
				<div class="help-text">There are currently two variants of the
					game mode. In "classic", each stone has its fixed number of points;
					however, it may vary between levels. In "speed", the faster the
					stone reaches the bottom, the more points it gets. So it is
					worthwhile to drop the stone as quickly as possible! Because of the
					different counting methods, there are of course separate rankings
					for each game mode.</div>

				<h2 class="help-header">Rankings</h2>
				<div class="help-text">For the rankings there are different
					variants. Either you can see the best result of each player or all
					your own results. You can also select a level or view all levels
					together in one table. Since the points are counted differently
					depending on the game mode, there are separate rankings for them;
					accordingly, the mode can also be selected here.</div>
				<h2 class="help-header">Have fun!</h2>
				<div class="help-tail-space"></div>
			</div>

			<div class="novFooter">
				<div class="row-footer-box">
					<a class="footer-label" href="<?= $nov_url_index ?>">Tetris World</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" href="<?= $nov_url_play ?>" style="color: var(--play-color);">Play</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" href="<?= $nov_url_ranking ?>">Rankings</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label-only">Help</a>
				</div>
			</div>

			<div class="novFooter nov-footer-bottom">
				<div class="row-footer-box">
					<a id="footer-user" class="footer-label" onclick="showUserInfoDialog();"></a>
				</div>
				<div class="row-footer-box">
					<a id="footer-login" class="footer-label" onclick="glUser.loginLogout('index.php')"></a>
				</div>
				<div class="row-footer-box">
					<a id="footer-version" class="footer-label" onclick="showNovotrisInfoDialog();">Version</a>
				</div>
				<div class="row-footer-box footer-language-box">
					<!-- 									<a id="footer-label">footer-label</a> -->
					<select id="drp-language" class="footer-label">
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