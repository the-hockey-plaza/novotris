/*
 * rendering.js
 */

//const cMainFillColor = "#e8e8e8"; // LightBackColor -> done
//const cMainLineColor = "#707070"; // MediumGrey -> done
//const cSubLineColor = "#a00000"; // -> ???
//const cBackgroundColor = "#404040"; // PlaygroundBackColor -> done
//const cLabelColor = "#606060";  // MediumGrey -> done
//const cPlayBackColor = "#606060"; // MediumGrey -> done
//const cSmallFrameColor = "#606060"; // MediumGrey -> done
//const cFilterColor = "#e8e8e8"; // LightBackColor -> done
//
//// global color management:
//var glNovotrisColor; // characteristic color of Novotris
//var glLightTextColor; // almost white for text with background "NovotrisColor"
//var glLightBackColor; // light grey for general backgrounds
//var glDarkTextColor // dark grey for text with LightBackColor background
//var glPlaygroundBackColor; // background for the playground
//var glPlaygroundLineColor; // lines for the playground
//var glMediumGreyColor= "#808080"; // several purposes 
//var glDialogBackColor;

//	glNovotrisColor = "#5a89bf";
//	glLightTextColor = "#eaddcd";
//	glLightBackColor = "#e8e8e8";
//	glDarkTextColor = "#404040";
//	glPlaygroundBackColor = "#404040";
//	glPlaygroundLineColor = "#808080";
//	glMediumGreyColor = "#808080";
//	glDialogBackColor = "#eaddcd"; 

var glPlayFramePos = { width: 0, height: 0, left: 0, top: 0 };

function initStaticRendering() {


	//TODO
	//	glPlayFramePos.width = Math.floor(glContainerPos.width * 0.7);
	//	glPlayFramePos.height = Math.floor(glContainerPos.height * 0.85);
	let frame = document.getElementById('div-play-frame');
	glPlayFramePos.width = frame.clientWidth - 5;
	glPlayFramePos.height = frame.clientHeight - 5;


	glCanvasSize.left = 0;
	glCanvasSize.width = glPlayFramePos.width;
	glCanvasSize.height = glPlayFramePos.height;


	if (glIsMobile) {

		//fullscreen
		//	enterFullscreen(document.documentElement);
	}

	glMainCanvas.style.width = glCanvasSize.width + "px";
	glMainCanvas.style.height = glCanvasSize.height + "px";
	glMainCanvas.style.left = glCanvasSize.left + "px";
	glMainCanvas.style.top = glCanvasSize.top + "px";



	glContext = glMainCanvas.getContext("2d");
	if (glContext == null)
		console.log("initStaticRendering, glContext == null");
	else
		console.log("initStaticRendering, glContext != null");

	glContext.canvas.width = glCanvasSize.width;
	glContext.canvas.height = glCanvasSize.height;

}

function initLoginRendering() {
	// get global colors:
	//	var style = getComputedStyle(document.body);
	//
	//	glNovotrisColor = style.getPropertyValue('--novotris-color');
	//	glLightTextColor = style.getPropertyValue('--light-text-color');
	//	glLightBackColor = style.getPropertyValue('--light-back-color');
	//	glDarkTextColor = style.getPropertyValue('--dark-text-color');
	//	glPlaygroundBackColor = style.getPropertyValue('--playground-back-color');
	//	glPlaygroundLineColor = style.getPropertyValue('--playground-line-color');
	//	glMediumGreyColor = style.getPropertyValue('--medium-grey-color');


	// set positions:
	if (glIsMobile) {
		glCanvasSize.width = window.outerWidth;
		glCanvasSize.height = window.outerHeight;
		glCanvasSize.left = 0;

		//fullscreen
		//	enterFullscreen(document.documentElement);
	}
	else {
		//TODO
		//		glCanvasSize.width = 500;
		//		glCanvasSize.height = 700;
		glCanvasSize.width = 600;
		glCanvasSize.height = 750;
		glCanvasSize.left = (Math.round(window.innerWidth) - glCanvasSize.width) / 2;
	}

}

function initDynamicRendering() {
	var xPos;
	var yPos;
	var yStep;

	glPlayGroundSize.width = (cMatrixSize.width * (cBrickWidth + 1)) - 1;
	glPlayGroundSize.height = (cMatrixSize.height * (cBrickWidth + 1)) - 1;

	glPlayGroundSize.left = (glPlayFramePos.width - glPlayGroundSize.width) / 2;


}


/*
 * draw the outline of a square
 */
function drawOutline(x, y, width) {
	glContext.strokeStyle = "#c0c0c0";
	glContext.lineWidth = 1;
	glContext.strokeRect(x + 1, y + 1, width - 2, width - 2);
	glContext.strokeStyle = "#303030";
	glContext.lineWidth = 1;
	glContext.strokeRect(x + 2, y + 2, width - 4, width - 4);
}

/*
 * draw the background of the play field
 */
function drawFieldBackground(previewMode) {
	var xOff = glPlayGroundSize.left;
	var yOff = glPlayGroundSize.top;
	var width = (cMatrixSize.width * (cBrickWidth + 1)) - 1;
	var height = (cMatrixSize.height * (cBrickWidth + 1)) - 1;


	glContext.clearRect(0, 0, glCanvasSize.width, glCanvasSize.height)

	glContext.lineWidth = 4;
	//	glContext.strokeStyle = "#c0c0c0";
	glContext.strokeStyle = glLightTextColor;
	glContext.beginPath();
	glContext.rect(xOff - 7, yOff - 7, width + 14, height + 14);
	glContext.stroke();



	glContext.fillStyle = glPlaygroundBackColor;
	glContext.fillRect(xOff, yOff, width, height);

	//	glContext.strokeStyle = glMediumGreyColor;
	glContext.strokeStyle = glPlaygroundLineColor;
	glContext.lineWidth = 1;

	for (var x = 1; x < cMatrixSize.width; x++) {
		glContext.beginPath();
		glContext.moveTo(xOff + x * (cBrickWidth + 1), yOff)
		glContext.lineTo(xOff + x * (cBrickWidth + 1), yOff + height);
		glContext.stroke();
	}

	for (var y = 1; y < cMatrixSize.height; y++) {
		glContext.beginPath();
		glContext.moveTo(xOff, yOff + y * (cBrickWidth + 1))
		glContext.lineTo(xOff + width, yOff + y * (cBrickWidth + 1));
		glContext.stroke();
	}

	// matrix filter:
	glContext.fillStyle = glLightBackColor;

	for (var x = 0; x < cMatrixSize.width; x++)
		for (var y = 0; y < cMatrixSize.height; y++)
			if (glMatrixFilter[x][y] == 0) {

				var xPos = glPlayGroundSize.left + x * (cBrickWidth + 1);
				var yPos = glPlayGroundSize.top + y * (cBrickWidth + 1);

				glContext.fillRect(xPos, yPos, cBrickWidth, cBrickWidth);
				//glContext.fillRect(50, 50, 250, 250);

			}

	drawPlayData(previewMode);
}


function initPlayRendering() {
	drawFieldBackground();
	drawPlayData();
}

/*
 * draw one tile of the field, the color has to be set before
 */
function drawTile(x, y, doOutline) {
	var xPos = glPlayGroundSize.left + 1 + x * (cBrickWidth + 1);
	var yPos = glPlayGroundSize.top + 1 + y * (cBrickWidth + 1);

	if (glIsMobile)
		glContext.fillRect(xPos, yPos, cBrickWidth - 1, cBrickWidth - 1);
	else
		glContext.fillRect(xPos, yPos, cBrickWidth - 2, cBrickWidth - 2);

	if (doOutline && !glIsMobile)
		drawOutline(xPos, yPos, cBrickWidth);
}

/*
 * drawSpecialTile
 */
function drawSpecialTile(x, y) {
	let xPos = glPlayGroundSize.left + 1 + x * (cBrickWidth + 1);
	let yPos = glPlayGroundSize.top + 1 + y * (cBrickWidth + 1);

	// Variante 2:
	glContext.fillStyle = "#808080";
	glContext.fillRect(xPos + 2, yPos + 2, cBrickWidth - 4, cBrickWidth - 4);

	glContext.fillStyle = "red";
	glContext.fillRect(xPos + 5, yPos + 5, cBrickWidth - 10, cBrickWidth - 10);

	if (!glIsMobile)
		drawOutline(xPos, yPos, cBrickWidth);

	//	glContext.fillStyle = "#808080";
	//	glContext.fillRect(xPos + 5, yPos + 5, cBrickWidth - 13, cBrickWidth - 13);
	//
	//Variante 1:
	//	glContext.strokeStyle = "#808080";
	//	glContext.lineWidth = 1;
	//
	//	for (i = 4; i <= 12; i = i + 4)
	//		glContext.strokeRect(xPos + i, yPos + i, cBrickWidth - 2 * i, cBrickWidth - 2 * i);



}

function drawGroundTile(x, y) {
	let xPos = glPlayGroundSize.left + 1 + x * (cBrickWidth + 1);
	let yPos = glPlayGroundSize.top + 1 + y * (cBrickWidth + 1);

	glContext.fillStyle = "red";
	glContext.fillRect(xPos, yPos, cBrickWidth - 1, cBrickWidth - 1);

	glContext.strokeStyle = "black";
	glContext.lineWidth = 2;


	glContext.beginPath();

	glContext.moveTo(xPos + 7, yPos + 7);
	glContext.lineTo(xPos + 7 + cBrickWidth - 14, yPos + 7);

	glContext.moveTo(xPos + 7, yPos + 12);
	glContext.lineTo(xPos + 7 + cBrickWidth - 14, yPos + 12);

	glContext.moveTo(xPos + 7, yPos + 17);
	glContext.lineTo(xPos + 7 + cBrickWidth - 14, yPos + 17);

	glContext.stroke();


	//glContext.fillRect(xPos+7, yPos+7, cBrickWidth-14, cBrickWidth-14);
}

/*
 * draw the current brick
 */
function drawCurrentBrick(clear) {
	//	var xPos;
	//	var yPos;
	//	var xOffset = cMatrixSize.width * cBrickWidth;
	//
	if (clear)
		glContext.fillStyle = glPlaygroundBackColor;
	else
		glContext.fillStyle = glCurrentBrick.color;

	for (var x = 0; x < getBrickWidth(); x++)
		for (var y = 0; y < getBrickHeight(); y++) {
			if (getBrickValue(x, y) > 0) {
				drawTile(x + glCurrentBrick.x, y + glCurrentBrick.y, !clear);
			}
		}
}

/*
 * draw the matrix
 */
function drawMatrix() {
	var tile;

	drawFieldBackground();

	for (var x = 0; x < cMatrixSize.width; x++)
		for (var y = 0; y < cMatrixSize.height; y++) {
			if (glMatrixFilter[x][y] == 1) {
				if (tileIsEmpty(x, y)) {
					glContext.fillStyle = glPlaygroundBackColor;
					drawTile(x, y, false);
				}
				else {
					tile = v_matrix[x][y];

					if (tile.substring(0, 1) == "s") {
						drawSpecialTile(x, y);
						//		drawOutline(xOffset + x * cBrickWidth, y * cBrickWidth, cBrickWidth);
					}
					else if (tile.substring(0, 1) == "g")
						drawGroundTile(x, y);
					else {
						glContext.fillStyle = tile.substring(1);
						drawTile(x, y, true);
					}
				}
			}
		}
}

/*
 * draw the outline of the current brick with the given color
 */
function drawCurrentBrickOutline() {
	var xPos;
	var yPos;
	var xOffset = cMatrixSize.width * cBrickWidth;
	var xOff = glPlayGroundSize.left;
	var yOff = glPlayGroundSize.top;

	glContext.strokeStyle = "white";
	glContext.lineWidth = 2;

	for (var x = 0; x < getBrickWidth(); x++)
		for (var y = 0; y < getBrickHeight(); y++)
			if (getBrickValue(x, y) > 0) {


				xPos = xOff + 2 + (x + glCurrentBrick.x) * (cBrickWidth + 1);
				yPos = yOff + 2 + (y + glCurrentBrick.y) * (cBrickWidth + 1);

				glContext.strokeRect(xPos, yPos, cBrickWidth - 4, cBrickWidth - 4);
				//					glContext.strokeStyle = "#101010";
				//					glContext.lineWidth = 1;
				//					glContext.strokeRect(x + 1, y + 1, width - 2, width - 2);


			}
}

function drawPlayData(previewMode) {
	showScore();
	showHighscore();
}

function markFullRow(rowIdx) {
	var xPos;
	var yPos;
	var xOff = glPlayGroundSize.left;
	var yOff = glPlayGroundSize.top;

	var xOffset = cMatrixSize.width * cBrickWidth;

	glContext.strokeStyle = "black";
	glContext.lineWidth = 3;

	for (var i = 0; i < cMatrixSize.width; i++) {
		if (glMatrixFilter[i][rowIdx] == 1) {
			xPos = xOff + 7 + i * (cBrickWidth + 1);
			yPos = yOff + 7 + rowIdx * (cBrickWidth + 1);

			glContext.beginPath();
			glContext.moveTo(xPos, yPos);
			glContext.lineTo(xPos + cBrickWidth - 12, yPos + cBrickWidth - 12);
			glContext.stroke();

			glContext.beginPath();
			glContext.moveTo(xPos + cBrickWidth - 12, yPos);
			glContext.lineTo(xPos, yPos + cBrickWidth - 12);
			glContext.stroke();
		}
	}
}

function drawNovFrame(lineColor, lineWidth, width, height, left, top, edgeSize, fillColor) {
	//const egdeSize = 30;
	var xPos;
	var yPos;


	glContext.strokeStyle = lineColor;
	glContext.lineWidth = lineWidth;

	glContext.beginPath();

	xPos = left + edgeSize;
	yPos = top + 1;
	glContext.moveTo(xPos, yPos);

	xPos += width - 2 * edgeSize - 1;
	glContext.lineTo(xPos, yPos);

	xPos += edgeSize;
	yPos += edgeSize;
	glContext.lineTo(xPos, yPos);

	yPos += height - 2 * edgeSize;
	glContext.lineTo(xPos, yPos);

	xPos -= edgeSize;
	yPos += edgeSize - 2;
	glContext.lineTo(xPos, yPos);

	xPos = left + edgeSize;
	glContext.lineTo(xPos, yPos);

	xPos = left + 1;
	yPos -= edgeSize;
	glContext.lineTo(xPos, yPos);

	yPos = top + edgeSize;
	glContext.lineTo(xPos, yPos);

	xPos = left + edgeSize + 1;
	yPos = top;
	glContext.lineTo(xPos, yPos);

	if (fillColor != null) {
		glContext.fillStyle = fillColor;
		glContext.fill();
	}
	glContext.stroke();
}

//function drawText(txt, fontSize, xPos, yPos, color) {
//	var textColor;
//	var gradient = glContext.createLinearGradient(330, 0, 600, 0);
//
//	if (color == null)
//		textColor = "#707070";
//	else
//		textColor = color;
//
//
//	//glContext.font = fontSize + "px " + getComputedStyle(root).getPropertyValue('--novotris-font').trim(); 
//	//var style = getComputedStyle(document.body);
//
//	glContext.font = fontSize + "px Verdana";
//	
//	gradient.addColorStop("0", textColor);
//	gradient.addColorStop("1.0", textColor);
//	glContext.fillStyle = gradient;
//	glContext.fillText(txt, xPos, yPos);
//}
//
function drawCenteredText(txt, fontSize, xPos, yPos, color) {
	var textColor;
	var gradient = glContext.createLinearGradient(330, 0, 600, 0);

	if (color == null)
		textColor = "#707070";
	else
		textColor = color;

	//glContext.font = fontSize + "px " + getComputedStyle(root).getPropertyValue('--novotris-font').trim(); 
	glContext.font = fontSize + "px Verdana";

	gradient.addColorStop("0", textColor);
	gradient.addColorStop("1.0", textColor);

	//	glContext.fillStyle = gradient;

	var metrics = glContext.measureText(txt);
	var w = metrics.width;
	var h = metrics.height;
	h = metrics.actualBoundingBoxAscent + metrics.actualBoundingBoxDescent;

	glContext.fillStyle = 'rgba(70,70,70,0.4)';
	glContext.fillText(txt, xPos - w / 2 + 2, yPos + h / 2 + 2);
	glContext.fillStyle = textColor;
	glContext.fillText(txt, xPos - w / 2, yPos + h / 2);
}

function enterFullscreen(element) {
	var errorMsg;

	if (element.requestFullscreen) {
		//fullscreen
		element.requestFullscreen();
		//errorMsg = element.requestFullscreen("hide");
	} else if (element.msRequestFullscreen) {      // for IE11 (remove June 15, 2022)
		element.msRequestFullscreen();
	} else if (element.webkitRequestFullscreen) {  // iOS Safari
		element.webkitRequestFullscreen();
	}
}

function hideAddressBar() {
	if (document.documentElement.scrollHeight < window.outerHeight / window.devicePixelRatio)
		document.documentElement.style.height = (window.outerHeight / window.devicePixelRatio) + 'px';
	setTimeout(window.scrollTo(1, 1), 0);
}

function isOnPlayground(x, y) {
	if (x < glCanvasSize.left + glPlayGroundSize.left || x > glCanvasSize.left + glPlayGroundSize.left + glPlayGroundSize.width)
		return false;

	if (y < glCanvasSize.top + glPlayGroundSize.top || y > glCanvasSize.top + glPlayGroundSize.top + glPlayGroundSize.height)
		return false;

	return true;
}


