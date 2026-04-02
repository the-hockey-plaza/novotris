<!DOCTYPE html>
<html>

<head>
	<title>Novotris, the better Tetris kostenlos online spielen</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description"
		content="Novotris: Tetris kostenlos online im Browser spielen, herausfordernde Varianten probieren, mit anderen Nutzern messen und in Rangliste eintragen.">
	<meta name="keywords"
		content="tetris, changepassword">
	<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
	<meta name="Author" content="Armin Steidlinger Softwareentwicklung">
	<meta property="og:site_name" content="Novotris">
	<meta property="og:locale" content="de_DE">
	<meta property="og:type" content="article">
	<meta property="og:title" content="Tetris">
	<meta property="og:description"
		content="Novotris, ein kostenloses Tetris-Spiel mit mehr Spaß, Ranglisten und herausfordernden Levels.">
	<meta property="article:opinion" content="false">

	<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

	<link rel="alternate" hreflang="de" href="https://novotris.bplaced.net/de/change-password.php" />
	<link rel="alternate" hreflang="en" href="https://novotris.bplaced.net/en/change-password.php" />
	<link rel="alternate" hreflang="x-default" href="https://novotris.bplaced.net/de/change-password.php/" />
	<link rel="canonical" href="https://novotris.bplaced.net/de/change-password.php" />

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

<body>
	<div class="pseudoBody">
		<div class="container" id="div-container">
			<div class="novHeader"
				style="border-top-left-radius: 4px; border-top-right-radius: 4px;">
				<div id="lblTitle"
					style="flex: 80; font-size: 36px; padding-top: 40px;">Passwort
					zurücksetzen</div>
				<div style="flex: 20">
					<img src="../images/logo bing v8.jpg" width="135" height="auto"
						align="right" alt="novotris logo">
				</div>
			</div>

			<div class="novBody">
				<div class="standardform" id="form_registration"
					style="position: absolute;">
					<span id="lbl_registration_error_message"
						style="font-size: 12pt; font-weight: bold; color: red"> </span> <br>
					<span style="font-size: 16pt"></span> <br> <span
						style="font-size: 12pt; font-weight: bold">Passwort</span><br>
					<input type="password" id="input_registration_password"
						class="inpText" onkeyup="classDialog.keyUp()"
						onkeyup="classDialog.keyUp()" name="input_registration_password"
						autocomplete="off" pattern="[a-zA-Z0-9äöüßÄÖÜ\-]*" size="30"
						maxlength="20"> <br> <span
						style="font-size: 12pt; font-weight: bold">Passwort
						(Wiederholung)</span><br> <input type="password"
						id="input_registration_password_repeat" class="inpText"
						onkeyup="classDialog.keyUp()"
						name="input_registration_password_repeat" autocomplete="off"
						pattern="[a-zA-Z0-9äöüßÄÖÜ\-]*" size="30" maxlength="20">
					<br> <br> <br>
					<div>
						<button class="dialog-button" id="btn_reset_password"
							style="width: 120px;" onclick="glUser.updatePasswort();">Zurücksetzen</button>
					</div>

				</div>
			</div>

			<div class="novFooter">
				<div class="row-footer-box">
					<a class="footer-label" href="index.php">Tetriswelt</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" onmouseover="this.style.cursor='pointer'"
						href="play.php" style="color: var(--play-color);">Spielen</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" onmouseover="this.style.cursor='pointer'"
						href="ranking.php">Ranglisten</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" onmouseover="this.style.cursor='pointer'"
						href="help.php">Anleitung</a>
				</div>
			</div>

			<div class="novFooter"
				style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
				<div class="row-footer-box">
					<a id="footer-user" class="footer-label-only">footer-user</a>
				</div>
				<div class="row-footer-box">
					<a id="footer-login" class="footer-label-only">footer-login</a>
				</div>
				<div class="row-footer-box">
					<a id="footer-version" class="footer-label-only">Version</a>
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
			<button id="btn_msg_ok" class="dialog-button"
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
		src="../js/dialog.js?v=<?php echo filemtime('../js/dialog.js'); ?>"></script>
	<script
		src="../js/novotris.js?v=<?php echo filemtime('../js/novotris.js'); ?>"></script>
	<script
		src="../js/rendering.js?v=<?php echo filemtime('../js/rendering.js'); ?>"></script>
	<script
		src="../js/highscore.js?v=<?php echo filemtime('../js/highscore.js'); ?>"></script>

	<script>
		var glUser = new User();

		mainInit();
		mainAssignChangePasswordElements();
		classDialogModus = "change-password";
		classDialog.initMessages();
		glUser.init();
		classDialog.init();
		initLoginRendering();
		$("body").fadeIn("slow");
	</script>

	<!-- ---------------------------------------------------- -->

</body>

</html>