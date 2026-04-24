/*----------------------------------------------------------------------------*/


// arrow keys:
const c_key_blank = 32;
const c_key_left = 37;
const c_key_up = 38;
const c_key_right = 39;
const c_key_down = 40;
const c_key_small_p = 80;


const cImgStart = "../icons/icons8-play-32.png";
const cImgPause = "../icons/icons8-pause-32.png";

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

var v_matrix;
var v_colors;

const glStartInterval = 1000;
const glIntervalStep = 5;
var glCurrentInterval;
var glIntervalId;


var v_rows;

var glRemoveIntervalId;

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

// Central UI state for scroll-lock decisions
var glIsDialogOpen = false;

function setGameScrollLock(isLocked) {
	if (!document.body) {
		return;
	}

	document.body.classList.toggle('game-scroll-lock', !!isLocked);
}

// Recompute and apply scroll lock based on current game + dialog state.
// Lock is active only while the game is running and no dialog is open.
function updateScrollLock() {
	setGameScrollLock(v_status === cStatusRunning && !glIsDialogOpen);
}

// Called by dialog.js when any overlay dialog opens or closes.
function setDialogOpen(isOpen) {
	glIsDialogOpen = !!isOpen;
	updateScrollLock();
}

function novInitMatrixFilter() {
	const width = cMatrixSize.width;
	const height = cMatrixSize.height;

	glMatrixFilter = new Array();
	for (let x = 0; x < width; x++) {
		glMatrixFilter[x] = new Array(height).fill(1);
	}

	if (glUser.getLevel() !== 6) return;

	// Level 6: Corner blocks filter
	const corners = [
		[[0, 0], [1, 0], [0, 1]],
		[[width - 1, 0], [width - 2, 0], [width - 1, 1]],
		[[0, height - 1], [1, height - 1], [0, height - 2]],
		[[width - 1, height - 1], [width - 2, height - 1], [width - 1, height - 2]]
	];
	corners.forEach(corner => {
		corner.forEach(([x, y]) => {
			glMatrixFilter[x][y] = 0;
		});
	});
}

/*
 * clear the matrix
 */
function clearMatrix() {
	for (let i = 0; i < cMatrixSize.width; i++) {
		for (let j = 0; j < cMatrixSize.height; j++) {
			v_matrix[i][j] = "e";
		}
	}
}

/*
 * set randomly the special tiles
 */
function setSpecialTiles() {
	const specialTileFrequency = 250; // standard = 250
	if (glUser.getLevel() !== 5) return;

	// look for all empty tiles:
	const threshold = 1 / specialTileFrequency;
	for (let x = 0; x < cMatrixSize.width; x++) {
		for (let y = Math.floor(cMatrixSize.height * 0.5); y < cMatrixSize.height; y++) {
			if (tileIsEmpty(x, y) && Math.random() <= threshold) {
				v_matrix[x][y] = "s";
			}
		}
	}
}

function setGroundTiles() {
	const countTiles = 20 + Math.floor(Math.random() * 50);

	if (glUser.getLevel() !== 3) return;

	for (let idx = 0; idx < countTiles; idx++) {
		let done = false;

		while (!done) {
			let isFull = true;
			const x = Math.floor(Math.random() * cMatrixSize.width);
			const y = 10 + Math.floor(Math.random() * 10);

			// Check if row is full
			for (let i = 0; i < cMatrixSize.width; i++) {
				if (i !== x && tileIsEmpty(i, y)) {
					isFull = false;
				}
			}

			if (!isFull && v_matrix[x][y] !== "g") {
				v_matrix[x][y] = "g";
				done = true;
			}
		}
	}
}


/*
 * create randomly the next brick
 */
function createNewBrick() {
	const typeIdx = Math.floor(Math.random() * glLevelTypes.length);
	const brickTypeId = glLevelTypes[typeIdx];

	glCurrentBrick = JSON.parse(JSON.stringify(glConfig.types[brickTypeId]));
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

	setTimeout(() => {
		textElement.style.color = "var(--light-text-color)";
	}, 5000);
}
function do_start() {
	if (glCnvMessage.hidden === false) return;
	if (v_status === cStatusRunning || v_status === cStatusPause) {
		do_pause();
		return;
	}

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
	glTxtRows.innerHTML = v_rows;
	glBtnStart.innerHTML = getText("play_button_running");

	hidePlayIcons(false);
	glDropLevel.disabled = true;
	glDropMode.disabled = true;

	glBtnStart.blur();
	scoreLevel = 500;
	playSetTitle(getText("play_title_running"), titleSizeMedium);
	glBtnStart.style.setProperty('--anim', 'paused');
	updateScrollLock();
}

/*----------------------------------------------------------------------------*/

function do_pause() {
	if (v_status === cStatusPause) {
		glIntervalId = setInterval(brickDown, glCurrentInterval);
		glBtnStart.innerHTML = getText("play_button_running");
		v_status = cStatusRunning;
		playSetTitle(getText("play_title_running"), titleSizeMedium);
		glBtnStart.style.setProperty('--anim', 'paused');
		updateScrollLock();
	} else if (v_status === cStatusRunning) {
		clearInterval(glIntervalId);
		glBtnStart.innerHTML = getText("play_button_pause");
		v_status = cStatusPause;
		playSetTitle(getText("play_title_pause", reduceScore()), titleSizeMedium);
		glBtnStart.style.setProperty('--anim', 'paused');
		updateScrollLock();
	}
	glBtnStart.blur();
}



/*
 * check if the current brick is at bottom
 */
function touchedBottom() {
	for (let x = 0; x < getBrickWidth(); x++) {
		for (let y = 0; y < getBrickHeight(); y++) {
			if (getBrickValue(x, y) > 0) {
				// At bottom?
				if (y + glCurrentBrick.y >= cMatrixSize.height - 1) return true;
				// No space below?
				if (!tileIsEmpty(x + glCurrentBrick.x, y + glCurrentBrick.y + 1)) return true;
				// Matrix filter check
				if (glMatrixFilter[x + glCurrentBrick.x][y + glCurrentBrick.y + 1] === 0) return true;
			}
		}
	}
	return false;
}

/*
 * Get first character of tile to determine its type
 */
function getTileType(x, y) {
	return v_matrix[x][y].charAt(0);
}

function tileIsEmpty(x, y) {
	return getTileType(x, y) === "e";
}

function tileIsFull(x, y) {
	const type = getTileType(x, y);
	return type === "c" || type === "s" || type === "g";
}

function tileIsColored(x, y) {
	return getTileType(x, y) === "c";
}

function tileIsSpecial(x, y) {
	return getTileType(x, y) === "s";
}

/*
 * move the current brick one to left
 */
function stone_left() {
	if (v_status !== cStatusRunning) return;

	for (let x = 0; x < getBrickWidth(); x++) {
		for (let y = 0; y < getBrickHeight(); y++) {
			if (getBrickValue(x, y) > 0) {
				if (x + glCurrentBrick.x <= 0) return;
				if (!tileIsEmpty(x + glCurrentBrick.x - 1, y + glCurrentBrick.y)) return;
				if (glMatrixFilter[x + glCurrentBrick.x - 1][y + glCurrentBrick.y] === 0) return;
			}
		}
	}

	drawCurrentBrick(true);
	glCurrentBrick.x--;
	drawMatrix();
	drawCurrentBrick(false);
}

/*----------------------------------------------------------------------------*/

function stone_right() {
	if (v_status !== cStatusRunning) return;

	for (let x = 0; x < getBrickWidth(); x++) {
		for (let y = 0; y < getBrickHeight(); y++) {
			if (getBrickValue(x, y) > 0) {
				if (x + glCurrentBrick.x >= cMatrixSize.width - 1) return;
				if (!tileIsEmpty(x + glCurrentBrick.x + 1, y + glCurrentBrick.y)) return;
				if (glMatrixFilter[x + glCurrentBrick.x + 1][y + glCurrentBrick.y] === 0) return;
			}
		}
	}

	drawCurrentBrick(true);
	glCurrentBrick.x++;
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


function calculateScore() {
	let points;
	let mode = glUser.getMode();
	// if (glUser.getMode() === glModeSpeed) {

	if (mode === glModeSpeed) {
		const speed = 1000 / glCurrentInterval;
		const timeDiff = (Date.now() - glCurrentBrick.startTime) / 1000; // seconds
		const factor = Math.sqrt((glCurrentBrick.y / timeDiff) / speed);
		points = Math.floor(glCurrentBrick.points * factor);
	} else {
		points = glCurrentBrick.points;
	}

	increaseScore(points);
}

function insertBrickToMatrix() {
	calculateScore();

	// Add brick to matrix
	for (let x = 0; x < getBrickWidth(); x++) {
		for (let y = 0; y < getBrickHeight(); y++) {
			if (getBrickValue(x, y) > 0) {
				v_matrix[x + glCurrentBrick.x][y + glCurrentBrick.y] = "c" + glCurrentBrick.color;
			}
		}
	}

	// Remove complete rows
	for (let j = cMatrixSize.height - 1; j > 0; j--) {
		let rowComplete = true;

		// Check if row is complete
		for (let i = 0; i < cMatrixSize.width; i++) {
			if (tileIsEmpty(i, j) && glMatrixFilter[i][j] === 1) {
				rowComplete = false;
				break;
			}
		}

		if (rowComplete) {
			// Clear row
			for (let i = 0; i < cMatrixSize.width; i++) {
				v_matrix[i][j] = "e";
			}

			// Move rows down
			for (let k = j; k > 0; k--) {
				for (let m = 0; m < cMatrixSize.width; m++) {
					if (!tileIsSpecial(m, k - 1) && tileIsEmpty(m, k) && (k === cMatrixSize.height - 1 || glMatrixFilter[m][k + 1] === 1)) {
						v_matrix[m][k] = v_matrix[m][k - 1];
						v_matrix[m][k - 1] = "e";
					}
				}
			}

			// Clear top row
			for (let m = 0; m < cMatrixSize.width; m++) {
				v_matrix[m][0] = "e";
			}

			v_rows++;
			glTxtRows.innerHTML = v_rows;

			// Increase game speed
			if (v_rows % glIntervalStep === 0) {
				glCurrentInterval = glCurrentInterval / 1.1;
				clearInterval(glIntervalId);
				glIntervalId = setInterval(brickDown, glCurrentInterval);
				showSpeed(true);
			}

			// Check this row again as it was full
			j++;
		}
	}
}

function showSpeed(increase) {
	glTxtSpeed.innerHTML = (1000 / glCurrentInterval).toFixed(2);
	if (increase) {
		glTxtSpeed.style.backgroundColor = "yellow";

		setTimeout(() => {
			glTxtSpeed.style.backgroundColor = "var(--light-text-color)";
		}, 5000);
	}
}

/*
 * remove full rows from the matrix
 */
function removeFullRow(j, isFull) {
	clearInterval(glRemoveIntervalId);

	if (isFull) {
		// Clear row
		for (let i = 0; i < cMatrixSize.width; i++) {
			v_matrix[i][j] = "e";
		}

		// Move rows down
		for (let k = j; k > 1; k--) {
			for (let m = 0; m < cMatrixSize.width; m++) {
				if (!tileIsSpecial(m, k - 1) && tileIsEmpty(m, k) && (k === cMatrixSize.height - 1 || glMatrixFilter[m][k + 1] === 1)) {
					v_matrix[m][k] = v_matrix[m][k - 1];
					v_matrix[m][k - 1] = "e";
				}
			}
		}

		// Clear top row
		for (let m = 0; m < cMatrixSize.width; m++) {
			v_matrix[m][0] = "e";
		}

		v_rows++;
		glTxtRows.innerHTML = v_rows;

		// Increase game speed
		if (v_rows % glIntervalStep === 0) {
			const speed = (1000 / glCurrentInterval) * 1.1;
			glCurrentInterval = 1000 / speed;
			clearInterval(glIntervalId);
			glIntervalId = setInterval(brickDown, glCurrentInterval);
			showSpeed(true);
		}

		drawMatrix();
	}

	// Check if row "j" is full
	let rowComplete = true;
	for (let i = 0; i < cMatrixSize.width; i++) {
		if (tileIsEmpty(i, j) && glMatrixFilter[i][j] === 1) {
			rowComplete = false;
			break;
		}
	}

	if (!rowComplete) {
		j--;
	}

	if (j > 0) {
		const delay = rowComplete ? 200 : 0;
		if (rowComplete) {
			markFullRow(j);
		}
		glRemoveIntervalId = setInterval(removeFullRow, delay, j, rowComplete);
	} else {
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
	const msgText = getText("nr_users") + ": <b>" + (await getNovotrisInfo()).nrUsers + "</b><br>" +
		getText("nr_games") + ": <b>" + (await getNovotrisInfo()).nrGames + "</b><br>";

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
	updateScrollLock();
}

/*
 * prepare the next round
 */
function nextRound() {
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
		} else {
			c_new_stone = false;
			insertBrickToMatrix();
			setSpecialTiles();
			drawMatrix();
			createNewBrick();
		}
	} else {
		c_new_stone = false;
		glCurrentBrick.y++;
		drawMatrix();
		drawCurrentBrick();
	}
}

/*----------------------------------------------------------------------------*/

function taste(e) {
	e = e || window.event;

	if (e.keyCode === c_key_small_p) {
		if (!glBtnStart.disabled) {
			if (v_status === cStatusFinished || v_status === cStatusLevel || v_status === cStatusPause) {
				do_start();
			} else if (v_status === cStatusRunning) {
				do_pause();
			}
		}
		return;
	}

	if (v_status === cStatusRunning) {
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
	updateScrollLock();
	initPreview();
	showPreview();
	playSetTitle(getText("play_title_init"), titleSizeMedium);
}

/*----------------------------------------------------------------------------*/

function game_init() {
	// Initialize matrix
	v_matrix = new Array(cMatrixSize.width);
	for (let i = 0; i < cMatrixSize.width; i++) {
		v_matrix[i] = new Array();
	}
	clearMatrix();

	// get the brick types for this level:
	glLevelTypes.length = 0;
	const currentLevel = glUser.getLevel();
	for (let i = 0; i < glConfig.types.length; i++) {
		if (glConfig.types[i].levels.includes(currentLevel)) {
			glLevelTypes.push(i);
		}
	}

	resetScore();
	initPlayRendering();
	v_status = cStatusFinished;
	updateScrollLock();
	glBtnStart.value = "Start";

	v_rows = 0;
	glTxtRows.innerHTML = v_rows;

	glCurrentInterval = glStartInterval;
	showSpeed();
}

function startGameOnDb() {
	jQuery.ajax({
		type: "POST",
		url: '../php/db.php',
		data: { db_name: glDbName, functionname: 'startGameOnDb', user_id: glUser.getId(), nov_release: glRelease, level: glUser.getLevel(), mode: glUser.getMode() },
		success: function (result) {
			startGameOnDbSuccess(result);
		}
	});
}

function startGameOnDbSuccess(result) {
	glGameId = result;
}

async function stopGameOnDb(score) {
	try {
		const myPath = phpDir + 'db.php';

		const response = await fetch(myPath, {
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

/*
 * onLoad
 */
function onContentLoaded() {

	var url = window.location.href;
	url = url.substring(url.lastIndexOf('/') + 1);
	console.log("onContentLoaded", url);
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
}

function onFullscreenChanged(event) {
	return;
}

function novInit() {
	document.onkeydown = taste;

	// Cache DOM elements
	const elements = {
		glBtnStart: 'do_start',
		glLblHighscore: 'lbl_highscore',
		glLblRows: 'lbl_rows',
		glLblScore: 'lbl_score',
		glLblSpeed: 'lbl_speed',
		glTxtHighscore: 'txt_highscore',
		glTxtReset: 'p-reset',
		glTxtRows: 'txt_rows',
		glTxtScore: 'txt_score',
		glTxtSpeed: 'txt_speed'
	};

	Object.entries(elements).forEach(([varName, id]) => {
		window[varName] = document.getElementById(id);
	});

	glBtnStart = document.getElementById('do_start');

	// Setup event listeners
	glDropLevel.addEventListener('change', selectLevel);
	glDropMode.addEventListener('change', selectMode);

	// Initialize level settings
	glDropLevel.disabled = false;
	glDropLevel.selectedIndex = 0;
	glUser.setLevel(1);

	// Initialize mode settings
	glDropMode.disabled = false;
	//glDropMode.selectedIndex = 0;
	glDropMode.selectedIndex = glUser.getMode() - 1;
	//glUser.setMode(1);

	glScore = 0;
	playSetTitle(getText("play_title_init"), titleSizeMedium);
}

/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/

