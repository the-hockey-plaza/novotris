<!DOCTYPE html>
<html>

<head>
	<title>Tetris Leaderboard – Who Plays Best? – Novotris</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width">
	<meta name="description"
		content="Leaderboard at Novotris: compare your highscore online with other players – sorted by level, mode and device.">
	<meta name="keywords"
		content="tetris, ranking">
	<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
	<meta name="Author" content="Armin Steidlinger Softwareentwicklung">

	<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

	<link rel="alternate" hreflang="de" href="https://novotris.bplaced.net/de/ranking.php" />
	<link rel="alternate" hreflang="en" href="https://novotris.bplaced.net/en/ranking.php" />
	<link rel="alternate" hreflang="x-default" href="https://novotris.bplaced.net/de/ranking.php" />
	<link rel="canonical" href="https://novotris.bplaced.net/en/ranking.php" />

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

		gtag('set', 'cookie_domain', window.location.hostname);
		gtag('config', 'G-9GL47VN2C7');
	</script>


	<link rel="stylesheet" type="text/css" href="../css/novotris.css" />

	<?php include '../php/navi.php'; ?>

</head>

<!-- ---------------------------------------------------- -->

<body>
	<div class="pseudoBody">
		<div class="container" id="div-container">
			<div class="novHeader nov-header-rounded">
				<h1 id="lblTitle" class="nov-title-area lbl-title-compact">Leaderboard</h1>
				<div class="nov-logo-area">
					<picture>
						<source srcset="../images/novotris-logo.webp" type="image/webp">
						<img src="../images/novotris-logo.jpg" width="135" height="auto"
							align="right" alt="Novotris - Play Tetris for Free">
					</picture>
				</div>
			</div>

			<div class="novBody ranking-layout">

				<div id="div-ranking-loading" class="ranking-panel">Loading
					data...</div>

				<div id="div-ranking" class="ranking-panel is-hidden">

					<table class="class-table-ranking ranking-table" id="table-ranking">
						<thead class="class-table-ranking">
							<tr class="class-table-ranking">
								<th class="class-table-ranking rank-col-pos" scope="col" width=12%>#</th>
								<th class="class-table-ranking rank-col-center" scope="col">User</th>
								<th class="class-table-ranking rank-col-center" scope="col" width=20%>Datum</th>
								<th class="class-table-ranking" scope="col" width=10%>L</th>
								<th class="class-table-ranking" scope="col" width=15%>Score <span class="tooltip-icon" data-tooltip="Higher values are better. When scores are equal, the date decides.">ℹ</span></th>
							</tr>
						</thead>
						<tbody id="table-body-ranking">
							<tr class="class-table-ranking">
								<td>col1-1</td>
								<td>col1-2</td>
								<td>col1-3</td>
								<td>col1-4</td>
								<td>col1-5</td>
							<tr class="class-table-ranking">
								<td>col2-1</td>
								<td>col2-2</td>
								<td>col2-3</td>
								<td>col2-4</td>
								<td>col2-5</td>
							<tr class="class-table-ranking">
								<td>col3-1</td>
								<td>col3-2</td>
								<td>col3-3</td>
								<td>col3-4</td>
								<td>col3-5</td>
							<tr class="class-table-ranking">
								<td>col4-1</td>
								<td>col4-2</td>
								<td>col4-3</td>
								<td>col4-4</td>
								<td>col4-5</td>
						</tbody>
					</table>

				</div>

				<div class="ranking-filter-bar">
					<div class="ranking-filter-item">
						User <span class="tooltip-icon" data-tooltip="Show either all players or just your results.">ℹ</span>: <select id="drp-rnk-auswahl" class="drpMenu">
							<option>all</option>
							<option>only me</option>
						</select>
					</div>

					<div class="ranking-filter-item">
						Level <span class="tooltip-icon" data-tooltip="Filter by level to see comparable results.">ℹ</span>: <select id="drp-rnk-level" class="drpMenu">
							<option>all</option>
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
						</select>
					</div>

					<div class="ranking-filter-item">
						Mode <span class="tooltip-icon" data-tooltip="Classic and Speed are scored separately. Choose the matching mode.">ℹ</span>: <select id="drp-rnk-mode" class="drpMenu">
							<option>classic</option>
							<option>speed</option>
						</select>
					</div>

					<div class="ranking-filter-item">
						Time <span class="tooltip-icon" data-tooltip="12 months shows current form, overall shows best scores across all years.">ℹ</span>: <select id="drp-rnk-period" class="drpMenu">
						</select>
					</div>
				</div>

			</div>

			<?php include '../php/page-footer.php'; ?>

		</div>
	</div>
	<section class="nov-seo-text">
		<h2>Leaderboard – Compare Your Highscore Online</h2>
		<p>
			The Novotris leaderboard shows who achieves the highest scores.
			Compare your <strong>highscore online</strong> with other players –
			sorted by level (1–6) and game mode (Classic, Speed).
		</p>
		<p>
			With a free account, every game result is saved automatically.
			Whether desktop or mobile: Novotris keeps separate leaderboards to keep
			the comparison fair. Make it into the Top 10!
		</p>
	</section>

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
		src="../js/highscore.js?v=<?php echo filemtime('../js/highscore.js'); ?>"></script>
	<script
		src="../js/rendering.js?v=<?php echo filemtime('../js/rendering.js'); ?>"></script>
	<script
		src="../js/ranking.js?v=<?php echo filemtime('../js/ranking.js'); ?>"></script>
	<script
		src="../js/novotris.js?v=<?php echo filemtime('../js/novotris.js'); ?>"></script>
	<script
		src="../js/dialog.js?v=<?php echo filemtime('../js/dialog.js'); ?>"></script>
	<script
		src="../js/tooltip.js?v=<?php echo filemtime('../js/tooltip.js'); ?>"></script>

	<script>
		document.addEventListener('DOMContentLoaded', onContentLoaded, false);
		var glUser = new User();
		mainInit();
		(async () => {
			await glUser.init(false);

			classDialog.initMessages();
			classDialog.init();

			classRanking.init();
			classRanking.show();
			$("body").fadeIn("slow");
		})();
	</script>

</body>

</html>