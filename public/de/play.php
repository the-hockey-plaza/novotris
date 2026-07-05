<!DOCTYPE html>
<html lang="de">

<head>
	<title>Jetzt Tetris spielen – kostenlos im Browser – Novotris</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<meta name="description"
		content="Tetris ohne Anmeldung kostenlos im Browser spielen. Highscore speichern und in der Rangliste vergleichen. Classic- und Speed-Modus, bis zu 6 Levels.">
	<meta name="keywords"
		content="tetris, novotris, game, spiel, free, kostenlos, online, spielen, browser, steidlinger, gratis">
	<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
	<meta name="Author" content="Armin Steidlinger Softwareentwicklung">

	<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

	<link rel="alternate" hreflang="de" href="https://novotris.bplaced.net/de/play.php" />
	<link rel="alternate" hreflang="en" href="https://novotris.bplaced.net/en/play.php" />
	<link rel="alternate" hreflang="x-default" href="https://novotris.bplaced.net/de/play.php" />
	<link rel="canonical" href="https://novotris.bplaced.net/de/play.php" />

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



	<link rel="stylesheet" type="text/css" href="../css/novotris.css?v=<?php echo filemtime('../css/novotris.css'); ?>" />

	<?php include '../php/navi.php'; ?>

	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "VideoGame",
			"name": "Novotris",
			"description": "Tetris kostenlos online im Browser spielen – Classic- und Speed-Modus, bis zu 6 Levels.",
			"genre": "Puzzle",
			"playMode": "SinglePlayer",
			"applicationCategory": "Game",
			"operatingSystem": "Web Browser",
			"inLanguage": "de",
			"url": "https://novotris.bplaced.net/de/play.php",
			"offers": {
				"@type": "Offer",
				"price": "0",
				"priceCurrency": "EUR"
			}
		}
	</script>

</head>

<body class="play-page">
	<div class="pseudoBody">
		<div class="container" id="div-container">
			<div class="novHeader nov-header-rounded">
				<div class="marquee-flex-wrap">
					<div class="marquee-container" id="marquee-container" style="display:none;">
						<div class="marquee" id="marquee-text"></div>
					</div>
				</div>
				<div class="nov-logo-area">
					<picture>
						<source srcset="../images/novotris-logo.webp" type="image/webp">
						<img src="../images/novotris-logo.jpg" width="135" height="auto" alt="Novotris - kostenloses Tetris-Spiel">
					</picture>
				</div>
			</div>

			<div id="play-status-message" class="play-status-message" aria-live="polite"></div>

			<div class="novBody play-layout">
				<div id="div-play-frame" class="play-touch-surface play-stage" data-tooltip="Steuerung: Pfeiltasten bewegen/drehen, Leertaste droppt sofort. Mobil: wischen und tippen.">
					<div>
						<canvas id="mainCanvas" class="play-touch-surface play-canvas"></canvas>
					</div>
				</div>
				<div class="play-sidebar">
					<div class="play-sidebar-stats">
						<div class="play-stat">
							<div id="lbl_rows" class="game-data-label play-top-gap-xs">Rows</div>
							<div id="txt_rows" class="game-data-text">1234</div>
						</div>
						<div class="play-stat">
							<div id="lbl_speed" class="game-data-label play-top-gap-sm">Speed</div>
							<div id="txt_speed" class="game-data-text">1234</div>
						</div>
						<div class="play-stat">
							<div id="lbl_score" class="game-data-label play-top-gap-sm">Score <span class="tooltip-icon" data-tooltip="Dein aktueller Spielstand. Punkte erhältst du pro Stein und je nach Modus.">ℹ</span></div>
							<div id="txt_score" class="game-data-text">1234</div>
						</div>
						<div class="play-stat">
							<div id="lbl_highscore" class="game-data-label play-top-gap-sm">Highscore <span class="tooltip-icon" data-tooltip="Dein bester Wert für diesen Level und Modus.">ℹ</span></div>
							<div id="txt_highscore" class="game-data-text">1234</div>
						</div>
					</div>

					<div class="play-sidebar-controls">
						<div class="play-control">
							<div class="game-data-label play-top-gap-sm">
								Level <span class="tooltip-icon" data-tooltip="Wähle den Schwierigkeitsgrad. Neue Level schaltest du über deinen Highscore frei.">ℹ</span><br> <select id="drp-play-level" class="drpMenu play-select">
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
									<option>6</option>
								</select>
							</div>
						</div>

						<div class="play-control">
							<div class="game-data-label">
								Modus <span class="tooltip-icon" data-tooltip="Classic: stabile Punkte pro Stein. Speed: mehr Punkte bei schnellem Fallenlassen.">ℹ</span><br> <select id="drp-play-mode" class="drpMenu play-select">
									<option>classic</option>
									<option>speed</option>
								</select>
							</div>
						</div>

						<div class="play-control play-start-wrap">
							<button class="animated-border-btn" id="do_start" onclick="do_start();">Start</button>
							<span class="tooltip-icon" data-tooltip="Spiel starten. Tipp: Mit P kannst du starten, pausieren und fortsetzen.">ℹ</span>
						</div>
					</div>


				</div>
			</div>

			<?php include '../php/page-footer.php'; ?>

		</div>
		<section class="nov-seo-text">
			<h1>Tetris kostenlos online spielen – Novotris</h1>
			<p>
				Novotris ist ein kostenloses Tetris-Spiel direkt im Browser – ohne Download,
				ohne Installation. Stapele fallende Blöcke, vervollständige Reihen und
				erreiche einen möglichst hohen Score.
			</p>
			<p>
				Wähle zwischen <strong>6 Schwierigkeitsstufen</strong> und zwei Spielmodi:
				Im <strong>Classic-Modus</strong> steigt die Geschwindigkeit mit jeder
				abgebauten Reihe. Der <strong>Speed-Modus</strong> startet direkt auf
				maximaler Geschwindigkeit – nur für Fortgeschrittene.
			</p>
			<p>
				Mit einer kostenlosen <strong>Registrierung</strong> wird dein Highscore
				gespeichert und in der <a href="ranking.php">Rangliste</a> eingetragen –
				so kannst du dich mit anderen Spielern messen. Ohne Anmeldung läuft das
				Spiel genauso, der Score wird dann nur lokal gespeichert.
			</p>
		</section>
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

	<script>
		// Laufband vor Spielstart anzeigen

		function detectLanguage() {
			// 1. Versuche Sprache aus glUser
			if (typeof glUser !== 'undefined' && glUser.getLanguage) {
				var lang = glUser.getLanguage();
				if (lang === 'en' || lang === 'de') return lang;
			}
			// 2. Versuche Sprache aus HTML lang-Attribut
			var htmlLang = document.documentElement.lang;
			if (htmlLang === 'en' || htmlLang === 'de') return htmlLang;
			// 3. Fallback: Browser-Sprache
			var navLang = (navigator.language || navigator.userLanguage || '').substring(0, 2);
			if (navLang === 'en' || navLang === 'de') return navLang;
			return 'de';
		}

		function showPreGameMarquee() {
			var userMaxLevel = (typeof glUser !== 'undefined' && glUser.getLevel) ? glUser.getLevel() : 1;
			var userGamesPlayed = (typeof glUser !== 'undefined' && glUser.getGamesPlayed) ? glUser.getGamesPlayed() : 0;
			var lang = detectLanguage();
			var marqueeText = '';
			if (typeof getMarqueeText === 'function') {
				marqueeText = getMarqueeText(userMaxLevel, userGamesPlayed, 4, lang);
			} else {
				marqueeText = (lang === 'en') ?
					'Use the arrow keys to move the pieces! ... Rotate pieces with the spacebar! ... Fill rows to score points!' :
					'Mit den Pfeiltasten steuerst du die Steine! ... Drehe die Steine mit der Leertaste! ... Fülle Reihen, um Punkte zu sammeln!';
			}
			var marqueeContainer = document.getElementById('marquee-container');
			var marqueeTextDiv = document.getElementById('marquee-text');
			if (marqueeContainer && marqueeTextDiv) {
				marqueeTextDiv.textContent = marqueeText;
				marqueeContainer.style.display = '';
			}
		}

		// Zeige das Laufband initial, wenn Seite geladen und Spiel noch nicht läuft
		document.addEventListener('DOMContentLoaded', function() {
			if (typeof getStatus === 'function' && getStatus() !== 1) { // 1 = cStatusRunning
				showPreGameMarquee();
			}
		});

		// Blende das Laufband aus, sobald das Spiel startet
		function hidePreGameMarquee() {
			var marqueeContainer = document.getElementById('marquee-container');
			if (marqueeContainer) marqueeContainer.style.display = 'none';
		}
		// do_start wird beim Start aufgerufen, daher dort hidePreGameMarquee() ergänzen
		// (Ergänzung in novotris.js empfohlen)
	</script>
	<script
		src="../js/novotris.js?v=<?php echo filemtime('../js/novotris.js'); ?>"></script>
	<script
		src="../js/swipe.js?v=<?php echo filemtime('../js/swipe.js'); ?>"></script>
	<script
		src="../js/dialog.js?v=<?php echo filemtime('../js/dialog.js'); ?>"></script>
	<script
		src="../js/tooltip.js?v=<?php echo filemtime('../js/tooltip.js'); ?>"></script>


	<script>
		document.addEventListener('DOMContentLoaded', onContentLoaded, false);
		document.addEventListener('contextmenu', event => event.preventDefault());

		function stabilizeInitialPlayLayout() {
			if (!glIsMobile) return;

			const stopAt = Date.now() + 2200;

			const recalc = () => {
				if (typeof getStatus === 'function' && getStatus() === 1) {
					return;
				}

				mainUpdateContainerSize();
				initStaticRendering();

				if (glUser.getId() > 0) {
					choose_level();
				}
			};

			const onViewportChange = () => {
				if (Date.now() > stopAt) {
					if (window.visualViewport) {
						window.visualViewport.removeEventListener('resize', onViewportChange);
						window.visualViewport.removeEventListener('scroll', onViewportChange);
					}
					window.removeEventListener('orientationchange', onViewportChange);
					return;
				}

				recalc();
			};

			requestAnimationFrame(() => requestAnimationFrame(recalc));
			setTimeout(recalc, 220);
			setTimeout(recalc, 650);

			if (window.visualViewport) {
				window.visualViewport.addEventListener('resize', onViewportChange);
				window.visualViewport.addEventListener('scroll', onViewportChange);
			}
			window.addEventListener('orientationchange', onViewportChange);
		}

		var glUser = new User();
		mainInit();
		(async () => {
			try {
				await glUser.init(true);
			} catch (error) {
				console.error("glUser.init failed:", error);
			}

			classDialog.initMessages();
			classDialog.init();

			initLoginRendering();
			initStaticRendering();

			if (glUser.getId() > 0) {
				novInit();
				choose_level();
				if (shouldShowPlayEntryDialog()) {
					classDialog.showLevelDialog();
				}
			}

			stabilizeInitialPlayLayout();

			$("body").fadeIn("slow");
		})();
	</script>
</body>

</html>