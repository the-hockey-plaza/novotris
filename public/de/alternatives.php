<?php
$pageLang = 'de';
$pageTitle = 'Novotris, the better Tetris kostenlos online spielen';
$pageDescription = 'Novotris: Tetris kostenlos online im Browser spielen, mit oder ohne Anmeldung, herausfordernde Varianten probieren, mit anderen Nutzern vergleichen und in Rangliste eintragen.';
$pageKeywords = 'tetris, alternativen';
$canonicalUrl = 'https://novotris.bplaced.net/de/alternatives.php';
$alternateDeUrl = 'https://novotris.bplaced.net/de/alternatives.php';
$alternateEnUrl = 'https://novotris.bplaced.net/en/alternatives.php';
$alternateXDefaultUrl = 'https://novotris.bplaced.net/de/alternatives.php';
include '../php/page-head.php';
?>
<div class="pseudoBody">
	<div class="container" id="div-container">
		<div class="novHeader"
			style="border-top-left-radius: 4px; border-top-right-radius: 4px;">
			<div id="lblTitle"
				style="flex: 80; font-size: 36px; padding-top: 40px;">Novotris
				ist nicht alleine...</div>
			<div style="flex: 20">
				<img src="../images/logo bing v8.jpg" width="135" height="auto"
					align="right" alt="novotris logo">
			</div>
		</div>

		<div class="novBody">
			<div
				style="margin-top: 25; font-size: 16px; padding-left: 32px; padding-right: 32px;">
				Es gibt unfassbar viele Varianten dieses Spiele-Klassikers. Wir
				listen hier einige auf; selbstverständlich sind alle hier gezeigten
				Spiele kostenlos und lassen sich direkt online im Browser spielen.
				<br>

				<ul style="line-height: 120%">
					<li>Neu aufgelegt: <br> <a
							href="https://www.gamesbasis.com/games/classic/tetris/">gamesbasis</a></li>
					<br>
					<li>Nicht nur für Kinder: <br> <a
							href="https://www.geo.de/geolino/spiele/13349-rtkl-onlinespiel-tetris">Tetris
							bei Geolino</a></li>
					<br>
					<li>Nicht nur für Senioren: <br> <a
							href="https://www.50plus.de/spiele/tetris.html">Die
							50plus-Spiele</a></li>
					<br>
					<li>Kein Märchen: <br> <a
							href="https://www.1001spiele.de/g/tetris">1001 Spiele</a></li>
					<br>
					<li>Bei Migano im Doppelpack: <br> <a
							href="https://migano.de/tetris.php">Tetris</a> <a
							href="https://migano.de/tetris_deluxe.php">Tetris Deluxe</a></li>
					<br>
					<li>Sehr beliebt: <br> <a
							href="https://tetris.com/play-tetris">Play Tetris</a></li>
					<br>
					<li>Mehr als nur Spiele: <br> <a
							href="https://www.bernhard-gaul.de/spiele/tetris/tetris.php">Bernhard
							Gauls Seite</a></li>
					<br>
					<li>Vermutlich die meisten User: <br> <a
							href="https://tetr.io">TETR.IO</a></li>
					<br>
					<li>Spezielle Challenges: <br> <a
							href="https://kingofstackers.com/">King of Stackers</a></li>
					<br>
					<li>Zeit für Werbespots einplanen: <br> <a
							href="https://spielspiele.de/tetris-spiel/">SPIELSPIELE</a></li>
					<br>
					<li>Eher nicht so prickelnd: <br> <a
							href="https://www.spielaffe.de/Spiel/Tetris/">spielaffe</a></li>
					<br>
					<li>Es gibt Varianten mit vorbelegten Feldern: <br> <a
							href="https://de.games68.com/games.php?id=8836/">Games68</a></li>
					<br>
					<li>Außer der netten 3D-Optik eher fad: <br> <a
							href="https://www.silvergames.com/de/tetris/">Silver Games</a></li>
					<br>
					<li>Na ja...<br> <a
							href="https://www.silvergames.com/de/tetris/">t-online nennt es Tetra</a></li>
					<br>
				</ul>
			</div>
		</div>

		<div class="novFooter">
			<div class="row-footer-box">
				<a class="footer-label" href="<?= $nov_url_index ?>">Tetriswelt</a>
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
				<a id="footer-user3" class="footer-label"
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

<?php include '../php/page-scripts.php'; ?>

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