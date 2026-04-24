/**
 * 
 */

var swipeFactor = 1.5;
var touchStatus = "stopped";

var rect;
var swipeEventTarget;
var touchStartTime = 0;
var activePointerId = null;

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

	normalizePoint: function (event) {
		if (event.touches && event.touches.length > 0) {
			return event.touches[0];
		}

		if (event.changedTouches && event.changedTouches.length > 0) {
			return event.changedTouches[0];
		}

		if (typeof event.pageX === 'number' && typeof event.pageY === 'number') {
			return event;
		}

		return null;
	},

	usesPointerEvents: function () {
		return typeof window !== 'undefined' && typeof window.PointerEvent !== 'undefined';
	},

	isStartEventAllowed: function (event) {
		if (event.type === 'pointerdown') {
			if (event.isPrimary === false) {
				return false;
			}

			if (event.pointerType === 'mouse' && event.button !== 0) {
				return false;
			}
		}

		if (event.type === 'mousedown' && event.button !== 0) {
			return false;
		}

		return true;
	},

	isTrackedPointerEvent: function (event) {
		if (!classSwipe.usesPointerEvents() || event.type.indexOf('pointer') !== 0) {
			return true;
		}

		if (activePointerId === null) {
			return event.type === 'pointerdown';
		}

		return event.pointerId === activePointerId;
	},

	beginGesture: function (event, point) {
		if (point == null || !classSwipe.isStartEventAllowed(event)) {
			return;
		}

		if (!isOnPlayground(point.pageX, point.pageY)) {
			return;
		}

		touchStatus = "started";
		dropCounter = 0;
		touchStartTime = Date.now();
		if (event.cancelable) {
			event.preventDefault();
		}

		startPos.x = point.pageX;
		startPos.y = point.pageY;
		movePos.x = point.pageX;
		movePos.y = point.pageY;
		brickPos.x = 0;
		brickPos.y = 0;

		if (event.type === 'pointerdown') {
			activePointerId = event.pointerId;
			if (event.currentTarget && event.currentTarget.setPointerCapture) {
				try {
					event.currentTarget.setPointerCapture(event.pointerId);
				} catch (error) {
					testLog('setPointerCapture failed', error);
				}
			}
		}
	},

	moveGesture: function (event, point) {
		var movedX;
		var movedY;

		if (point == null || touchStatus == "stopped") {
			return;
		}

		movedX = Math.abs(point.pageX - startPos.x);
		movedY = Math.abs(point.pageY - startPos.y);
		if (touchStatus == "started" && (movedX > cTapMoveTolerancePx || movedY > cTapMoveTolerancePx)) {
			touchStatus = "moving";
		}
		if (event.cancelable) {
			event.preventDefault();
		}

		movePos.x = point.pageX;
		movePos.y = point.pageY;
		if (classSwipe.checkDirection()) {
			logText += brickPos.x + "/" + brickPos.y + " ";
			document.getElementById('mobile_info').innerHTML = logText;
		}
	},

	resetGesture: function () {
		startPos.x = -1;
		startPos.y = -1;
		movePos.x = -1;
		movePos.y = -1;
		brickPos.x = 0;
		brickPos.y = 0;
		dropCounter = 0;
		touchStatus = "stopped";
		touchStartTime = 0;
		activePointerId = null;
	},

	endGesture: function (event, point, shouldRotate) {
		var diffX;
		var diffY;
		var moveDistance;
		var touchDuration;
		var isTap;
		var hasActiveGesture;

		hasActiveGesture = touchStatus == "started" || touchStatus == "moving";
		if (!hasActiveGesture) {
			classSwipe.resetGesture();
			return;
		}

		if (hasActiveGesture) {
			if (event.cancelable) {
				event.preventDefault();
			}
		}

		if (point != null) {
			diffX = point.pageX - startPos.x;
			diffY = point.pageY - startPos.y;
		}
		else {
			diffX = movePos.x - startPos.x;
			diffY = movePos.y - startPos.y;
		}

		moveDistance = Math.sqrt(diffX * diffX + diffY * diffY);
		touchDuration = Date.now() - touchStartTime;
		isTap = shouldRotate !== false
			&& touchStartTime > 0
			&& moveDistance <= cTapDistanceMaxPx
			&& touchDuration <= cTapDurationMaxMs;

		if (isTap) {
			stone_rotate_left();
		}

		if (event.type === 'pointerup' || event.type === 'pointercancel') {
			if (event.currentTarget && event.currentTarget.releasePointerCapture) {
				try {
					event.currentTarget.releasePointerCapture(event.pointerId);
				} catch (error) {
					testLog('releasePointerCapture failed', error);
				}
			}
		}

		classSwipe.resetGesture();
	},

	inputHandler: function (event) {
		var point;

		if (typeof event === 'undefined') {
			return;
		}

		if (v_status == cStatusFinished)
			return;

		if (!classSwipe.isTrackedPointerEvent(event)) {
			return;
		}

		point = classSwipe.normalizePoint(event);

		switch (event.type) {
			case 'pointerdown':
			case 'touchstart':
			case 'mousedown':
				classSwipe.beginGesture(event, point);
				break;

			case 'pointermove':
			case 'touchmove':
			case 'mousemove':
				classSwipe.moveGesture(event, point);
				break;

			case 'pointerup':
			case 'touchend':
			case 'mouseup':
				classSwipe.endGesture(event, point, true);
				break;

			case 'pointercancel':
			case 'touchcancel':
				classSwipe.endGesture(event, point, false);
				break;

			default:
				break;
		}

	},

	stop: function () {
		classSwipe.resetGesture();
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
		const passiveFalseOptions = { passive: false };

		if (classSwipe.usesPointerEvents()) {
			target.addEventListener('pointerdown', classSwipe.inputHandler, passiveFalseOptions);
			target.addEventListener('pointermove', classSwipe.inputHandler, passiveFalseOptions);
			target.addEventListener('pointerup', classSwipe.inputHandler, passiveFalseOptions);
			target.addEventListener('pointercancel', classSwipe.inputHandler, passiveFalseOptions);
			return;
		}

		target.addEventListener('touchstart', classSwipe.inputHandler, passiveFalseOptions);
		target.addEventListener('touchmove', classSwipe.inputHandler, passiveFalseOptions);
		target.addEventListener('touchend', classSwipe.inputHandler, passiveFalseOptions);
		target.addEventListener('touchcancel', classSwipe.inputHandler, passiveFalseOptions);
		target.addEventListener('mousedown', classSwipe.inputHandler, passiveFalseOptions);
		target.addEventListener('mousemove', classSwipe.inputHandler, passiveFalseOptions);
		target.addEventListener('mouseup', classSwipe.inputHandler, passiveFalseOptions);
	}
};

classSwipe.init();