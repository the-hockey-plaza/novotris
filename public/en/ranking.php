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
		content="tetris, ranking">
	<meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
	<meta name="Author" content="Armin Steidlinger Softwareentwicklung">

	<link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

	<link rel="alternate" hreflang="de" href="https://novotris.bplaced.net/de/ranking.php" />
	<link rel="alternate" hreflang="en" href="https://novotris.bplaced.net/en/ranking.php" />
	<link rel="alternate" hreflang="x-default" href="https://novotris.bplaced.net/de/ranking.php" />
	<link rel="canonical" href="https://novotris.bplaced.net/en/ranking.php" />

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

	<style>
		.box22 {
			flex: 2;
			text-align: center;
			padding-top: 20px;
		}
	</style>
</head>

<!-- ---------------------------------------------------- -->

<body>
	<div class="pseudoBody">
		<div class="container" id="div-container">
			<div class="novHeader"
				style="border-top-left-radius: 4px; border-top-right-radius: 4px;">
				<div id="lblTitle" style="flex: 80">Rankings</div>
				<div style="flex: 20">
					<img src="../images/logo bing v8.jpg" width="135" height="auto"
						align="right" alt="novotris logo">
				</div>
			</div>

			<div class="novBody"
				style="display: flex; flex-direction: column; overflow-y: hidden">

				<div id="div-ranking-loading"
					style="flex: 90; padding-top: 20px; padding-right: 20px; padding-left: 10px; overflow-y: auto;">Loading
					data...</div>

				<div id="div-ranking"
					style="flex: 90; padding-top: 20px; padding-right: 20px; padding-left: 10px; overflow-y: auto; display: none;">

					<table class="class-table-ranking" id="table-ranking"
						style="border-collapse: collapse;">
						<thead class="class-table-ranking">
							<tr class="class-table-ranking">
								<th class="class-table-ranking" scope="col" width=12%
									style="text-align: right; padding-right: 0.5em;">#</th>
								<th class="class-table-ranking" scope="col"
									style="text-align: center">User</th>
								<th class="class-table-ranking" scope="col" width=20%
									style="text-align: center">Datum</th>
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

				<div style="flex: 10; display: flex; font-size: 14px;">
					<div class="box22">
						User: <select id="drp-rnk-auswahl" class="drpMenu">
							<option>all</option>
							<option>only me</option>
						</select>
					</div>

					<div class="box22">
						Level: <select id="drp-rnk-level" class="drpMenu">
							<option>all</option>
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
						</select>
					</div>

					<div class="box22">
						Mode: <select id="drp-rnk-mode" class="drpMenu">
							<option>classic</option>
							<option>speed</option>
						</select>
					</div>

					<div class="box22">
						Zeit: <select id="drp-rnk-period" class="drpMenu">
							<option>12 months</option>
							<option>overall</option>
						</select>
					</div>
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
					<a class="footer-label-only">Rankings</a>
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