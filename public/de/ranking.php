<!DOCTYPE html>
<html>

<head>
	<title>Novotris, the better Tetris kostenlos online spielen</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description"
		content="Novotris: Tetris kostenlos online im Browser spielen, mit oder ohne Anmeldung, herausfordernde Varianten probieren, mit anderen Nutzern vergleichen und in Rangliste eintragen.">
	<meta name="keywords"
		content="tetris, rangliste">
	<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
	<meta name="Author" content="Armin Steidlinger Softwareentwicklung">

	<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

	<link rel="alternate" hreflang="de" href="https://novotris.bplaced.net/de/ranking.php" />
	<link rel="alternate" hreflang="en" href="https://novotris.bplaced.net/en/ranking.php" />
	<link rel="alternate" hreflang="x-default" href="https://novotris.bplaced.net/de/ranking.php" />
	<link rel="canonical" href="https://novotris.bplaced.net/de/ranking.php" />

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
			<div class="novHeader nov-header-rounded">
				<div id="lblTitle" class="nov-title-area">Ranglisten</div>
				<div class="nov-logo-area">
					<img src="../images/logo bing v8.jpg" width="135" height="auto"
						align="right" alt="novotris logo">
				</div>
			</div>

			<div class="novBody ranking-layout">
				<div id="div-ranking-loading" class="ranking-panel">Lade Daten...
				</div>

				<div id="div-ranking" class="ranking-panel is-hidden">

					<table class="class-table-ranking ranking-table" id="table-ranking">
						<thead class="class-table-ranking">
							<tr class="class-table-ranking">
								<th class="class-table-ranking rank-col-pos" scope="col" width=12%>#</th>
								<th class="class-table-ranking rank-col-center" scope="col">User</th>
								<th class="class-table-ranking rank-col-center" scope="col" width=20%>Datum</th>
								<th class="class-table-ranking" scope="col" width=10%>L</th>
								<th class="class-table-ranking" scope="col" width=15%>Score</th>
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
						User: <select id="drp-rnk-auswahl" class="drpMenu">
							<option>alle</option>
							<option>nur ich</option>
						</select>
					</div>

					<div class="ranking-filter-item">
						Level: <select id="drp-rnk-level" class="drpMenu">
							<option>alle</option>
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
						</select>
					</div>

					<div class="ranking-filter-item">
						Modus: <select id="drp-rnk-mode" class="drpMenu">
							<option>classic</option>
							<option>speed</option>
						</select>
					</div>

					<div class="ranking-filter-item">
						Zeit: <select id="drp-rnk-period" class="drpMenu">
							<option>12 Monate</option>
							<option>gesamt</option>
						</select>
					</div>

				</div>

			</div>

			<div class="novFooter">
				<div class="row-footer-box">
					<a class="footer-label" href="<?= $nov_url_index ?>">Tetriswelt</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" href="<?= $nov_url_play ?>" style="color: var(--play-color);">Spielen</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label-only">Ranglisten</a>
				</div>
				<div class="row-footer-box">
					<a class="footer-label" href="<?= $nov_url_help ?>">Anleitung</a>
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
		src="../js/highscore.js?v=<?php echo filemtime('../js/highscore.js'); ?>"></script>
	<script
		src="../js/rendering.js?v=<?php echo filemtime('../js/rendering.js'); ?>"></script>
	<script
		src="../js/ranking.js?v=<?php echo filemtime('../js/ranking.js'); ?>"></script>
	<script
		src="../js/novotris.js?v=<?php echo filemtime('../js/novotris.js'); ?>"></script>
	<script
		src="../js/dialog.js?v=<?php echo filemtime('../js/dialog.js'); ?>"></script>

	<script>
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