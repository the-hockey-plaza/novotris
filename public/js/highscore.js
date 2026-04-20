/*
 * global declarations
 */

var glScore;
var glScoreFinished;
var glHighscore;
var glHighscoreFinished;
var glOldRankingPosition;

//var glNumberOfTypes;
var glMaxLevelUser = 1;
var glUserUuid;
var glUserId;
var glUserName;
var glUserNameTmp;

let scoreLevel;

function setBrickWidth(size) {
	let frame = document.getElementById('div-play-frame');
	//	let x = frame.offsetWidth;
	//	let y = frame.offsetHeight;
	//TODO
	let x = frame.clientWidth;
	let y = frame.clientHeight;
	let xMax;
	let yMax;

	//	if (glIsMobile) {
	if (true) {
		if (glIsTablet) {
			// 75% der Breite oder 75% der Höhe des Spielfelds:
			//TODO
			//			xMax = Math.floor((glCanvasSize.width * 0.75) / cMatrixSize.width);
			//			yMax = Math.floor((glCanvasSize.height * 0.75) / cMatrixSize.height);
			xMax = Math.floor((glCanvasSize.width * 0.6) / cMatrixSize.width);
			yMax = Math.floor((glCanvasSize.height * 0.6) / cMatrixSize.height);

			if (xMax < yMax)
				cBrickWidth = xMax;
			else
				cBrickWidth = yMax;
		}
		else {
			//			if (size == "small") {
			//				cBrickWidth = 18;
			//			}
			//			else if (size == "large")
			//				cBrickWidth = 36;
			//			else {
			//				cBrickWidth = 22; // 22;
			//			}

			//			xMax = Math.floor((glPlayFramePos.width - glPadding - 30) / cMatrixSize.width);
			//			yMax = Math.floor((glPlayFramePos.height - glPadding - 30) / cMatrixSize.height);
			xMax = Math.floor((x - glPadding - 30) / cMatrixSize.width);
			yMax = Math.floor((y - glPadding - 30) / cMatrixSize.height);

			if (xMax < yMax)
				cBrickWidth = xMax;
			else
				cBrickWidth = yMax;

		}
	}
	else {
		if (size == "small")
			cBrickWidth = 24;
		else if (size == "large")
			cBrickWidth = 48;
		else
			cBrickWidth = 28; // 28;
	}
}

function resetScore() {
	glScore = 0;
}

function increaseScore(points) {
	glScore += points;
	showScore();

	if (glScore >= scoreLevel) {
		playSetTitle(getText("play_title_score", scoreLevel), titleSizeMedium);
		scoreLevel += 500;
	}
}

function reduceScore() {
	if (glScore < 100)
		return 0;

	let reduced = Math.trunc(0.05 * glScore);

	glScore -= reduced;
	showScore();
	return reduced;
}


function getScore() {
	return glScore;
}

function getHighscore() {
	var theHighscore = glUser.getHighscore(glUser.getLevel());

	if (theHighscore === null)
		theHighscore = 0;

	return theHighscore;
}

function showScore() {
	glTxtScore.innerHTML = glScore;
}

function showHighscore() {
	glTxtHighscore.innerHTML = getHighscore();
}



function setHighscore() {
	glTxtHighscore.value = glUser.getHighscore(glUser.getLevel());

	if (glScore <= glUser.getHighscore(glUser.getLevel()))
		return;

	glUser.setHighscore(glUser.getLevel(), glScore);
	glUser.calculateMaxLevel();

	let userDataLocal = JSON.stringify(glUser);
	try {
		window.localStorage.setItem(glUserKey, userDataLocal);
	} catch (error) {
		console.warn("localStorage write blocked for key:", glUserKey, error);
	}

	glTxtHighscore.innerHTML = glUser.getHighscore(glUser.getLevel());

}



/*
 * initialize the current highscore
 */
function initHighscore() {
	var initialHighscore;

	initialHighscore = '{"highscores": [';

	for (var i = 0; i < glConfig.levels.length; ++i) {
		if (i > 0) {
			initialHighscore += ',';
		}
		initialHighscore += "0";

	}

	initialHighscore += ']}';
	glHighscore = initialHighscore;
	// glHighscore = JSON.parse(initialHighscore);
}

function create_UUID() {
	var dt = new Date().getTime();
	var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
		var r = (dt + Math.random() * 16) % 16 | 0;
		dt = Math.floor(dt / 16);
		return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
	});
	return uuid;
}


/*
 * set the highscore to 0
 */
function reset_highscore() {
	initHighscore();
	glHighscore = JSON.parse(glHighscore);
	window.localStorage.removeItem(glHighscoreKey);

	prvDrawData();
}


async function setRankingPosition(old) {
	let isMobile;
	let newRankingPosition;

	if (glIsMobile)
		isMobile = "Y";
	else
		isMobile = "N";

	try {
		const response = await fetch('../php/db.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ db_name: glDbName, functionname: 'readRankingPosition', level: glUser.getLevel(), mobile: isMobile, user_id: glUser.getId(), mode: glUser.getMode() })
		});

		if (!response.ok) {
			throw new Error('HTTP-Fehler: ${response.status}');
		}

		const position = await response.text();
		console.log("setRankingPosition, position = " + position);

		if (old)
			glOldRankingPosition = position;
		else {
			newRankingPosition = position;

			if (newRankingPosition >= glOldRankingPosition || glOldRankingPosition == -1)
				newRankingPosition = null;

			showGameOverDialog(newRankingPosition);
		}

	}
	catch (error) {
		console.error("Netzwerk- oder Parsing-Fehler:", error);
	}
}

/*
function setRankingPosition(old) {
var isMobile;

if (glIsMobile)
	isMobile = "Y";
else
	isMobile = "N";

jQuery.ajax({
	type: "POST",
	url: '../php/db.php',
	data: { db_name: glDbName, functionname: 'readRankingPosition', level: glUser.getLevel(), mobile: isMobile, user_id: glUser.getId(), mode: glUser.getMode() },
	success: function(position) {
		setRankingPositionSuccess(old, position);
	}
});
}

function setRankingPositionSuccess(old, position) {
let newRankingPosition;

if (old)
	glOldRankingPosition = position;
else {
	newRankingPosition = position;

	if (newRankingPosition >= glOldRankingPosition || glOldRankingPosition == -1)
		newRankingPosition = null;

	showGameOverDialog(newRankingPosition);
}
}
*/

function setTestCase() {
	if (glTestCase == 1) {
		for (var i = 0; i < glMaxLevelGlobal; ++i) {
			glHighscore.highscores[i] = 0;
		}
		glHighscore.highscores[0] = 800;
		glHighscore.highscores[1] = 675;
		//	glMaxLevelUser = 1;
	}

	else if (glTestCase == 2) {
		for (var i = 0; i < glMaxLevelGlobal; ++i) {
			glHighscore.highscores[i] = 0;
		}
		glHighscore.highscores[0] = 870;
		glHighscore.highscores[1] = 860;
		glHighscore.highscores[2] = 850;
		glHighscore.highscores[3] = 840;
		glHighscore.highscores[4] = 830;
		glHighscore.highscores[5] = 820;
		glHighscore.highscores[6] = 810;
		//	glMaxLevelUser = 7;
	}
}


