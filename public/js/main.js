/*
 * main.js 
 */

const glResetPos = { width: 225, height: 185, left: 0, top: 225 };
const glFooterHeight = 30;
const glMainFooterHeight = 50;


var glIsMobile = false;
var glIsTablet = false;
var glTestCase = 0;
var glGameLabel = "Novotris";

var glCanvasX;
var glContext;
var glFooter;
var glMainFooter;

// Buttons:
var glBtnTest;
var glBtnPause;
//var glBtnReset;
var glBtnLevel;
var glBtnPrevious;
var glBtnNext;
var glBtnPlay;
var glBtnHelp;
var glBtnRanking;
var glBtnHome;
var glBtnMoveLeft;
var glBtnMoveDown;
var glBtnDropDown;
var glBtnRotate;
var glBtnMoveRight;
var glTxtTopic;
//var glBtnPrefs;
var glInputUserName;

var glLblName;

var glCanvasSize = { width: 600, height: 900, left: 0, top: 0 };
var glPlayFrameSize = { width: 380, height: 550, left: 25, top: 15 };
var glPlayGroundSize = { width: 0, height: 0, left: 0, top: 0 };
var glMainEdgeSize = 30;

var glTxtReset;
var glBtnDialogOk;
var glBtnDialogCancel;

var glFormPref;

var glFormRegistration;
var glUserNamePos = { width: 120, height: 0, left: 0, top: 0 };
var glFormRegistrationPos = { width: 0, height: 350, left: 0, top: 150 };
var glInputRegistrationUserName;
var glInputRegistrationEmail;
var glInputRegistrationPassword;
var glInputRegistrationPasswordRepeat;

var glUserNamePos = { width: 120, height: 0, left: 0, top: 0 };
var glInputLoginUserName;
var glInputLoginPassword;
var glInputChangeUserName;


var glLogOrder = 0;

var glDbName = "novotris_work";

var glDivMainWindow;

var glNewsIdx = 1;
var glNewsCount;
var glContainerPos = { width: 0, height: 0, left: 0, top: 0 };


function mainMobileAndTabletCheck() {
	let check = false;
	(function (a) {
		if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i
			.test(a)
			|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
				.test(a.substr(0, 4)))
			check = true;
	})(navigator.userAgent || navigator.vendor || window.opera);


	glIsMobile = check;
	//glIsMobile = true;
	//TODO 
	//glIsTablet = (window.outerHeight > 700);
	glIsTablet = false;

}

function mainAssignElements() {
	glDivMainWindow = document.getElementById('div-main-window');

	glBtnDialogCancel = document.getElementById('dialog_cancel');
	glBtnDialogOk = document.getElementById('dialog_ok');
	glBtnHelp = document.getElementById('class_help_show');
	glBtnHome = document.getElementById('do_home');
	glBtnPlay = document.getElementById('do_play');
	//	glBtnPrefs = document.getElementById('set_prefs');
	glBtnPrvPlay = document.getElementById('btn-prv-play');
	glBtnRanking = document.getElementById('show_ranking');
	glBtnRankingShowAll = document.getElementById('ranking_show_all');
	//	glBtnReset = document.getElementById('reset_highscore');
	glDivRanking = document.getElementById('div-ranking');
	glFooter = document.getElementById('footer');
	glMainFooter = document.getElementById('main-footer');
	glFormPref = document.getElementById('form_pref');
	glFormRegistration = document.getElementById('form_registration');
	glInputUserName = document.getElementById('username');
	glFormChangeUserName = document.getElementById('form_change_user_name');
	glInputChangeUserName = document.getElementById('input_change_user_name');

	glTxtTopic = document.getElementById('p-topic');
	glLblName = document.getElementById('lbl-name');

}

function mainAssignLoginElements() {
	glInputLoginUserName = document.getElementById('input_login_user_name');
	glInputLoginPassword = document.getElementById('input_login_password');

}

function mainAssignRegistrationElements() {
	glInputRegistrationUserName = document.getElementById('input_registration_user_name');
	glInputRegistrationEmail = document.getElementById('input_registration_email');
	glInputRegistrationPassword = document.getElementById('input_registration_password');
	glInputRegistrationPasswordRepeat = document.getElementById('input_registration_password_repeat');
}

function mainAssignResetPasswordElements() {
	glInputRegistrationUserName = document.getElementById('input_registration_user_name');
	glInputRegistrationEmail = document.getElementById('input_registration_email');
}

function mainAssignChangePasswordElements() {
	glInputRegistrationPassword = document.getElementById('input_registration_password');
	glInputRegistrationPasswordRepeat = document.getElementById('input_registration_password_repeat');
}

function mainUpdateFooter() {
	let elem;
	let userName = "";
	let gastId;

	elem = document.getElementById('footer-version');
	if (elem != null)
		elem.innerHTML = "Novotris " + glRelease;

	if (glUser != null) {
		userName = glUser.getName();
		gastId = glUser.getGastId();
	}

	elem = document.getElementById('footer-user');
	if (elem != null)
		elem.innerHTML = userName;

	elem = document.getElementById('footer-login');
	if (elem != null) {
		if (gastId != null)
			elem.innerHTML = getText("logout");
		else
			elem.innerHTML = getText("login");
	}

	let drpLanguage = document.getElementById('drp-language');

	if (drpLanguage != null) {
		drpLanguage.addEventListener('change', chooseLanguage);

		if (glUser.getLanguage() == "en")
			drpLanguage.selectedIndex = 1;
		else
			drpLanguage.selectedIndex = 0;
	}
}


function mainParseURL() {
	glTestCase = 0;

	let urlParams = new URLSearchParams(window.location.search);
	let activationCode;

	glTestCase = urlParams.get('t');

	if (urlParams.get('m') > 0)
		glIsMobile = true;

	let myUrl = window.location.href;
	if (myUrl.includes("/test/")) {
		glDbName = "novotris_qs";
		glGameLabel = "Novotris Test";
	}
	//http://novotris.bplaced.net/test/home.html?activate=d00dca34-5968-42c9-8735-2ae06d2eea2a
	activationCode = urlParams.get('activate');
	if (activationCode != null) {
		glUser.activate(activationCode);
		return;
	}

	activationCode = urlParams.get('reset');
	if (activationCode != null) {
		glUser.getChangePasswordUser(activationCode);
		return;
	}
}

function mainInit() {
	var container = document.getElementById('div-container');

	mainMobileAndTabletCheck();
	mainParseURL();

	glContainerPos.width = 600;
	glContainerPos.height = 750;
	container.style.width = glContainerPos.width + "px";
	container.style.height = glContainerPos.height + "px";

	if (glIsMobile)
		glLevelNeedsScore = glLevelNeedsScoreMobile;
	else
		glLevelNeedsScore = glLevelNeedsScoreDesktop;

	//	let drpLanguage = document.getElementById('drp-language');
	//
	//	if (drpLanguage != null) {
	//		drpLanguage.addEventListener('change', chooseLanguage);
	//
	//		if (glUser.getLanguage() == "en")
	//			drpLanguage.selectedIndex = 1;
	//		else
	//			drpLanguage.selectedIndex = 0;
	//	}
}

function chooseLanguage() {
	glUser.chooseLanguage();
}

function mainSetHomeVisibility() {
	glBtnPlay.hidden = false;
	glBtnRanking.hidden = false;
	glBtnHelp.hidden = false;


	glBtnHome.hidden = true;
	glBtnStart.hidden = true;
	glDivRanking.hidden = true;

	//	glLblLevel.hidden = true;
	//	glTxtLevel.hidden = true;
	glLblRows.hidden = true;
	glTxtRows.hidden = true;
	glTxtSpeed.hidden = true;
	glLblSpeed.hidden = true;
	glTxtScore.hidden = true;
	glLblScore.hidden = true;
	glTxtHighscore.hidden = true;;
	glLblHighscore.hidden = true;

	glTxtReset.hidden = true;
	glBtnDialogOk.hidden = true;
	glBtnDialogCancel.hidden = true;

	glTxtTopic.hidden = true;

	glBtnDialogCancel.onclick = function () { classDialog.dialog_cancel(); };

	glBtnRnkShowAll.hidden = true;
	glBtnRnkShowOne.hidden = true;

	glLblName.hidden = false;

	glMainFooter.hidden = false;
	setStatus(cStatusHome);
}

function mainShowHome() {
	var xPos;
	var yPos;
	var metrics;

	clearInterval(glIntervalId);

	glLblName.innerHTML = glGameLabel;
	glLblName.style.fontSize = fontSize1 + "px";
	glContext.font = fontSize1 + "px Verdana";

	metrics = glContext.measureText(glLblName.innerHTML);
	xPos = (glCanvasSize.left + (glCanvasSize.width - metrics.width) / 2);

	if (glIsMobile)
		yPos = 45;
	else
		yPos = 60;

	glLblName.style.left = xPos + "px";
	glLblName.style.top = yPos + "px";


	mainSetHomeVisibility();
	v_status = cStatusHome;
}

function mainLogToDb(aktion, params) {
	glLogOrder += 1;

	jQuery.ajax({
		type: "POST",
		url: '../php/db.php',
		data: { db_name: glDbName, functionname: 'logToDb', nov_release: glRelease, aktion: aktion, params: params, log_order: glLogOrder },
		success: function () {
		}
	});
}

function mainLogToFile(aktion, params) {
	var logMessage = aktion + " " + params

	jQuery.ajax({
		type: "POST",
		url: '../php/logging.php',
		data: { functionname: 'myLog', arguments: logMessage },
		success: function () {
		}
	});
}

function mainLog(aktion, params) {
	mainLogToDb(aktion, params);
}
