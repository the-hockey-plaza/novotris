/**
 * 
 */

var swipeFactor = 1.5;
var touchStatus;

var rect;
var swipeEventTarget;
var touchStartTime = 0;

const cTapMoveTolerancePx = 8;
const cTapDistanceMaxPx = 12;
const cTapDurationMaxMs = 320;

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


	checkDirection: function () {
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


	touchHandler: function (event) {
		var touch;
		var movedX;
		var movedY;
		var endTouch;
		var diffX;
		var diffY;
		var moveDistance;
		var touchDuration;
		var isTap;

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
					touchStartTime = Date.now();
					if (event.cancelable) {
						event.preventDefault();
					}


					//				classSwipe.touches[event.type].x = touch.pageX;
					//				classSwipe.touches[event.type].y = touch.pageY;
					startPos.x = touch.pageX;
					startPos.y = touch.pageY;
					movePos.x = touch.pageX;
					movePos.y = touch.pageY;

					//	brickPos = { "x": 0, "y": 0 };
					brickPos.x = 0;
					brickPos.y = 0;
				}
				break;

			case 'touchmove':
				if (touchStatus != "stopped") {
					movedX = Math.abs(touch.pageX - startPos.x);
					movedY = Math.abs(touch.pageY - startPos.y);
					if (touchStatus == "started" && (movedX > cTapMoveTolerancePx || movedY > cTapMoveTolerancePx)) {
						touchStatus = "moving";
					}
					if (event.cancelable) {
						event.preventDefault();
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
				if (touchStatus == "started" || touchStatus == "moving") {
					if (event.cancelable) {
						event.preventDefault();
					}
				}

				endTouch = null;
				if (event.changedTouches && event.changedTouches.length > 0) {
					endTouch = event.changedTouches[0];
				}

				if (endTouch != null) {
					diffX = endTouch.pageX - startPos.x;
					diffY = endTouch.pageY - startPos.y;
				}
				else {
					diffX = movePos.x - startPos.x;
					diffY = movePos.y - startPos.y;
				}

				moveDistance = Math.sqrt(diffX * diffX + diffY * diffY);
				touchDuration = Date.now() - touchStartTime;
				isTap = moveDistance <= cTapDistanceMaxPx && touchDuration <= cTapDurationMaxMs;

				if (isTap) {
					stone_rotate_left();
				}

				dropCounter = 0;
				touchStatus = "stopped";
				touchStartTime = 0;
				break;

			default:
				break;
		}

	},

	stop: function () {
		touchStatus = "stopped";
	},

	getEventTarget: function () {
		if (swipeEventTarget) {
			return swipeEventTarget;
		}

		swipeEventTarget = document.getElementById('mainCanvas');
		if (!swipeEventTarget) {
			swipeEventTarget = document.getElementById('div-play-frame');
		}

		if (!swipeEventTarget) {
			swipeEventTarget = document;
		}

		return swipeEventTarget;
	},

	init: function () {
		const target = classSwipe.getEventTarget();
		const options = { passive: false };

		target.addEventListener('touchstart', classSwipe.touchHandler, options);
		target.addEventListener('touchmove', classSwipe.touchHandler, options);
		target.addEventListener('touchend', classSwipe.touchHandler, options);
	}
};

classSwipe.init();