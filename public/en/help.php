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
	content="tetris, instructions">
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
				<div id="lblTitle" style="flex: 80">Game Instructions</div>
				<div style="flex: 20">
					<img src="../logo bing v8.jpg" width="135" height="auto"
						align="right" alt="novotris logo">
				</div>
			</div>

			<div class="novBody">

				<div class="help-header">Getting Started</div>
			<div class="help-text">You can - without registration - as a
				guest play a little game right away. But it is recommended to create
				an account via "Login" in the footer and then "Register" to create
				an account. This way you are more independent and can play with this
				user on other computers. For mobile devices separate accounts and
				rankings are created. Furthermore your results are saved, even if
				you have deleted the browser history, for example.</div>

			<div class="help-header">Language selection</div>
			<div class="help-text">At the bottom right of the start page
				there is a drop-down menu, with which you can set the desired
				language (german or English).</div>

			<div class="help-header">Playing</div>
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

			<div class="help-header">Speed</div>
			<div class="help-text">After every 5 rows that are complete and
				therefore disappear from the game, the speed increases by 10
				percent. After all, it should not become boring. At the beginning,
				the speed is leisurely: it is one field per second. .</div>

			<div class="help-header">Level</div>
			<div class="help-text">When you play Novotris for the first
				time, only the first level is available. As soon as you have a
				highscore of at least 1000 (750 for mobile devices), the next level
				will be unlocked.</div>

			<div class="help-header">Collecting Score Points</div>
			<div class="help-text">Your score increases with each new stone
				that enters the game. The number of points varies depending on the
				difficulty level; this is especially interesting in the higher
				levels. The highscore is calculated for each level separately; but
				will only be saved when you finish the game.</div>

			<div class="help-header">Game mode</div>
			<div class="help-text">There are currently two variants of the
				game mode. In "classic", each stone has its fixed number of points;
				however, it may vary between levels. In "speed", the faster the
				stone reaches the bottom, the more points it gets. So it is
				worthwhile to drop the stone as quickly as possible! Because of the
				different counting methods, there are of course separate rankings
				for each game mode.</div>

			<div class="help-header">Rankings</div>
			<div class="help-text">For the rankings there are different
				variants. Either you can see the best result of each player or all
				your own results. You can also select a level or view all levels
				together in one table. Since the points are counted differently
				depending on the game mode, there are separate rankings for them;
				accordingly, the mode can also be selected here.</div>
			<br>

			<div class="help-header">Have fun!</div>
				<br> <br>
			</div>

			<div class="novFooter">
				<div class="row-footer-box">
					<a class="footer-label" href="<?= $nov_url_index ?>">Tetris World</a>
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
					<a class="footer-label-only">Help</a>
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