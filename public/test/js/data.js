/*
 * global declarations
 */

//const cMatrixSize.width = 10;
//const cMatrixSize.height = 20;

var cMatrixSize = { width: 12, height: 24 };
var cBrickWidth;

var glConfig;
var glMatrixFilter;


/*
 * read config from file
 */
function readConfigFile(fileName, callback) {
	var xmlHttp = new XMLHttpRequest();

	xmlHttp.onreadystatechange =
		function() {
			if (xmlHttp.status == 200 && xmlHttp.readyState == 4) {
				callback(xmlHttp.responseText);
			}
		};

	xmlHttp.open("GET", fileName, true);
	xmlHttp.send();
}

/*
 * callback for reading config file
 */
function handleFileData(fileData) {
	document.getElementById('log').innerHTML = fileData;
	//  glConfig = JSON.parse(fileData);
	glConfig = fileData;
}


/*
 * initialize configuration instead of reading from file
 */
function initConfig(tmp) {
	/*
	glConfig = '{ "numberOfTypes": 4, "types": [' +
	'{ "color": "red", "points": 2, "width": 3, "height": 2, "layout": [1,1,0,0,1,1] },' +
			'{ "color": "blue", "points": 3, "width": 4, "height": 1, "layout": [1,1,1,1] },' +
		'{ "color": "yellow", "points": 3, "width": 2, "height": 2, "layout": [1,1,1,1] },' +
			'{ "color": "green", "points": 1, "width": 3, "height": 2, "layout": [0,1,0,1,1,1] }' +
			' ]}';
*/

/* 
  bis 22.03.2023 
  
	glConfig = '{ "types": [' +
		'{ "color": "#5cd65c", "levels": [1,2,3,4,5,6,7,8], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [0,1,0,1,1,1]}, {"pos": [0,0], "form": [0,1,1,1,0,1]} ,{"pos": [0,0], "form": [1,1,1,0,1,0]}, {"pos": [1,0], "form": [1,0,1,1,1,0]}]}' +
		',{ "color": "#ff8533", "levels": [1,2,3,4,5,6], "level": 1, "points": 3, "width": 4, "height": 1, "layout": [{"pos": [0,0], "form": [1,1,1,1]}, {"pos": [1,0], "form": [1,1,1,1]}]}' +
		',{ "color": "#3377ff", "levels": [1,2,3,4,5,6,7], "level": 1, "points": 3, "width": 2, "height": 2, "layout": [{"pos": [0,0], "form": [1,1,1,1]}, {"pos": [0,0], "form": [1,1,1,1]}]}' +
		',{ "color": "#ffff33", "levels": [1,2,3,4,5,6,8], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [1,1,0,0,1,1]}, {"pos": [0,0], "form": [0,1,1,1,1,0]}]}' +
		',{ "color": "#9933ff", "levels": [1,2,3,4,5,6,8], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [0,1,1,1,1,0]}, {"pos": [1,0], "form": [1,0,1,1,0,1]}]}' +
		',{ "color": "#ff3399", "levels": [1,2,3,4,5,6], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [1,0,0,1,1,1]}, {"pos": [0,0], "form": [0,1,0,1,1,1]}, {"pos": [0,0], "form": [1,1,1,0,0,1]}, {"pos": [1,0], "form": [1,1,1,0,1,0]}]}' +
		',{ "color": "#8888aa", "levels": [1,2,3,4,5,6], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [0,0,1,1,1,1]}, {"pos": [0,0], "form": [1,1,0,1,0,1]}, {"pos": [0,0], "form": [1,1,1,1,0,0]}, {"pos": [1,0], "form": [1,0,1,0,1,1]}]}' +
		',{ "color": "#85adad", "levels": [2], "level": 2, "points": 2, "width": 2, "height": 2, "layout": [{"pos": [0,0], "form": [1,0,1,1]}, {"pos": [0,0], "form": [0,1,1,1]}, {"pos": [0,0], "form": [1,1,0,1]}, {"pos": [0,0], "form": [1,1,1,0]}]}' +
		',{ "color": "#ffbb33", "levels": [2,7,8], "level": 2, "points": 2, "width": 3, "height": 1, "layout": [{"pos": [0,0], "form": [1,1,1]}, {"pos": [1,0], "form": [1,1,1]}]}' +
		',{ "color": "#ff33ff", "levels": [4,6,7], "level": 5, "points": 2, "width": 2, "height": 2, "layout": [{"pos": [0,0], "form": [1,0,0,1]}, {"pos": [0,0], "form": [0,1,1,0]}]}' +
		',{ "color": "#cc9966", "levels": [4,7,8], "level": 5, "points": 1, "width": 1, "height": 1, "layout": [{"pos": [0,0], "form": [1]},{"pos": [0,0], "form": [1]}]}' +
		',{ "color": "#00cccc", "levels": [7], "level": 5, "points": 6, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [1,1,1,1,0,1]},{"pos": [0,0], "form": [1,1,1,0,1,1]},{"pos": [0,0], "form": [1,0,1,1,1,1]},{"pos": [1,0], "form": [1,1,0,1,1,1]}]}' +
		',{ "color": "#993333", "levels": [9], "level": 5, "points": 6, "width": 3, "height": 3, "layout": [{"pos": [0,0], "form": [0,1,0,1,1,1,0,1,0]}]}' +
		',{ "color": "#adad85", "levels": [4,7], "level": 2, "points": 6, "width": 3, "height": 3, "layout": [{"pos": [0,0], "form": [0,0,1,0,1,0,1,0,0]}, {"pos": [0,0], "form": [1,0,0,0,1,0,0,0,1]}]}' +
		' ], "levels": [200,400,600,800,1000,1200,1400]}';


  bis 30.03.2023
  
	glConfig = '{ "types": [' +
		'{ "color": "#5cd65c", "levels": [1,2,3,4,5,6,7,8], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [0,1,0,1,1,1]}, {"pos": [0,0], "form": [0,1,1,1,0,1]} ,{"pos": [0,0], "form": [1,1,1,0,1,0]}, {"pos": [1,0], "form": [1,0,1,1,1,0]}]}' +
		',{ "color": "#ff8533", "levels": [1,2,3,4,5,6], "level": 1, "points": 3, "width": 4, "height": 1, "layout": [{"pos": [0,0], "form": [1,1,1,1]}, {"pos": [1,0], "form": [1,1,1,1]}]}' +
		',{ "color": "#3377ff", "levels": [1,2,3,4,5,6,7], "level": 1, "points": 3, "width": 2, "height": 2, "layout": [{"pos": [0,0], "form": [1,1,1,1]}, {"pos": [0,0], "form": [1,1,1,1]}]}' +
		',{ "color": "#ffff33", "levels": [1,2,3,4,5,6,8], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [1,1,0,0,1,1]}, {"pos": [0,0], "form": [0,1,1,1,1,0]}]}' +
		',{ "color": "#9933ff", "levels": [1,2,3,4,5,6,8], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [0,1,1,1,1,0]}, {"pos": [1,0], "form": [1,0,1,1,0,1]}]}' +
		',{ "color": "#ff3399", "levels": [1,2,3,4,5,6], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [1,0,0,1,1,1]}, {"pos": [0,0], "form": [0,1,0,1,1,1]}, {"pos": [0,0], "form": [1,1,1,0,0,1]}, {"pos": [1,0], "form": [1,1,1,0,1,0]}]}' +
		',{ "color": "#8888aa", "levels": [1,2,3,4,5,6], "level": 1, "points": 3, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [0,0,1,1,1,1]}, {"pos": [0,0], "form": [1,1,0,1,0,1]}, {"pos": [0,0], "form": [1,1,1,1,0,0]}, {"pos": [1,0], "form": [1,0,1,0,1,1]}]}' +
		',{ "color": "#85adad", "levels": [4], "level": 2, "points": 2, "width": 2, "height": 2, "layout": [{"pos": [0,0], "form": [1,0,1,1]}, {"pos": [0,0], "form": [0,1,1,1]}, {"pos": [0,0], "form": [1,1,0,1]}, {"pos": [0,0], "form": [1,1,1,0]}]}' +
		',{ "color": "#ffbb33", "levels": [2,7,8], "level": 2, "points": 2, "width": 3, "height": 1, "layout": [{"pos": [0,0], "form": [1,1,1]}, {"pos": [1,0], "form": [1,1,1]}]}' +
		',{ "color": "#ff33ff", "levels": [4,6,7], "level": 5, "points": 2, "width": 2, "height": 2, "layout": [{"pos": [0,0], "form": [1,0,0,1]}, {"pos": [0,0], "form": [0,1,1,0]}]}' +
		',{ "color": "#cc9966", "levels": [4,7,8], "level": 5, "points": 1, "width": 1, "height": 1, "layout": [{"pos": [0,0], "form": [1]},{"pos": [0,0], "form": [1]}]}' +
		',{ "color": "#00cccc", "levels": [7], "level": 5, "points": 6, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [1,1,1,1,0,1]},{"pos": [0,0], "form": [1,1,1,0,1,1]},{"pos": [0,0], "form": [1,0,1,1,1,1]},{"pos": [1,0], "form": [1,1,0,1,1,1]}]}' +
		',{ "color": "#993333", "levels": [9], "level": 5, "points": 6, "width": 3, "height": 3, "layout": [{"pos": [0,0], "form": [0,1,0,1,1,1,0,1,0]}]}' +
		',{ "color": "#adad85", "levels": [2,7], "level": 2, "points": 6, "width": 3, "height": 3, "layout": [{"pos": [0,0], "form": [0,0,1,0,1,0,1,0,0]}, {"pos": [0,0], "form": [1,0,0,0,1,0,0,0,1]}]}' +
		' ], "levels": [200,400,600,800,1000,1200,1400]}';

 */

	glConfig = '{ "types": [' +
		'{ "color": "#5cd65c", "levels": [1,2,3,4,5,6,7,8], "level": 1, "points": 8, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [0,1,0,1,1,1]}, {"pos": [0,0], "form": [0,1,1,1,0,1]} ,{"pos": [0,0], "form": [1,1,1,0,1,0]}, {"pos": [1,0], "form": [1,0,1,1,1,0]}]}' +
		',{ "color": "#ff8533", "levels": [1,2,3,4,5,6], "level": 1, "points": 8, "width": 4, "height": 1, "layout": [{"pos": [0,0], "form": [1,1,1,1]}, {"pos": [1,0], "form": [1,1,1,1]}]}' +
		',{ "color": "#3377ff", "levels": [1,2,3,4,5,6,7,8], "level": 1, "points": 8, "width": 2, "height": 2, "layout": [{"pos": [0,0], "form": [1,1,1,1]}, {"pos": [0,0], "form": [1,1,1,1]}]}' +
		',{ "color": "#ffff33", "levels": [1,2,3,4,5,6,8], "level": 1, "points": 8, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [1,1,0,0,1,1]}, {"pos": [0,0], "form": [0,1,1,1,1,0]}]}' +
		',{ "color": "#9933ff", "levels": [1,2,3,4,5,6,8], "level": 1, "points": 8, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [0,1,1,1,1,0]}, {"pos": [1,0], "form": [1,0,1,1,0,1]}]}' +
		',{ "color": "#ff3399", "levels": [1,2,3,4,5,6], "level": 1, "points": 8, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [1,0,0,1,1,1]}, {"pos": [0,0], "form": [0,1,0,1,1,1]}, {"pos": [0,0], "form": [1,1,1,0,0,1]}, {"pos": [1,0], "form": [1,1,1,0,1,0]}]}' +
		',{ "color": "#8888aa", "levels": [1,2,3,4,5,6], "level": 1, "points": 8, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [0,0,1,1,1,1]}, {"pos": [0,0], "form": [1,1,0,1,0,1]}, {"pos": [0,0], "form": [1,1,1,1,0,0]}, {"pos": [1,0], "form": [1,0,1,0,1,1]}]}' +
		',{ "color": "#85adad", "levels": [4], "level": 2, "points": 6, "width": 2, "height": 2, "layout": [{"pos": [0,0], "form": [1,0,1,1]}, {"pos": [0,0], "form": [0,1,1,1]}, {"pos": [0,0], "form": [1,1,0,1]}, {"pos": [0,0], "form": [1,1,1,0]}]}' +
		',{ "color": "#ffbb33", "levels": [2,7,8], "level": 2, "points": 6, "width": 3, "height": 1, "layout": [{"pos": [0,0], "form": [1,1,1]}, {"pos": [1,0], "form": [1,1,1]}]}' +
		',{ "color": "#ff33ff", "levels": [4,6,7], "level": 5, "points": 4, "width": 2, "height": 2, "layout": [{"pos": [0,0], "form": [1,0,0,1]}, {"pos": [0,0], "form": [0,1,1,0]}]}' +
		',{ "color": "#cc9966", "levels": [4,7,8], "level": 5, "points": 2, "width": 1, "height": 1, "layout": [{"pos": [0,0], "form": [1]},{"pos": [0,0], "form": [1]}]}' +
		',{ "color": "#00cccc", "levels": [7], "level": 5, "points": 10, "width": 3, "height": 2, "layout": [{"pos": [0,0], "form": [1,1,1,1,0,1]},{"pos": [0,0], "form": [1,1,1,0,1,1]},{"pos": [0,0], "form": [1,0,1,1,1,1]},{"pos": [1,0], "form": [1,1,0,1,1,1]}]}' +
		',{ "color": "#993333", "levels": [9], "level": 5, "points": 10, "width": 3, "height": 3, "layout": [{"pos": [0,0], "form": [0,1,0,1,1,1,0,1,0]}]}' +
		',{ "color": "#adad85", "levels": [2,7], "level": 2, "points": 6, "width": 3, "height": 3, "layout": [{"pos": [0,0], "form": [0,0,1,0,1,0,1,0,0]}, {"pos": [0,0], "form": [1,0,0,0,1,0,0,0,1]}]}' +
		' ], "levels": [200,400,600,800,1000,1200,1400]}';



	glConfig = JSON.parse(glConfig);
}


/*
	v_stone_1 [0][0] = 1;

	v_stone_2 [0][1] = 2
	v_stone_2 [2][1] = 2;

	v_stone_3 [0][0] = 3;
	v_stone_3 [0][1] = 3;
	v_stone_3 [1][1] = 3;

	v_stone_4 [0][0] = 4;
	v_stone_4 [0][1] = 4
	v_stone_4 [1][0] = 4;
	v_stone_4 [1][1] = 4;

	v_stone_5 [0][0] = 5;
	v_stone_5 [0][1] = 5;
	v_stone_5 [0][2] = 5;
	v_stone_5 [1][2] = 5;
	v_stone_5 [2][2] = 5;

	v_stone_6 [1][0] = 6;
	v_stone_6 [0][1] = 6
	v_stone_6 [1][1] = 6;
	v_stone_6 [2][1] = 6;
	v_stone_6 [1][2] = 6;

	v_stone_7 [2][0] = 7;
	v_stone_7 [1][1] = 7;
	v_stone_7 [0][1] = 7;
	*/
/*
 * set brick element
 */
function setBrickValue(brick, x, y, value) {
	brick.layout[(y * brick.width) + x] = value;
}

/*
 * get brick element
 */
function getBrickValue(x, y) {
	var layout = glCurrentBrick.layout[glCurrentBrick.rotateIdx];
	var form = layout.form;

	return form[(y * getBrickWidth()) + x];
}

function getBrickWidth() {
	if (glCurrentBrick.rotateIdx % 2 == 0)
		return glCurrentBrick.width;
	else
		return glCurrentBrick.height;
}

function getBrickHeight() {
	if (glCurrentBrick.rotateIdx % 2 == 0)
		return glCurrentBrick.height;
	else
		return glCurrentBrick.width;
}

function incrementRotateIdx() {
	var layout;

	layout = glCurrentBrick.layout[glCurrentBrick.rotateIdx];
	glCurrentBrick.x = glCurrentBrick.x - layout.pos[0];
	glCurrentBrick.y = glCurrentBrick.y - layout.pos[1];

	glCurrentBrick.rotateIdx++;
	if (glCurrentBrick.rotateIdx >= glCurrentBrick.layout.length)
		glCurrentBrick.rotateIdx = 0;

	layout = glCurrentBrick.layout[glCurrentBrick.rotateIdx];
	glCurrentBrick.x = glCurrentBrick.x + layout.pos[0];
	glCurrentBrick.y = glCurrentBrick.y + layout.pos[1];
}

function decrementRotateIdx() {
	var layout;

	layout = glCurrentBrick.layout[glCurrentBrick.rotateIdx];
	glCurrentBrick.x = glCurrentBrick.x - layout.pos[0];

	glCurrentBrick.rotateIdx--;
	if (glCurrentBrick.rotateIdx < 0)
		glCurrentBrick.rotateIdx = glCurrentBrick.layout.length - 1;

	layout = glCurrentBrick.layout[glCurrentBrick.rotateIdx];
	glCurrentBrick.x = glCurrentBrick.x + layout.pos[0];
}

/*
 * main section
 */
//readConfigFile ("config.json", handleFileData);
initConfig("abc");
// document.getElementById('myversion').innerHTML = glVersion;

/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/

