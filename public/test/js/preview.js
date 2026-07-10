/*
 * global declarations
 */

const glPreviewWidth = 150;
const glPreviewHeight = 200;
const glPreviewLeft = 650;
const glPreviewTop = 650;

const glDropLevel = document.getElementById('drp-play-level');
const glDropMode = document.getElementById('drp-play-mode');



var glContext;
var glPreviewTileSize = 24;
var glTxtPrvLevel;
var glTxtPrvHighscore;
var glPrvHighscorePos = { width: 0, height: 0, x: 0, y: 0 };
var glTxtPrvHighscore;
var glLblPrvHighscore;
var glPreviewPos = { width: 0, height: 0, top: 0, left: 0 };
var previewFrameSize = { width: 380, height: 550, left: 25, top: 15 };

var glUser;

function prvDrawTile(x, y, color) {
	// rgb(92, 214, 92)
	//	if (color == "#5cd65c")
	//		glContext.fillStyle = 'rgba(92, 214, 92, 0.4)';
	//	else
	glContext.fillStyle = color;

	drawTile(x, y, true);
}

function prvDrawOutline(x, y, width) {
	glContext.strokeStyle = "#c0c0c0";
	glContext.lineWidth = 1;
	glContext.strokeRect(x, y, width, width);
	glContext.strokeStyle = "#101010";
	glContext.lineWidth = 1;
	glContext.strokeRect(x + 1, y + 1, width - 2, width - 2);
}

function prvDrawSpecialTile(x, y) {
	drawSpecialTile(x, y);
	//	var xPos = glPreviewPos.left + x * glPreviewTileSize + 1;
	//	var yPos = glPreviewPos.top + y * glPreviewTileSize + 1;
	//	var width = glPreviewTileSize - 2;
	//
	//	glContext.fillStyle = "white";
	//	glContext.fillRect(xPos, yPos, width, width);
	//
	//	prvDrawOutline(xPos + 2, yPos + 2, width - 4, width - 4);
}

function prvDrawGroundTile(x, y) {
	drawGroundTile(x, y);

	//	var xPos = glPreviewPos.left + x * glPreviewTileSize + 1;
	//	var yPos = glPreviewPos.top + y * glPreviewTileSize + 1;
	//	var width = glPreviewTileSize - 2;
	//
	//	glContext.fillStyle = "red";
	//	glContext.fillRect(xPos, yPos, width, width);
	//
	//	glContext.strokeStyle = "black";
	//	glContext.lineWidth = 1;
	//
	//
	//	glContext.beginPath();
	//
	//	yPos += 5;
	//	glContext.moveTo(xPos + 3, yPos);
	//	glContext.lineTo(xPos + 3 + glPreviewTileSize - 7, yPos);
	//
	//	yPos += 4
	//	glContext.moveTo(xPos + 3, yPos);
	//	glContext.lineTo(xPos + 3 + glPreviewTileSize - 7, yPos);
	//
	//	yPos += 4;
	//	glContext.moveTo(xPos + 3, yPos);
	//	glContext.lineTo(xPos + 3 + glPreviewTileSize - 7, yPos);
	//
	//	//
	//	//	glContext.moveTo(xPos+7, yPos+17);
	//	//	glContext.lineTo(xPos+7+cBrickWidth-14, yPos+17);
	//	//	
	//	glContext.stroke();
	//

	//prvDrawOutline(xPos + 2, yPos + 2, width - 4, width - 4);
}

function prvDrawData() {
	var level = glUser.getLevel();
	var edgeSize;

	if (glIsMobile)
		edgeSize = 5
	else
		edgeSize = 7;

	//glTxtLevel.innerHTML = level;
	glTxtHighscore.innerHTML = getHighscore();
}

/*
* draw the preview picture
*/
function drawPreview1() {

	prvDrawTile(1, 2, "#5cd65c");
	prvDrawTile(2, 2, "#5cd65c");
	prvDrawTile(3, 3, "#5cd65c");
	prvDrawTile(2, 3, "#5cd65c");

	prvDrawTile(5, 3, "#3377ff");
	prvDrawTile(6, 3, "#3377ff");
	prvDrawTile(5, 4, "#3377ff");
	prvDrawTile(6, 4, "#3377ff");

	prvDrawTile(5, 6, "#8888aa");
	prvDrawTile(5, 7, "#8888aa");
	prvDrawTile(4, 7, "#8888aa");
	prvDrawTile(3, 7, "#8888aa");

	prvDrawTile(1, 5, "#ff8533");
	prvDrawTile(1, 6, "#ff8533");
	prvDrawTile(1, 7, "#ff8533");
	prvDrawTile(1, 8, "#ff8533");

	prvDrawTile(6, 16, "#ffff33");
	prvDrawTile(7, 15, "#ffff33");
	prvDrawTile(7, 16, "#ffff33");
	prvDrawTile(8, 16, "#ffff33");

	prvDrawTile(3, 10, "#ff3399");
	prvDrawTile(3, 11, "#ff3399");
	prvDrawTile(4, 11, "#ff3399");
	prvDrawTile(5, 11, "#ff3399");


	prvDrawTile(3, 13, "#9933ff");
	prvDrawTile(4, 13, "#9933ff");
	prvDrawTile(2, 14, "#9933ff");
	prvDrawTile(3, 14, "#9933ff");
}

function drawPreview2() {
	prvDrawTile(2, 2, "#5cd65c");
	prvDrawTile(3, 2, "#5cd65c");
	prvDrawTile(2, 1, "#5cd65c");
	prvDrawTile(1, 1, "#5cd65c");

	prvDrawTile(5, 1, "#3377ff");
	prvDrawTile(6, 1, "#3377ff");
	prvDrawTile(5, 2, "#3377ff");
	prvDrawTile(6, 2, "#3377ff");

	prvDrawTile(5, 5, "#8888aa");
	prvDrawTile(5, 6, "#8888aa");
	prvDrawTile(4, 6, "#8888aa");
	prvDrawTile(3, 6, "#8888aa");

	prvDrawTile(1, 4, "#ff8533");
	prvDrawTile(1, 5, "#ff8533");
	prvDrawTile(1, 6, "#ff8533");
	prvDrawTile(1, 7, "#ff8533");

	prvDrawTile(6, 13, "#ffff33");
	prvDrawTile(7, 13, "#ffff33");
	prvDrawTile(7, 14, "#ffff33");
	prvDrawTile(8, 14, "#ffff33");

	prvDrawTile(3, 9, "#ff3399");
	prvDrawTile(3, 10, "#ff3399");
	prvDrawTile(4, 10, "#ff3399");
	prvDrawTile(5, 10, "#ff3399");

	prvDrawTile(3, 12, "#9933ff");
	prvDrawTile(4, 12, "#9933ff");
	prvDrawTile(2, 13, "#9933ff");
	prvDrawTile(3, 13, "#9933ff");

	prvDrawTile(2, 15, "#ffbb33");
	prvDrawTile(3, 15, "#ffbb33");
	prvDrawTile(4, 15, "#ffbb33");

	//	prvDrawTile(7, 12, "#85adad");
	//	prvDrawTile(7, 13, "#85adad");
	//	prvDrawTile(8, 13, "#85adad");

	prvDrawTile(4, 18, "#adad85");
	prvDrawTile(5, 17, "#adad85");
	prvDrawTile(6, 16, "#adad85");
}

function drawPreview3() {

	prvDrawTile(1, 2, "#5cd65c");
	prvDrawTile(2, 2, "#5cd65c");
	prvDrawTile(3, 3, "#5cd65c");
	prvDrawTile(2, 3, "#5cd65c");

	prvDrawTile(5, 3, "#3377ff");
	prvDrawTile(6, 3, "#3377ff");
	prvDrawTile(5, 4, "#3377ff");
	prvDrawTile(6, 4, "#3377ff");

	prvDrawTile(5, 6, "#8888aa");
	prvDrawTile(5, 7, "#8888aa");
	prvDrawTile(4, 7, "#8888aa");
	prvDrawTile(3, 7, "#8888aa");

	prvDrawTile(1, 5, "#ff8533");
	prvDrawTile(1, 6, "#ff8533");
	prvDrawTile(1, 7, "#ff8533");
	prvDrawTile(1, 8, "#ff8533");

	prvDrawTile(2, 10, "#ffff33");
	prvDrawTile(3, 9, "#ffff33");
	prvDrawTile(3, 10, "#ffff33");
	prvDrawTile(4, 10, "#ffff33");

	prvDrawTile(6, 10, "#ff3399");
	prvDrawTile(6, 11, "#ff3399");
	prvDrawTile(7, 11, "#ff3399");
	prvDrawTile(8, 11, "#ff3399");

	prvDrawTile(3, 13, "#9933ff");
	prvDrawTile(4, 13, "#9933ff");
	prvDrawTile(2, 14, "#9933ff");
	prvDrawTile(3, 14, "#9933ff");

	prvDrawGroundTile(1, 19);
	prvDrawGroundTile(1, 18);
	prvDrawGroundTile(1, 17);
	prvDrawGroundTile(2, 19);
	prvDrawGroundTile(2, 18);
	prvDrawGroundTile(4, 19);
	prvDrawGroundTile(5, 19);
	prvDrawGroundTile(5, 18);
	prvDrawGroundTile(5, 17);
	prvDrawGroundTile(5, 16);
	prvDrawGroundTile(6, 19);
	prvDrawGroundTile(7, 19);

}


function drawPreview4() {
	prvDrawTile(2, 16, "#5cd65c");
	prvDrawTile(3, 16, "#5cd65c");
	prvDrawTile(2, 15, "#5cd65c");
	prvDrawTile(1, 15, "#5cd65c");

	prvDrawTile(5, 0, "#3377ff");
	prvDrawTile(6, 1, "#3377ff");
	prvDrawTile(5, 1, "#3377ff");
	prvDrawTile(6, 1, "#3377ff");

	prvDrawTile(5, 3, "#8888aa");
	prvDrawTile(5, 4, "#8888aa");
	prvDrawTile(4, 4, "#8888aa");
	prvDrawTile(3, 4, "#8888aa");

	prvDrawTile(1, 2, "#ff8533");
	prvDrawTile(1, 3, "#ff8533");
	prvDrawTile(1, 4, "#ff8533");
	prvDrawTile(1, 5, "#ff8533");

	prvDrawTile(6, 7, "#ffff33");
	prvDrawTile(7, 6, "#ffff33");
	prvDrawTile(7, 7, "#ffff33");
	prvDrawTile(8, 7, "#ffff33");

	prvDrawTile(3, 7, "#ff3399");
	prvDrawTile(3, 8, "#ff3399");
	prvDrawTile(4, 8, "#ff3399");
	prvDrawTile(5, 8, "#ff3399");

	prvDrawTile(3, 10, "#9933ff");
	prvDrawTile(4, 10, "#9933ff");
	prvDrawTile(2, 11, "#9933ff");
	prvDrawTile(3, 11, "#9933ff");

	//	prvDrawTile(4, 13, "#ffbb33");
	//	prvDrawTile(5, 13, "#ffbb33");
	//	prvDrawTile(6, 13, "#ffbb33");
	//
	//	prvDrawTile(7, 10, "#85adad");
	//	prvDrawTile(7, 11, "#85adad");
	//	prvDrawTile(8, 11, "#85adad");

	//	prvDrawSpecialTile(5, 18);
	//	prvDrawSpecialTile(6, 15);
	//	prvDrawSpecialTile(8, 17);

	prvDrawTile(8, 12, "#ff33ff");
	prvDrawTile(7, 13, "#ff33ff");

	prvDrawTile(5, 15, "#cc9966");

	//	prvDrawTile(5, 18, "#adad85");
	//	prvDrawTile(6, 17, "#adad85");
	//	prvDrawTile(7, 16, "#adad85");

	prvDrawTile(7, 17, "#85adad");
	prvDrawTile(7, 18, "#85adad");
	prvDrawTile(8, 18, "#85adad");

}

function drawPreview5() {
	//	glContext.fillStyle = "#c0c0c0";
	//	glContext.fillRect(0, 0, 150, 200);
	//	glContext.fillStyle = "#404040";
	//	glContext.fillRect(5, 5, 95, 140);
	//
	//	glContext.strokeStyle = "#ffffff";
	//	glContext.lineWidth = 1;
	//	glContext.strokeRect(5, 5, 95, 140);

	prvDrawTile(2, 16, "#5cd65c");
	prvDrawTile(3, 16, "#5cd65c");
	prvDrawTile(2, 15, "#5cd65c");
	prvDrawTile(1, 15, "#5cd65c");

	prvDrawTile(5, 1, "#3377ff");
	prvDrawTile(6, 1, "#3377ff");
	prvDrawTile(5, 2, "#3377ff");
	prvDrawTile(6, 2, "#3377ff");

	prvDrawTile(5, 4, "#8888aa");
	prvDrawTile(5, 5, "#8888aa");
	prvDrawTile(4, 5, "#8888aa");
	prvDrawTile(3, 5, "#8888aa");

	prvDrawTile(1, 3, "#ff8533");
	prvDrawTile(1, 4, "#ff8533");
	prvDrawTile(1, 5, "#ff8533");
	prvDrawTile(1, 6, "#ff8533");

	prvDrawTile(6, 8, "#ffff33");
	prvDrawTile(7, 7, "#ffff33");
	prvDrawTile(7, 8, "#ffff33");
	prvDrawTile(8, 8, "#ffff33");

	prvDrawTile(1, 8, "#ff3399");
	prvDrawTile(1, 9, "#ff3399");
	prvDrawTile(2, 9, "#ff3399");
	prvDrawTile(3, 9, "#ff3399");

	prvDrawTile(3, 11, "#9933ff");
	prvDrawTile(4, 11, "#9933ff");
	prvDrawTile(2, 12, "#9933ff");
	prvDrawTile(3, 12, "#9933ff");

	prvDrawSpecialTile(8, 16);
	prvDrawSpecialTile(7, 18);
}

function drawPreview6() {
	prvDrawTile(6, 16, "#5cd65c");
	prvDrawTile(7, 16, "#5cd65c");
	prvDrawTile(8, 17, "#5cd65c");
	prvDrawTile(7, 17, "#5cd65c");

	prvDrawTile(3, 3, "#3377ff");
	prvDrawTile(4, 3, "#3377ff");
	prvDrawTile(3, 4, "#3377ff");
	prvDrawTile(4, 4, "#3377ff");

	prvDrawTile(6, 5, "#ff33ff");
	prvDrawTile(7, 6, "#ff33ff");

	prvDrawTile(5, 8, "#8888aa");
	prvDrawTile(5, 9, "#8888aa");
	prvDrawTile(4, 9, "#8888aa");
	prvDrawTile(3, 9, "#8888aa");

	prvDrawTile(1, 9, "#ff8533");
	prvDrawTile(1, 10, "#ff8533");
	prvDrawTile(1, 11, "#ff8533");
	prvDrawTile(1, 12, "#ff8533");

	prvDrawTile(6, 12, "#ffff33");
	prvDrawTile(7, 11, "#ffff33");
	prvDrawTile(7, 12, "#ffff33");
	prvDrawTile(8, 12, "#ffff33");

	prvDrawTile(3, 12, "#ff3399");
	prvDrawTile(3, 13, "#ff3399");
	prvDrawTile(4, 13, "#ff3399");
	prvDrawTile(5, 13, "#ff3399");

	prvDrawTile(3, 15, "#9933ff");
	prvDrawTile(4, 15, "#9933ff");
	prvDrawTile(2, 16, "#9933ff");
	prvDrawTile(3, 16, "#9933ff");
}

function drawPreview7() {

	prvDrawTile(1, 2, "#5cd65c");
	prvDrawTile(2, 2, "#5cd65c");
	prvDrawTile(3, 3, "#5cd65c");
	prvDrawTile(2, 3, "#5cd65c");

	prvDrawTile(4, 4, "#3377ff");
	prvDrawTile(5, 4, "#3377ff");
	prvDrawTile(4, 5, "#3377ff");
	prvDrawTile(5, 5, "#3377ff");

	prvDrawTile(4, 15, "#ffbb33");
	prvDrawTile(5, 15, "#ffbb33");
	prvDrawTile(6, 15, "#ffbb33");

	prvDrawTile(4, 17, "#ff33ff");
	prvDrawTile(3, 18, "#ff33ff");

	prvDrawTile(7, 12, "#cc9966");

	prvDrawTile(6, 8, "#00cccc");
	prvDrawTile(7, 8, "#00cccc");
	prvDrawTile(8, 8, "#00cccc");
	prvDrawTile(6, 9, "#00cccc");
	prvDrawTile(8, 9, "#00cccc");

	prvDrawTile(7, 21, "#adad85");
	prvDrawTile(8, 20, "#adad85");
	prvDrawTile(9, 19, "#adad85");
}

function drawPreview8() {
	prvDrawTile(1, 2, "#5cd65c");
	prvDrawTile(2, 2, "#5cd65c");
	prvDrawTile(3, 3, "#5cd65c");
	prvDrawTile(2, 3, "#5cd65c");

	prvDrawTile(5, 5, "#cc9966");

	prvDrawTile(1, 8, "#ffbb33");
	prvDrawTile(2, 8, "#ffbb33");
	prvDrawTile(3, 8, "#ffbb33");

}

function hidePlayIcons(isHidden) {
	return;

	//	document.getElementById('stone_left').hidden = isHidden;
	//	document.getElementById('stone_rotate_left').hidden = isHidden;
	//	document.getElementById('stone_drop').hidden = isHidden;
	//	document.getElementById('stone_right').hidden = isHidden;
}

/* 
 * show the preview picture according to the given level
 */
function showPreview() {
	var level = glUser.getLevel();
	var width;
	var height;
	var top;
	var left;

	novInitMatrixFilter();
	drawFieldBackground(true);

	switch (level) {
		case 1:
			drawPreview1();
			break;

		case 2:
			drawPreview2();
			break;

		case 3:
			drawPreview3();
			break;

		case 4:
			drawPreview4();
			break;

		case 5:
			drawPreview5();
			break;

		case 6:
			drawPreview6();
			break;

		case 7:
			drawPreview7();
			break;

		case 8:
			drawPreview8();
			break;

		default:
			break;
	}

	if (glIsMobile)
		textSize = 56;
	else
		textSize = 64;
	left = glPlayGroundSize.left + glPlayGroundSize.width / 2 + 2;
	top = glPlayGroundSize.top + 0.4 * glPlayGroundSize.height;
	drawCenteredText("Level " + level, textSize, left, top, 'rgba(230,230,230,0.6)');

	if (level > glUser.getMaxLevel())
		glBtnStart.disabled = true;
	else
		glBtnStart.disabled = false;

	glTxtRows.innerHTML = 0;
	glTxtScore.innerHTML = 0;
	glTxtSpeed.innerHTML = 0;
	glTxtHighscore.innerHTML = 0;

	prvDrawData();


	//document.getElementById('stone_left').disabled = true;
	hidePlayIcons(true);

}

function prvPlay() {
	(false);

	//game_init();
	do_start();
}

function prvCalculateSizes() {
	var level = glUser.getLevel();

	if (level == 7) {
		cMatrixSize.width = 12;
		cMatrixSize.height = 24;

		//		if (glIsMobile)
		//			cBrickWidth = 18;
		//		else
		//			cBrickWidth = 24;// 24;
		setBrickWidth("small");
		//	cBrickWidth = 16;
	} else if (level == 8) {
		cMatrixSize.width = 6;
		cMatrixSize.height = 12;

		//		if (glIsMobile)
		//			cBrickWidth = 18;
		//		else
		//			cBrickWidth = 24;// 24;
		setBrickWidth("large");
		//	cBrickWidth = 16;
	}
	else {
		cMatrixSize.width = 10;
		cMatrixSize.height = 20;

		//		if (glIsMobile)
		//			cBrickWidth = 22; // 16;
		//		else
		//			cBrickWidth = 28; // 28;
		setBrickWidth("medium");
	}
	//cBrickWidth = 16;

	if (level == 8)
		swipeFactor = 1.0;
	else
		swipeFactor = 1.5;


	glPreviewTileSize = cBrickWidth;

	glPlayGroundSize.width = (cMatrixSize.width * (cBrickWidth + 1)) - 1;
	glPlayGroundSize.height = (cMatrixSize.height * (cBrickWidth + 1)) - 1;
	glPlayGroundSize.left = glPadding;
	//	glPlayGroundSize.top = glCanvasSize.top + Math.floor(0.5 * (glCanvasSize.height - glFooterHeight - glPadding - glPlayGroundSize.height));
	glPlayGroundSize.top = glPadding;

	initDynamicRendering();

}


function selectLevel() {
	let level = glDropLevel.selectedIndex + 1;
	glUser.setLevel(level);

	glUser.calculateMaxLevel();
	initPreview();
	showPreview();
}

function selectMode() {

	let mode = glDropMode.selectedIndex + 1;
	glUser.setMode(mode);
	glUser.saveUserSettingsToDb(glUser.getId(), mode);
	glUser.calculateMaxLevel();


	initPreview();
	showPreview();

}

function initPreview() {

	prvCalculateSizes();

	previewFrameSize.height = glCanvasSize.height - 30;
	previewFrameSize.top = 15;
	previewFrameSize.left = (glCanvasSize.width - previewFrameSize.width) / 2;

	glPreviewPos.top = 70;
	glPreviewPos.left = previewFrameSize.left + 30;

	if (glUser.getLevel() <= 0)
		glUser.setLevel(1);

	setHighscore();
}


