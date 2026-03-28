/*----------------------------------------------------------------------------*/


//const cMatrixSize.width = 10;
//const cMatrixSize.height = 20;
//
//const cMatrixSize = { width: 10, height: 20 };
//

// arrow keys:
const c_key_blank = 32;
const c_key_left = 37;
const c_key_up = 38;
const c_key_right = 39;
const c_key_down = 40;
const c_key_small_p = 80;


const cImgStart = "../icons/icons8-play-32.png";
const cImgPause = "../icons/icons8-pause-32.png";

//var glTxtLevel;
//var glLblLevel;

var glTxtRows;
var glLblRows;

var glTxtSpeed;
var glLblSpeed;

var glTxtScore;
var glLblScore;

var glTxtHighscore;
var glLblHighscore;

var glBtnStart;


var glLevelTypes = [0];
var glCurrentBrick;
var glFirstRoundAfterBottom = false;
var glGameId;

//var v_left_x = 30;
//var v_top = 30;
var v_matrix;
var v_colors;
//var c_nr_colors;
//var btn_start;

const glStartInterval = 1000;
const glIntervalStep = 5;
var glCurrentInterval;
var glIntervalId;


var v_rows;

var glRemoveIntervalId;

var v_stone_top;


// game status:
var v_status;
const cStatusRunning = 1;
const cStatusPause = 2;
const cStatusFinished = 3;
const cStatusBottom = 4;
const cStatusLevel = 5;
const cStatusHome = 6;
const cStatusRanking = 7;

var c_new_stone;

var glDevice;

function getStatus() {
	return v_status;
}

function setStatus(status) {
	v_status = status;
}

function novInitMatrixFilter() {

	glMatrixFilter = new Array();
	for (var x = 0; x < cMatrixSize.width; x++)
		glMatrixFilter[x] = new Array();

	for (var x = 0; x < cMatrixSize.width; x++)
		for (var y = 0; y < cMatrixSize.height; y++)
			glMatrixFilter[x][y] = 1;

	if (glUser.getLevel() != 6)
		return;

	// Variante 1:
	glMatrixFilter[0][0] = 0;
	glMatrixFilter[1][0] = 0;
	glMatrixFilter[0][1] = 0;

	glMatrixFilter[cMatrixSize.width - 1][0] = 0;
	glMatrixFilter[cMatrixSize.width - 2][0] = 0;
	glMatrixFilter[cMatrixSize.width - 1][1] = 0;

	glMatrixFilter[0][cMatrixSize.height - 1] = 0;
	glMatrixFilter[1][cMatrixSize.height - 1] = 0;
	glMatrixFilter[0][cMatrixSize.height - 2] = 0;

	glMatrixFilter[cMatrixSize.width - 1][cMatrixSize.height - 1] = 0;
	glMatrixFilter[cMatrixSize.width - 2][cMatrixSize.height - 1] = 0;
	glMatrixFilter[cMatrixSize.width - 1][cMatrixSize.height - 2] = 0;

	//	
	//	
	//	for (var x = 0; x < 2; x++)
	//		for (var y = 0; y < 2; y++) {
	//			glMatrixFilter[x][y] = 0;
	//			glMatrixFilter[cMatrixSize.width - 1 - x][cMatrixSize.height - 1 - y] = 0;
	//	
	//			if (x == 0 || y == ) {
	//			glMatrixFilter[x][cMatrixSize.height - 1 - y] = 0;
	//				glMatrixFilter[cMatrixSize.width - 1 - x][y] = 0;
	//			}
	//}




	// Variante 2:
	//			for (var y = 0; y < 9; y++) {
	//				glMatrixFilter[0][y] = 0;
	//				glMatrixFilter[cMatrixSize.width - 1][y] = 0;
	//				glMatrixFilter[1][y] = 0;
	//				glMatrixFilter[cMatrixSize.width - 2][y] = 0;
	//			}
	//	


	//	// Variante 3:
	//	for (var y = 0; y < 4; y++) {
	//		glMatrixFilter[0][y] = 0;
	//		glMatrixFilter[cMatrixSize.width - 1][y] = 0;
	//		glMatrixFilter[1][y] = 0;
	//		glMatrixFilter[cMatrixSize.width - 2][y] = 0;
	//	}
	//	for (var y = 4; y < 9; y++) {
	//		glMatrixFilter[0][y] = 0;
	//		glMatrixFilter[cMatrixSize.width - 1][y] = 0;
	//	}

	//	// Variante 4:
	//		for (var y = 8; y < 12; y++) {
	//			glMatrixFilter[4][y] = 0;
	//			glMatrixFilter[5][y] = 0;
	//		}
	//
	//	
	//	// Variante 5:
	//		for (var y = cMatrixSize.height-3; y < cMatrixSize.height; y++) {
	//			glMatrixFilter[4][y] = 0;
	//			glMatrixFilter[5][y] = 0;
	//		}

	// Variante 6 (für )

}

/*
 * clear the matrix
 */
function clearMatrix() {
	for (var i = 0; i < cMatrixSize.width; i++)
		for (var j = 0; j < cMatrixSize.height; j++)
			v_matrix[i][j] = "e";
}

/*
 * set randomly the special tiles
 */
function setSpecialTiles() {
	const specialTileFrequency = 250; // standard = 250
	if (glUser.getLevel() != 5)
		return;

	// look for all empty tiles:
	for (var x = 0; x < cMatrixSize.width; x++)
		for (var y = Math.floor(cMatrixSize.height * 0.5); y < cMatrixSize.height; y++)
			if (tileIsEmpty(x, y))
				if (Math.random() <= (1 / specialTileFrequency))
					v_matrix[x][y] = "s";
}

function setGroundTiles() {
	var countTiles = 20 + Math.floor(Math.random() * 50);
	//var countTiles = 30;
	var x;
	var y;

	if (glUser.getLevel() != 3)
		return;

	for (var idx = 0; idx < countTiles; idx++) {
		var done = false;

		while (!done) {
			var v_full = true;

			x = Math.floor(Math.random() * cMatrixSize.width);
			//y = Math.floor(Math.random() * cMatrixSize.height);
			y = 10 + Math.floor(Math.random() * 10);

			// is this row full?
			for (var i = 0; i < cMatrixSize.width; i++) {
				if (i != x && tileIsEmpty(i, y)) {
					v_full = false;
				}
			}

			//			if (!v_full && v_matrix[x][y] != "g") {
			//				if (y == cMatrixSize.height - 1)
			//					done = true;
			//				else if (tileIsFull(x, y + 1))
			//					done = true;
			//			}
			if (!v_full && v_matrix[x][y] != "g")
				done = true;

		}

		v_matrix[x][y] = "g";
	}
}


/*
 * create randomly the next brick
 */
function createNewBrick() {

	//var idx = Math.floor(Math.random() * glNumberOfTypes);
	var idx = Math.floor(Math.random() * glLevelTypes.length);
	var idx = glLevelTypes[idx];
	var done = false;


	//glCurrentBrick = glConfig.types[idx];
	glCurrentBrick = null;
	glCurrentBrick = JSON.parse(JSON.stringify(glConfig.types[idx]));
	glCurrentBrick.rotateIdx = 0;

	// moved to "insertBrickToMatrix"
	//	increaseScore(glCurrentBrick.points);

	glCurrentBrick.x = Math.round((cMatrixSize.width - getBrickWidth()) / 2);
	glCurrentBrick.y = 0;
	glCurrentBrick.startTime = Date.now();

	classSwipe.stop();
	c_new_stone = true;
	drawCurrentBrick(false);
}

/*----------------------------------------------------------------------------*/

const titleSizeSmall = "16px";
const titleSizeMedium = "20px";
const titleSizeLarge = "40px";

function setPlayBtnImg(imgSrc) {
	let slides = glBtnStart.getElementsByTagName('img')[0];
	slides.src = imgSrc;
}

const textElement = document.getElementById('animatedTitle');

function playSetTitle(msg, size) {
	document.getElementById('divTitle').style.fontSize = size;
	textElement.style.color = "yellow";
	textElement.textContent = msg;

	//let highscore1 = getModeHighscore(mode, level) {
	//		return this.highscores[mode - 1][level - 1];
	//	}

	setTimeout(() => {
		textElement.style.color = "var(--light-text-color)";
	}, 5000);
}

//function playSetTitle(msg, size) {
//	document.getElementById('divTitle').style.fontSize = size;
//
//		textElement.innerHTML = msg;
//		
//}
//
function do_start() {
	if (glCnvMessage.hidden == false)
		return;

	if (v_status == cStatusRunning || v_status == cStatusPause) {
		do_pause();
		return;
	}

	//classPlay.init();
	game_init();

	clearInterval(glIntervalId);
	glCurrentInterval = glStartInterval;
	showSpeed();

	resetScore();
	v_rows = 0;

	clearMatrix();
	setGroundTiles();
	setSpecialTiles();

	drawMatrix();
	createNewBrick();

	glGameId = 0;
	setRankingPosition(true); // true = old
	startGameOnDb();

	glIntervalId = setInterval(brickDown, glCurrentInterval);
	v_status = cStatusRunning;
	//glTxtLevel.innerHTML = glUser.getLevel();
	glTxtRows.innerHTML = v_rows;
	//glBtnPause.innerHTML = "Pause";
	glBtnStart.innerHTML = getText("play_button_running");
	//glBtnStart.src = "icons/743894_pause_control_line_play_stop_icon.png";
	//setPlayBtnImg(cImgPause);

	hidePlayIcons(false);
	glDropLevel.disabled = true;
	glDropMode.disabled = true;

	glBtnStart.blur();
	scoreLevel = 500;
	playSetTitle(getText("play_title_running"), titleSizeMedium);
	glBtnStart.style.setProperty('--anim', 'paused');

}

/*----------------------------------------------------------------------------*/

function do_pause() {
	if (v_status == cStatusPause) {
		glIntervalId = setInterval(brickDown, glCurrentInterval);
		//	glBtnPause.value = "Pause";
		glBtnStart.innerHTML = getText("play_button_running");
		//setPlayBtnImg(cImgPause);
		v_status = cStatusRunning;
		playSetTitle(getText("play_title_running"), titleSizeMedium);
		glBtnStart.style.setProperty('--anim', 'paused');
	}
	else if (v_status == cStatusRunning) {
		clearInterval(glIntervalId);
		//	glBtnPause.value = "Resume";
		glBtnStart.innerHTML = getText("play_button_pause");
		//	setPlayBtnImg(cImgStart);
		v_status = cStatusPause;
		playSetTitle(getText("play_title_pause", reduceScore()), titleSizeMedium);
		glBtnStart.style.setProperty('--anim', 'paused');

	}
	//	glBtnPause.blur();
	glBtnStart.blur();
	// glBtnStart.style.setProperty('--anim', 'running');		
}



/*
 * check if the current brick is at bottom
 */
function touchedBottom() {
	for (var x = 0; x < getBrickWidth(); x++)
		for (var y = 0; y < getBrickHeight(); y++)
			if (getBrickValue(x, y) > 0) {
				// unten fertig?
				if (y + glCurrentBrick.y >= cMatrixSize.height - 1)
					return true;

				// kein Platz mehr?
				if (!(tileIsEmpty(x + glCurrentBrick.x, y + glCurrentBrick.y + 1)))
					return true;

				// matrix filter:
				if (glMatrixFilter[x + glCurrentBrick.x][y + glCurrentBrick.y + 1] == 0)
					return true;


			}
	return false;
}

/*
 * check if a tile of the matrix is empty:
 */
function tileIsEmpty(x, y) {
	var tile = v_matrix[x][y];

	return (tile.substring(0, 1) == "e");
}

/*
 * check if a tile of the matrix is full an could be removed
 */
function tileIsFull(x, y) {
	var tile = v_matrix[x][y];
	var firstChar = tile.substring(0, 1);

	return (firstChar == "c" || firstChar == "s" || firstChar == "g");
}

/*
 * check if a tile of the matrix is colored:
 */
function tileIsColored(x, y) {
	var tile = v_matrix[x][y];

	return (tile.substring(0, 1) == "c");
}

function tileIsSpecial(x, y) {
	var tile = v_matrix[x][y];

	return (tile.substring(0, 1) == "s");
}

/*
 * move the current brick one to left
 */
function stone_left() {
	if (v_status != cStatusRunning)
		return;

	for (var x = 0; x < getBrickWidth(); x++)
		for (var y = 0; y < getBrickHeight(); y++) {
			if (getBrickValue(x, y) > 0) {
				// links fertig?
				if (x + glCurrentBrick.x <= 0)
					return;

				// kein Platz mehr?
				if (!(tileIsEmpty(x + glCurrentBrick.x - 1, y + glCurrentBrick.y)))
					return;

				// matrix filter:
				if (glMatrixFilter[x + glCurrentBrick.x - 1][y + glCurrentBrick.y] == 0)
					return;
			}
		}


	drawCurrentBrick(true);
	glCurrentBrick.x = glCurrentBrick.x - 1;

	drawMatrix();
	drawCurrentBrick(false);
}

/*----------------------------------------------------------------------------*/

function stone_right() {
	if (v_status != cStatusRunning)
		return;

	for (var x = 0; x < getBrickWidth(); x++)
		for (var y = 0; y < getBrickHeight(); y++) {
			if (getBrickValue(x, y) > 0) {
				// rechts fertig?
				if (x + glCurrentBrick.x >= cMatrixSize.width - 1)
					return;

				// kein Platz mehr?
				if (!(tileIsEmpty(x + glCurrentBrick.x + 1, y + glCurrentBrick.y)))
					return;

				// matrix filter:
				if (glMatrixFilter[x + glCurrentBrick.x + 1][y + glCurrentBrick.y] == 0)
					return;
			}
		}

	drawCurrentBrick(true);
	glCurrentBrick.x = glCurrentBrick.x + 1;

	drawMatrix();
	drawCurrentBrick(false);
}

/*----------------------------------------------------------------------------*/


function stone_rotate_left() {
	var ok = true;
	var x1;
	var y1;
	var x2;

	if (v_status != cStatusRunning)
		return;


	incrementRotateIdx();

	// check if rotation is possible:
	for (var x = 0; x < getBrickWidth(); x++)
		for (var y = 0; y < getBrickHeight(); y++) {
			if (getBrickValue(x, y) > 0) {
				// links fertig?
				x1 = x + glCurrentBrick.x;

				if (x1 >= cMatrixSize.width - 1)
					x2 = x1;

				if (x1 < 0 || x1 >= cMatrixSize.width)
					ok = false;
				// kein Platz mehr?
				else if (!(tileIsEmpty(x1, y + glCurrentBrick.y)))
					ok = false;
			}
		}

	if (!ok) {
		decrementRotateIdx();
		return;
	}

	drawMatrix();

	decrementRotateIdx();
	drawCurrentBrick(true);
	incrementRotateIdx();
	drawCurrentBrick(false);
}

/*
 * handle the bottom actions
 */
//function handleBottom() {
//	clearInterval(glIntervalId);
//	v_status = cStatusBottom;
//	drawCurrentBrickOutline();
//	glFirstRoundAfterBottom = true;
//	window.setTimeout(nextRound, 10);
//
//}

function handleBottom() {
	glFirstRoundAfterBottom = true;
	nextRound();

}
/*
 * move the current brick to the bottom
 */
function stone_drop() {
	if (v_status != cStatusRunning)
		return;

	drawCurrentBrick(true);

	while (!touchedBottom())
		glCurrentBrick.y++;

	insertBrickToMatrix();
	setSpecialTiles();
	//	drawMatrix();
	createNewBrick();

	drawMatrix();
	drawCurrentBrick(false);
}


/*
 * put the current brick into the matrix
 */
//function insertBrickToMatrix() {
//	// the brick is at bottom and now part of the matrix:
//	for (var x = 0; x < getBrickWidth(); x++)
//		for (var y = 0; y < getBrickHeight(); y++) {
//			if (getBrickValue(x, y) > 0)
//				v_matrix[x + glCurrentBrick.x][y + glCurrentBrick.y] = "c" + glCurrentBrick.color;
//		}
//}

function calculateScore() {
	let points;

	if (glUser.getMode() == glModeSpeed) {
		let speed = 1000 / glCurrentInterval;
		let timeDiff = (Date.now() - glCurrentBrick.startTime) / 1000; // seconds
		let factor = Math.sqrt((glCurrentBrick.y / timeDiff) / speed);
		points = Math.floor(glCurrentBrick.points * factor);
	}
	else
		points = glCurrentBrick.points;

	increaseScore(points);
}

function insertBrickToMatrix() {
	calculateScore();

	// the brick is at bottom and now part of the matrix:
	for (var x = 0; x < getBrickWidth(); x++)
		for (var y = 0; y < getBrickHeight(); y++) {
			if (getBrickValue(x, y) > 0)
				v_matrix[x + glCurrentBrick.x][y + glCurrentBrick.y] = "c" + glCurrentBrick.color;
		}

	// evtl. vollständige Reihen entfernen:
	for (var j = cMatrixSize.height - 1; j > 0; j--) {
		v_full = true;
		for (var i = 0; i < cMatrixSize.width; i++) {
			if (tileIsEmpty(i, j) && glMatrixFilter[i][j] == 1) {
				v_full = false;
			}
		}

		if (v_full) {
			// Reihe leer machen:
			for (var i = 0; i < cMatrixSize.width; i++)
				v_matrix[i][j] = "e";

			// jede Reihe eins nach unten:
			for (var k = j; k > 0; k--)
				for (var m = 0; m < cMatrixSize.width; m++)
					//					if (!(tileIsSpecial(m, k - 1)) && tileIsEmpty(m, k)) {
					if ((!(tileIsSpecial(m, k - 1))) && tileIsEmpty(m, k) && ((k == cMatrixSize.height - 1) || glMatrixFilter[m][k + 1] == 1)) {
						v_matrix[m][k] = v_matrix[m][k - 1];
						v_matrix[m][k - 1] = "e";
					}

			// oberste Reihe ist dann leer:
			for (var m = 0; m < cMatrixSize.width; m++)
				v_matrix[m][0] = "e";

			v_rows = v_rows + 1;
			glTxtRows.innerHTML = v_rows;

			if (v_rows % glIntervalStep == 0) {
				glCurrentInterval = glCurrentInterval / 1.1;
				clearInterval(glIntervalId);
				glIntervalId = setInterval(brickDown, glCurrentInterval);
			}

			showSpeed();

			// diese Reihe noch mal checken, weil sie voll war:
			j = j + 1;
		}
	}
}


function showSpeed() {
	var speed = 1000 / glCurrentInterval;

	glTxtSpeed.innerHTML = speed.toFixed(2)
}

/*
 * remove full rows from the matrix
 */
function removeFullRow(j, isFull) {
	var v_full;
	var rowIdx = j;
	var delay;
	var dummy;
	clearInterval(glRemoveIntervalId);

	if (j == 19)
		dummy = 0;

	if (isFull) {
		// Reihe leer machen:
		for (var i = 0; i < cMatrixSize.width; i++)
			v_matrix[i][j] = "e";

		// jede Reihe eins nach unten:
		for (var k = j; k > 1; k--)
			for (var m = 0; m < cMatrixSize.width; m++)
				if ((!(tileIsSpecial(m, k - 1))) && tileIsEmpty(m, k) && ((k == cMatrixSize.height - 1) || glMatrixFilter[m][k + 1] == 1)) {
					//		if ((!(tileIsSpecial(m, k - 1))) && tileIsEmpty(m, k) && ((k == cMatrixSize.height - 1) || glMatrixFilter[m][k ] == 1)) {
					v_matrix[m][k] = v_matrix[m][k - 1];
					v_matrix[m][k - 1] = "e";
				}

		// oberste Reihe ist dann leer:
		for (var m = 0; m < cMatrixSize.width; m++)
			v_matrix[m][0] = "e";

		v_rows = v_rows + 1;
		glTxtRows.innerHTML = v_rows;

		if (v_rows % glIntervalStep == 0) {
			//			glCurrentInterval / 1.1;
			var speed = (1000 / glCurrentInterval) * 1.1;

			glCurrentInterval = 1000 / speed;

			clearInterval(glIntervalId);
			glIntervalId = setInterval(brickDown, glCurrentInterval);
		}

		showSpeed();

		// diese Reihe noch mal checken, weil sie voll war:
		//	j = j + 1;

		drawMatrix();
	}

	// is row "j" full?
	v_full = true;
	for (var i = 0; i < cMatrixSize.width; i++) {
		if (tileIsEmpty(i, j) && glMatrixFilter[i][j] == 1) {
			v_full = false;
		}
	}

	if (!v_full)
		rowIdx--;

	// removeFullRow(rowIdx, v_full)

	if (rowIdx > 0) {
		//		removeFullRow.j = rowIdx;
		//	removeFullRow.isFull = v_full;
		if (v_full) {
			delay = 200;
			markFullRow(rowIdx);
		}
		else
			delay = 0;

		glRemoveIntervalId = setInterval(removeFullRow, delay, rowIdx, v_full);
	}
	else {
		setSpecialTiles();
		drawMatrix();

		createNewBrick();
		v_status = cStatusRunning;
		clearInterval(glIntervalId);
		glIntervalId = setInterval(brickDown, glCurrentInterval);

		// just created and already at the bottom?
		if (touchedBottom()) {
			stop_game();
		}
	}
}

/*----------------------------------------------------------------------------*/

function stop_game() {
	glScoreFinished = glScore;
	glHighscoreFinished = getHighscore();
	setHighscore();
	do_stop();
	hidePlayIcons(false);

	glBtnStart.innerHTML = "Start";
	//setPlayBtnImg(cImgStart);
	stopGameOnDb(glScore);
	setRankingPosition(false); // false = new
	glDropLevel.disabled = false;
	glDropMode.disabled = false;
	// 11.03.2026
	glScore = 0;
}

function showGameOverDialog(newRankingPosition) {
	var msgText;

	if (glScoreFinished > glHighscoreFinished)
		// msgText = "Du hast in diesem Spiel einen Score von <b>" + glScoreFinished + "</b> und damit einen neuen Highscore erreicht!";
		msgText = getText("score_highscore", glScoreFinished);
	else
		msgText = getText("score", glScoreFinished);

	if (newRankingPosition != null)
		msgText += "<br>" + getText("improved_ranking", newRankingPosition);

	classDialogModus = "finished";
	classDialog.showMessageDialog("Game Over", msgText);
}

async function getNovotrisInfo() {
	try {
		const response = await fetch('../php/db.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ db_name: glDbName, functionname: 'getNovotrisInfo' })
		});

		if (!response.ok) {
			throw new Error('HTTP-Fehler: ${response.status}');
		}

		const result = await response.text();
		console.log("getNovotrisInfo, result = " + result);
		return JSON.parse(result);
	}
	catch (error) {
		console.error("Netzwerk- oder Parsing-Fehler:", error);
	}
}

async function showNovotrisInfoDialog() {
	var msgText = "";
	let novInfo = await getNovotrisInfo();



	//	msgText += "user name: <b>" + glUser.getName() + "</b><br>";
	//	msgText += "user language: <b>" + glUser.getLanguage() + "</b><br>";
	//	msgText += "highscore level 1 (classic): <b>" + glUser.getModeHighscore(1, 1) + "</b><br>";
	//	msgText += "highscore level 1 (speed): <b>" + glUser.getModeHighscore(2, 1) + "</b><br>";
	//

	msgText += getText("nr_users") + ": <b>" + novInfo.nrUsers + "</b><br>";
	msgText += getText("nr_games") + ": <b>" + novInfo.nrGames + "</b><br>";

	classDialogModus = "finished";
	classDialog.showMessageDialog("Novotris " + glRelease, msgText);


}

async function getUserInfo() {
	try {
		const response = await fetch('../php/db.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ db_name: glDbName, functionname: 'getUserInfo', user_id: glUser.getId() })
		});

		if (!response.ok) {
			throw new Error('HTTP-Fehler: ${response.status}');
		}

		const result = await response.text();
		console.log("getUserInfo, result = " + result);
		return JSON.parse(result);
	}
	catch (error) {
		console.error("Netzwerk- oder Parsing-Fehler:", error);
	}
}


async function showUserInfoDialog() {
	var msgText = "";
	let userInfo = await getUserInfo();

	console.log("showUserInfoDialog, userInfo.nrGames = " + userInfo.nrGames);

	msgText += getText("user_name") + ": <b>" + glUser.getName() + "</b><br>";
	msgText += getText("first_game") + ": <b>" + userInfo.firstGame + "</b><br>";
	msgText += getText("last_game") + ": <b>" + userInfo.lastGame + "</b><br>";
	msgText += getText("nr_games") + ": <b>" + userInfo.nrGames + "</b><br>";

	classDialogModus = "finished";
	classDialog.showMessageDialog("User Info", msgText);
}

function do_stop() {
	v_status = cStatusFinished;
	clearInterval(glIntervalId);
	glBtnStart.style.setProperty('--anim', 'running');
}

/*
 * prepare the next round
 */
function nextRound() {
	var isFull = false;
	var delay;

	glFirstRoundAfterBottom = false;

	insertBrickToMatrix();
	removeFullRow(cMatrixSize.height - 1, false);
}

/*
 * move the current brick one tile down, triggered by key or time event
 */
function brickDown() {
	if (touchedBottom()) {
		if (c_new_stone) {
			drawCurrentBrick();
			stop_game();
		}
		else {
			c_new_stone = false;
			insertBrickToMatrix();

			setSpecialTiles();
			drawMatrix();
			createNewBrick();

		}
	}
	else {
		c_new_stone = false;
		glCurrentBrick.y++;
		drawMatrix();
		drawCurrentBrick();
	}
}

/*----------------------------------------------------------------------------*/

function taste(e) {
	if (!e)
		e = window.event;

	if (e.keyCode == c_key_small_p) {
		if (!glBtnStart.disabled) {
			if (v_status == cStatusFinished || v_status == cStatusLevel || v_status == cStatusPause)
				do_start();
			else if (v_status == cStatusRunning)
				do_pause();
		}
		return;
	};

	if (v_status == cStatusRunning) {
		switch (e.keyCode) {
			case c_key_blank:
				stone_drop();
				break;

			case c_key_left:
				stone_left();
				break;

			case c_key_up:
				stone_rotate_left();
				break;

			case c_key_right:
				stone_right();
				break;

			case c_key_down:
				brickDown();
				break;
		}
	}
}

function choose_level() {
	v_status = cStatusLevel;
	clearInterval(glIntervalId);

	//	glUser.create();
	//	glMainFooter.hidden = true;
	initPreview();
	showPreview();
	playSetTitle(getText("play_title_init"), titleSizeMedium);

}

/*----------------------------------------------------------------------------*/

function game_init() {
	var level = glUser.getLevel();

	v_matrix = new Array();
	for (var i = 0; i < cMatrixSize.width; i++)
		v_matrix[i] = new Array();
	clearMatrix();

	// get the brick types for this level:
	glLevelTypes.length = 0;
	for (var i = 0; i < glConfig.types.length; ++i) {
		if (glConfig.types[i].levels.includes(glUser.getLevel())) {
			glLevelTypes.push(i);
		}
	}

	resetScore();
	initPlayRendering();
	v_status = cStatusFinished;
	glBtnStart.value = "Start";

	v_rows = 0;
	glTxtRows.innerHTML = v_rows;

	glCurrentInterval = glStartInterval;
	showSpeed();

	//	if (glTxtLevel != null)
	//		glTxtLevel.innerHTML = level;
}

//function logToDb(aktion, params) {
//	glLogOrder += 1;
//
//	jQuery.ajax({
//		type: "POST",
//		url: '../php/db.php',
//		data: { db_name: glDbName, functionname: 'logToDb', nov_release: glRelease, aktion: aktion, params: params, log_order: glLogOrder },
//		success: function() {
//			console.log("logToDb success");
//		}
//	});
//}

function startGameOnDb() {
	jQuery.ajax({
		type: "POST",
		url: '../php/db.php',
		data: { db_name: glDbName, functionname: 'startGameOnDb', user_id: glUser.getId(), nov_release: glRelease, level: glUser.getLevel(), mode: glUser.getMode() },
		success: function(result) {
			startGameOnDbSuccess(result);
		}
	});
}

function startGameOnDbSuccess(result) {
	glGameId = result;
}

//function stopGameOnDb() {
//	jQuery.ajax({
//		type: "POST",
//		url: '../php/db.php',
//		data: { db_name: glDbName, functionname: 'stopGameOnDb', game_id: glGameId, score: glScore },
//		success: function() {
//			stopGameOnDbSuccess();
//		}
//	});
//}

async function stopGameOnDb(score) {
	try {
//		const response = await fetch('../php/db.php', {
	const myPath = phpDir + 'db.php';
	

	const myPath1 = '../../../php/dbtest1.php';

		const response = await fetch(myPath1, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ db_name: glDbName, functionname: 'stopGameOnDb', game_id: glGameId, score: glScore })
		});

		if (!response.ok) {
			throw new Error('HTTP-Fehler: ${response.status}');
		}

		const result = await response.text();
		console.log("stopGameOnDb, result = " + result);

		let mailContent;
		mailContent = "alert type: <b>stopGame</b><br>";
		mailContent += "ip: <b>" + result + "</b><br>";
		mailContent += "user_name: <b>" + glUser.getName() + "</b><br>";
		mailContent += "level: <b>" + glUser.getLevel() + "</b><br>";
		mailContent += "mode: <b>" + glUser.getMode() + "</b><br>";
		mailContent += "score: <b>" + score + "</b><br>";

		mainLog("stopGame", "user_name: " + glUser.getName() + ", level: " + glUser.getLevel() + ", score: " + score);

		glUser.sendSysLoadMail(mailContent);
	}
	catch (error) {
		console.error("Netzwerk- oder Parsing-Fehler:", error);
	}
}


//function stopGameOnDbSuccess(result) {
//	console.log("stopGameOnDbSuccess");
//
//	let mailContent;
//	mailContent = "alert type: <b>stopGame</b><br>";
//	mailContent += "user_name: <b>" + glUser.getName() + "</b><br>";
//	mailContent += "level: <b>" + glUser.getLevel() + "</b><br>";
//	mailContent += "mode: <b>" + glUser.getMode() + "</b><br>";
//	mailContent += "score: <b>" + glScore + "</b><br>";
//
//	glUser.sendSysLoadMail(mailContent);
//
//}


/*
 * onLoad
 */
function onContentLoaded() {
	console.log("onContentLoaded");

	var url = window.location.href;
	url = url.substring(url.lastIndexOf('/') + 1);
	mainLog("onContentLoaded", url);

	var isMobile;
	if (glIsMobile)
		isMobile = "yes";
	else
		isMobile = "no";

	let mailContent;
	mailContent = "alert type: <b>onContentLoaded</b><br>";
	mailContent += "url: <b>" + url + "</b><br>";
	mailContent += "id: <b>" + glUser.getId() + "</b><br>";
	mailContent += "name: <b>" + glUser.getName() + "</b><br>";
	mailContent += "language: <b>" + glUser.getLanguage() + "</b><br>";
	mailContent += "mobile: <b>" + isMobile + "</b><br>";


	//glUser.sendSysLoadMail(mailContent);

	//fullscreen
	//	enterFullscreen(document.documentElement);
}

function onFullscreenChanged(event) {
	return;
}


function novTest() {
	console.log("novTest");

	for (var i = 0; i < 100; ++i) {
		var idx = Math.floor(Math.random() * 5);
		console.log(idx);
	}
}


function novGetDevice() {
	var device = new DeviceUUID().get();
}


function novInit() {
	document.onkeydown = taste;

	glBtnStart = document.getElementById('do_start');

	glLblHighscore = document.getElementById('lbl_highscore');
	glLblRows = document.getElementById('lbl_rows');
	glLblScore = document.getElementById('lbl_score');
	glLblSpeed = document.getElementById('lbl_speed');
	glTxtHighscore = document.getElementById('txt_highscore');
	glTxtReset = document.getElementById('p-reset');
	glTxtRows = document.getElementById('txt_rows');
	glTxtScore = document.getElementById('txt_score');
	glTxtSpeed = document.getElementById('txt_speed');

	glDropLevel.addEventListener('change', selectLevel);
	glDropMode.addEventListener('change', selectMode);

	glDropLevel.disabled = false;
	glDropLevel.selectedIndex = 0;
	glUser.setLevel(1);

	glDropMode.disabled = false;
	glDropMode.selectedIndex = 0;
	glUser.setMode(1);

	glScore = 0;

	playSetTitle(getText("play_title_init"), titleSizeMedium);


}

/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/

