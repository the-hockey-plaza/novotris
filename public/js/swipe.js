/**
 * 
 */

var swipeFactor = 1.5;
var touchStatus;

var rect;

var startPos = { "x": -1, "y": -1 };
var movePos = { "x": -1, "y": -1 };
var brickPos = { "x": 0, "y": 0 };
var dropCounter = 0;

function testLog(txt, p1) {
	return null;
}

var classSwipe = {
	touches: {
		"touchstart": { "x": -1, "y": -1 },
		"touchmove": { "x": -1, "y": -1 },
		"touchend": false,
		"direction": "undetermined"
	},


	checkDirection: function() {
		var diff = { "x": 0, "y": 0 };
		var oldBrickPos = { "x": 0, "y": 0 };

		if (startPos.x == -1)
			return false;

		oldBrickPos.x = brickPos.x;
		oldBrickPos.y = brickPos.y;

		diff.x = movePos.x - startPos.x;
		diff.y = movePos.y - startPos.y;

		brickPos.x = Math.floor(diff.x / (swipeFactor * cBrickWidth));
		brickPos.y = Math.floor(diff.y / (swipeFactor * cBrickWidth));
		if (brickPos.y < oldBrickPos.y)
			brickPos.y = oldBrickPos.y;

		// move left:
		if (brickPos.x < oldBrickPos.x) {
			//		dropCounter = 0;
			if (dropCounter == 0) {
				stone_left();
				return true;
			}
		}

		// move right:
		if (brickPos.x > oldBrickPos.x) {
			//	dropCounter = 0;
			if (dropCounter == 0) {
				stone_right();
				return true;
			}
		}

		if (brickPos.y > oldBrickPos.y) {
			if (dropCounter >= 0)
				++dropCounter;

			if (dropCounter >= 3) {
				// drop:
				dropCounter = -1;
				stone_drop();
			}
			else
				// move down:		
				brickDown();
			return true;
		}
	},


	touchHandler: function(event) {
		var touch;

		if (typeof event === 'undefined') {
			return;
		}
		
		if (v_status == cStatusFinished)
	  	return;

		touch = event.touches[0];
		switch (event.type) {
			case 'touchstart':
				if (isOnPlayground(touch.pageX, touch.pageY)) {
					touchStatus = "started";
					dropCounter = 0;


					//				classSwipe.touches[event.type].x = touch.pageX;
					//				classSwipe.touches[event.type].y = touch.pageY;
					startPos.x = touch.pageX;
					startPos.y = touch.pageY;

					//	brickPos = { "x": 0, "y": 0 };
					brickPos.x = 0;
					brickPos.y = 0;
				}
				break;

			case 'touchmove':
				if (touchStatus != "stopped") {
					if (touchStatus == "started") {
						touchStatus = "moving";
					}

					movePos.x = touch.pageX;
					movePos.y = touch.pageY;
					if (classSwipe.checkDirection()) {
						logText += brickPos.x + "/" + brickPos.y + " ";
						document.getElementById('mobile_info').innerHTML = logText;
					}
				}
				break;

			case 'touchend':
				if (event.targetTouches.length <= 1) {
					if (touchStatus == "started") {
						stone_rotate_left();
					}
				}

				dropCounter = 0;
				touchStatus = "stopped";
				break;

			default:
				break;
		}

	},

	stop: function() {
		touchStatus = "stopped";
	},

	init: function() {
		document.addEventListener('touchstart', classSwipe.touchHandler, false);
		document.addEventListener('touchmove', classSwipe.touchHandler, false);
		document.addEventListener('touchend', classSwipe.touchHandler, false);
	}
};

classSwipe.init();