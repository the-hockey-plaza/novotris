/*
 * dialog.js 
 */

const glCnvMessageTop = 200;
const glCnvMessageHeight = 400;
const glCnvMessageLeft = 25;
const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

const glDivMessageDialog = document.getElementById('div-message-dialog');
const glDivCnvMessage = document.getElementById('div-cnv-message');
const glCnvMessage = document.getElementById('cnv-message');
const glCtxMessage = glCnvMessage.getContext("2d");
const glSpanMsgHeader = document.getElementById('span-msg-header');
const glSpanMsgText = document.getElementById('span-msg-text');


var classDialogModus;
var glBezahlText;
var glFormLogin;

var classDialog = {

	showDialog: function (modus, errorMessage) {
		var innerText = document.querySelector("[name='bezahltext']");
		var height = glResetPos.height;
		var glCtxMessage;

		setDialogOpen(true);
		// glDivMessageDialog.style = 

		glCtxMessage = glCnvMessage.getContext("2d");
		glCtxMessage.canvas.width = glCanvasSize.width;
		glCtxMessage.canvas.height = glCanvasSize.height;


		glCtxMessage.clearRect(0, 0, glCanvasSize.width, glCanvasSize.height);
		glCtxMessage.globalAlpha = 0.5;
		glCtxMessage.fillStyle = "#faeddd";
		glCtxMessage.fillRect(0, 0, glCanvasSize.width, glCanvasSize.height);

		glCtxMessage.globalAlpha = 0.8;
		glCtxMessage.fillStyle = "yellow";
		glCtxMessage.fillRect(glCnvMessageLeft, glCnvMessageTop, glCanvasSize.width - 2 * glCnvMessageLeft, glCnvMessageHeight);

		glCtxMessage.strokeStyle = glMediumGreyColor;
		glCtxMessage.lineWidth = 2;
		glCtxMessage.strokeRect(glCnvMessageLeft + 1, glCnvMessageTop + 1, glCanvasSize.width - 2 * glCnvMessageLeft - 2, glCnvMessageHeight - 2);


		if (classDialogModus == "reset") {
			glBtnDialogCancel.hidden = false;
			glTxtReset.style.fontSize = "20px";
			glBtnDialogOk.style.left = (glResetPos.left + (glResetPos.width / 2) + 10) + "px";
			glBtnDialogCancel.style.left = (glResetPos.left + (glResetPos.width / 2) - 110) + "px";
			glBtnDialogCancel.style.top = glBtnDialogOk.style.top;
			innerText.innerHTML = "Alle Highscores werden auf 0 gesetzt.";

			glTxtReset.hidden = false;
			glBtnDialogOk.hidden = false;
			glCnvMessage.hidden = false;
		}
		else if (classDialogModus == "finished") {
			glTxtReset.style.fontSize = "28px";
			glBtnDialogOk.style.left = (glResetPos.left + (glResetPos.width - 100) / 2) + "px";
			glBtnDialogOk.style.top = glResetPos.top + height - 60 + "px";
			glTxtReset.style.textAlign = "center";
			innerText.innerHTML = "<br>Game Over!";

			glTxtReset.hidden = false;
			glBtnDialogOk.hidden = false;
			glCnvMessage.hidden = false;
		} else if (classDialogModus == "pref") {
			glBtnDialogCancel.hidden = false;
			glTxtReset.style.fontSize = "20px";
			glBtnDialogOk.style.left = (glResetPos.left + (glResetPos.width / 2) + 10) + "px";
			glBtnDialogCancel.style.left = (glResetPos.left + (glResetPos.width / 2) - 110) + "px";
			glBtnDialogOk.style.top = glResetPos.top + height - 40 + "px";
			glBtnDialogCancel.style.top = glBtnDialogOk.style.top;

			if (modus == "invalid") {
				innerText.innerHTML = "Der Name ist ung&uuml;ltig oder bereits vergeben. Bitte w&auml;hle einen anderen Namen:";
				glTxtReset.style.fontSize = "16px";
				glCnvMessage.hidden = false;
			}
			else
				innerText.innerHTML = "Neuer Username f&uuml;r dieses Ger&auml;t (Buchstaben, Ziffern und Minus-Zeichen):";

			glInputUserName.value = glUser.getName();
			glFormPref.hidden = false;

			glTxtReset.hidden = false;
			glBtnDialogOk.hidden = false;
			glCnvMessage.hidden = false;
		} else if (classDialogModus == "newcomer") {
			glTxtReset.style.fontSize = "16px";
			glTxtReset.style.textAlign = "left";
			glBtnDialogOk.style.left = (glResetPos.left + (glResetPos.width - 100) / 2) + "px";
			height = glResetPos.height + 100;
			glBtnDialogOk.style.top = glResetPos.top + height - 60 + "px";
			innerText.innerHTML = "Ok, du bist offensichtlich neu hier! Am besten, du startest gleich mal ein" +
				" Spielchen mit der klassichen Tetris-Variante, alles andere ergibt sich dann irgendwie. &Uuml;ber den " +
				" Button mit dem Haussymbol kommst du immer irgendwo hin, wo du dich umschauen und orientieren kannst." +
				" Viel Spa&szlig; beim Spielen!";

			glTxtReset.hidden = false;
			glBtnDialogOk.hidden = false;
			glCnvMessage.hidden = false;
		} else if (classDialogModus == "registration") {
			glCnvMessage.hidden = false;
			glFormLogin.hidden = true;
			glFormRegistration.hidden = false;
			glInputRegistrationUserName.value = "";
			glInputRegistrationEmail.value = "";
			glInputRegistrationPassword.value = "";
			glInputRegistrationPasswordRepeat.value = "";

			document.getElementById('btn_registration_ok').disabled = true;

			if (modus == "invalid") {
				document.getElementById('lbl_registration_error_message').innerHTML = errorMessage;
			}
			else
				document.getElementById('lbl_registration_error_message').innerHTML = null;
		} else if (classDialogModus == "login") {
			glCnvMessage.hidden = false;
			glFormLogin.hidden = false;
			glInputLoginUserName.value = "";
			glInputLoginPassword.value = "";

			document.getElementById('btn_login_ok').disabled = true;

			if (modus == "invalid") {
				document.getElementById('lbl_login_error_message').innerHTML = errorMessage;
			}
			else
				document.getElementById('lbl_login_error_message').innerHTML = null;
		}

		else if (classDialogModus == "changeusername") {
			glCnvMessage.hidden = false;
			glFormChangeUserName.hidden = false;
			glInputChangeUserName.value = "";

			document.getElementById('btn_login_ok').disabled = true;

			if (modus == "invalid") {
				document.getElementById('lbl_change_user_name_error_message').innerHTML = "Der Name ist ung&uuml;ltig oder bereits vergeben.";
			}
			else
				document.getElementById('lbl_change_user_name_error_message').innerHTML = null;
		}


	},

	showResetDialog: function () {
		classDialogModus = "reset";
		classDialog.showDialog();
	},


	showPrefDialog: function (modus) {
		classDialogModus = "pref";
		classDialog.showDialog(modus);
	},

	showRegistrationDialog: function (modus, errorMessage) {
		classDialogModus = "registration";

		const glCnvMessageTop = 200;
		const glCnvMessageHeight = 350;
		const glCnvMessageLeft = 25;


		glFormRegistration.style.width = glCanvasSize.width - 100 + "px";
		glFormRegistration.style.height = glCnvMessageHeight - 50 + "px";
		glFormRegistration.style.left = glCanvasSize.left + glCnvMessageLeft + 25 + "px";
		glFormRegistration.style.top = glCnvMessageTop + 25 + "px";

		classDialog.showDialog(modus, errorMessage);
	},

	showChangeUserNameDialog: function (modus, errorMessage) {
		classDialogModus = "changeusername";


		//TODO globale Konstanten
		const glCnvMessageTop = 200;
		const glCnvMessageHeight = 350;
		const glCnvMessageLeft = 25;


		glFormChangeUserName.style.width = glCanvasSize.width - 100 + "px";
		glFormChangeUserName.style.height = glCnvMessageHeight - 50 + "px";
		glFormChangeUserName.style.left = glCanvasSize.left + glCnvMessageLeft + 25 + "px";
		glFormChangeUserName.style.top = glCnvMessageTop + 25 + "px";

		classDialog.showDialog(modus, errorMessage);
	},

	showMessageDialog: function (msgHeader, msgText) {
		//TODO globale Konstanten
		const glCnvMessageTop = 0;
		const glCnvMessageHeight = 300;
		const glCnvMessageLeft = 0;

		setDialogOpen(true);
		//	var glCtxMessage;

		//		glCtxMessage = glCnvMessage.getContext("2d");
		//		glCtxMessage.canvas.width = glCanvasSize.width;
		//		glCtxMessage.canvas.height = glCanvasSize.height;
		//

		glDivCnvMessage.style.width = glDivMessageDialog.style.width;
		glDivCnvMessage.style.height = glDivMessageDialog.style.height;
		glDivCnvMessage.style.left = glDivMessageDialog.style.left;
		glDivCnvMessage.style.top = glDivMessageDialog.style.top;



		glCnvMessage.hidden = false;
		glDivMessageDialog.style.display = "flex";
		glDivCnvMessage.hidden = false;

		//classDialogModus = "message";

		glSpanMsgHeader.innerHTML = msgHeader;
		glSpanMsgText.innerHTML = msgText;

		//		glDivMessageDialog.style.width = glCanvasSize.width - 150 + "px";
		//		glDivMessageDialog.style.height = glCnvMessageHeight - 50 + "px";
		//		glDivMessageDialog.style.left = glCanvasSize.left + glCnvMessageLeft + 25 + "px";
		//		glDivMessageDialog.style.top = glCnvMessageTop + 25 + "px";

		//		glDivMessageDialog.style.width = glContainerPos.width - 140 + "px";
		//		glDivMessageDialog.style.height = "300px";
		//		glDivMessageDialog.style.left = (window.outerWidth - glContainerPos.width) / 2 + 70 + "px";
		//		glDivMessageDialog.style.top = "200px";
		//
		glCtxMessage.clearRect(0, 0, glCtxMessage.canvas.width, glCtxMessage.canvas.height);
		glCtxMessage.globalAlpha = 0.5;
		glCtxMessage.fillStyle = glDialogBackColor; // "glLightBackColor;
		glCtxMessage.fillRect(0, 0, glCtxMessage.canvas.width, glCtxMessage.canvas.height);

		glCtxMessage.globalAlpha = 0.8;
		glCtxMessage.fillStyle = glDialogBackColor;
		glCtxMessage.fillRect(glCnvMessageLeft, glCnvMessageTop, glCtxMessage.canvas.width - 2 * glCnvMessageLeft, glCnvMessageHeight);

		glCtxMessage.strokeStyle = glMediumGreyColor;
		glCtxMessage.lineWidth = 2;
		glCtxMessage.strokeRect(glCnvMessageLeft + 1, glCnvMessageTop + 1, glCtxMessage.canvas.width - 2 * glCnvMessageLeft - 2, glCnvMessageHeight - 2);

		document.addEventListener("keypress", function (event) {
			// If the user presses the "Enter" key on the keyboard
			if (event.key === "Enter") {
				// Cancel the default action, if needed
				event.preventDefault();
				// Trigger the button element with a click
				document.getElementById("btn_msg_ok").click();
			}
		});
	},

	showLevelDialog: function () {
		let maxLevelModeClassic = 1;
		let maxLevelModeSpeed = 1;
		let msg;

		// mode classic:
		for (i = 0; i < glMaxLevelGlobal; ++i) {
			if (glUser.getModeHighscore(1, i) >= glLevelNeedsScoreModeClassic)
				++maxLevelModeClassic;
		}
		msg = '<b>' + getText("level_info_mode") + ' "classic"</b><br>' + getText("level_info_text", glLevelNeedsScoreModeClassic, maxLevelModeClassic);

		// mode speed:
		for (i = 0; i < glMaxLevelGlobal; ++i) {
			if (glUser.getModeHighscore(2, i) >= glLevelNeedsScoreModeSpeed)
				++maxLevelModeSpeed;
		}
		msg += '<br><br><b>' + getText("level_info_mode") + ' "speed"</b><br>' + getText("level_info_text", glLevelNeedsScoreModeSpeed, maxLevelModeSpeed);

		classDialog.showMessageDialog(getText("level_info_title"), msg);
	},

	showNewcomerDialog: function () {
		classDialogModus = "newcomer";
		classDialog.showDialog();
	},

	setBezahlText: function (txt) {
		glBezahlText = txt;
	},

	msgDialogOk: function () {
		glCnvMessage.hidden = true;
		glDivMessageDialog.style.display = "none";
		glDivCnvMessage.hidden = true;
		setDialogOpen(false);

		if (classDialogModus == "finished") {
			choose_level();
		} else if (classDialogModus == "login") {
			var lang = glUser.language;

			window.location.href = '../' + lang + '/play.php';
		} else if (classDialogModus == "registration") {
			window.location.href = 'login.html';
		}
	},

	dialog_ok: function () {
		let errorMessage;

		if (classDialogModus == "finished") {
			glCnvMessage.hidden = true;
			setDialogOpen(false);
			choose_level();
		}

		else if (classDialogModus == "pref") {
			glCnvMessage.hidden = true;
			setDialogOpen(false);
			glUser.changeName(glInputUserName.value);

			glFormPref.hidden = true;
			mainShowHome();
		}
		else if (classDialogModus == "newcomer") {
			glCnvMessage.hidden = true;
			setDialogOpen(false);
			prvPlay();
		}
		else if (classDialogModus == "registration") {
			errorMessage = classDialog.validateRegistration();

			if (errorMessage === null) {
				glCnvMessage.hidden = true;
				setDialogOpen(false);
				glUser.register();
				glFormRegistration.hidden = true;
				mainShowHome();
			}
			else
				document.getElementById('lbl_registration_error_message').innerHTML = errorMessage;
		}
		//		else if (classDialogModus == "changepassword") {
		//			errorMessage = classDialog.validatePassword();
		//
		//			if (errorMessage === null) {
		//				glCnvMessage.hidden = true;
		//				glUser.updatePassword();
		//			}
		//			else
		//				document.getElementById('lbl_registration_error_message').innerHTML = errorMessage;
		//		}
		else if (classDialogModus == "login") {
			glCnvMessage.hidden = true;
			setDialogOpen(false);
			glUser.login();
			glFormLogin.hidden = true;
			mainShowHome();
		}
		else if (classDialogModus == "changeusername") {
			glCnvMessage.hidden = true;
			setDialogOpen(false);
			glUser.changeName(glInputChangeUserName.value);

			glFormChangeUserName.hidden = true;
			mainShowHome();
		}
	},

	loginOk: function () {
		glUser.login();
	},

	registrationOk: function () {
		let errorMessage = classDialog.validateRegistration();

		//						document.querySelector('chk-privacy').checked;


		if (errorMessage === null) {
			//	glCnvMessage.hidden = true;
			glUser.register();
			//	glFormRegistration.hidden = true;
			//		mainShowHome();
		}
		else
			document.getElementById('lbl_registration_error_message').innerHTML = errorMessage;

		//	glUser.login();
		//	mainShowHome();
	},

	validateRegistration: function () {
		let errorMessage;

		errorMessage = classDialog.validateEmail();
		if (errorMessage != null)
			return errorMessage;

		errorMessage = classDialog.validatePassword();
		if (errorMessage != null)
			return errorMessage;

		return null;
	},

	validateEmail: function () {
		var inputText = glInputRegistrationEmail.value;
		if (inputText.match(mailformat))
			return null;

		return "EMail ist ung&uuml;ltig.";
	},

	validatePassword: function () {
		if (glInputRegistrationPassword.value == glInputRegistrationPasswordRepeat.value)
			return null;

		return "Das Passwort und die Wiederholung stimmen nicht &uuml;berein.";
	},

	dialog_cancel: function () {
		glCnvMessage.hidden = true;
		setDialogOpen(false);

		if (classDialogModus == "reset" || classDialogModus == "pref") {
			mainShowHome();
		}

		if (classDialogModus == "pref") {
			glFormPref.hidden = true;
			mainShowHome();
		} else if (classDialogModus == "registration") {
			glCnvMessage.hidden = true;
			glFormRegistration.hidden = true;
			mainShowHome();
		} else if (classDialogModus == "login") {
			glCnvMessage.hidden = true;
			glFormLogin.hidden = true;
			mainShowHome();
		} else if (classDialogModus == "changeusername") {
			glCnvMessage.hidden = true;
			glFormChangeUserName.hidden = true;
			mainShowHome();
		}
	},

	checkRegistration: function () {
		console.log("checkRegistration");
		if (glInputRegistrationUserName.value === "" ||
			glInputRegistrationEmail.value === "" ||
			glInputRegistrationPassword.value === "" ||
			glInputRegistrationPasswordRepeat.value === "" ||
			!document.getElementById('chk-privacy').checked) {
			document.getElementById('btn_registration_ok').disabled = true;
		} else {
			document.getElementById('btn_registration_ok').disabled = false;
		}
	},

	checkResetPassword: function () {
		if (glInputRegistrationPassword.value === "" ||
			glInputRegistrationEmail.value === "") {
			document.getElementById('btn_reset_password').disabled = true;
		} else {
			document.getElementById('btn_reset_password').disabled = false;
		}
	},

	checkChangePassword: function () {
		if (glInputRegistrationPassword.value === "" ||
			glInputRegistrationPasswordRepeat.value === "") {
			document.getElementById('btn_reset_password').disabled = true;
		} else {
			document.getElementById('btn_reset_password').disabled = false;
		}
	},



	keyUp: function () {
		if (classDialogModus == "registration") {
			classDialog.checkRegistration();
		}
		else if (classDialogModus == "change-password") {
			classDialog.checkChangePassword();
		} else if (classDialogModus == "reset-password") {
			classDialog.checkResetPassword();
		} else if (classDialogModus == "login") {
			if (glInputLoginUserName.value === "" ||
				glInputLoginPassword.value === "") {
				document.getElementById('btn_login_ok').disabled = true;
			} else {
				document.getElementById('btn_login_ok').disabled = false;
			}
		} else if (classDialogModus == "changeusername") {
			if (glInputChangeUserName.value === "") {
				document.getElementById('btn_change_user_name_ok').disabled = true;
			} else {
				document.getElementById('btn_change_user_name_ok').disabled = false;
			}
		}
	},

	init: function () {
		glFormLogin = document.getElementById('form_login');

	},

	initMessages: function () {
		let width;
		let container = document.getElementById('div-container');
		let containerRect;
		let dialogTop;

		//		let isIframe;
		//		if (window.self !== window.top) {
		//			console.log('Die Seite ist in einem iFrame eingebettet.');
		//			isIframe = true;
		//			width = window.innerWidth;
		//		} else {
		//			console.log('Die Seite ist nicht in einem iFrame eingebettet.');
		//			isIframe = false;
		//			width = window.outerWidth;
		//		}
		//		

		width = window.innerWidth;
		let mid = width / 2;
		let outerWidth;

		if (container != null) {
			containerRect = container.getBoundingClientRect();
			mid = containerRect.left + (containerRect.width / 2);
		}

		if (glIsMobile)
			outerWidth = glContainerPos.width - 100;
		else
			outerWidth = glContainerPos.width - 120;

		if (containerRect != null) {
			if (glIsMobile)
				outerWidth = containerRect.width - 24;
			else
				outerWidth = containerRect.width - 120;
		}

		outerWidth = Math.max(320, Math.floor(outerWidth));
		dialogTop = 200;
		if (containerRect != null) {
			dialogTop = Math.max(200, Math.floor(containerRect.top + 200));
		}

		glDivMessageDialog.style.width = outerWidth + "px";
		glDivMessageDialog.style.height = "300px";
		glDivMessageDialog.style.left = mid - (outerWidth / 2) + "px";
		glDivMessageDialog.style.top = dialogTop + "px";

		//		glDivCnvMessage.style.width = outerWidth + "px";
		//		glDivCnvMessage.style.height = glDivMessageDialog.style.height;
		//		glDivCnvMessage.style.left = mid - (outerWidth / 2)  + "px";
		//		glDivCnvMessage.style.top = glDivMessageDialog.style.top;
		//
		//	glDivCnvMessage.style.width = glDivMessageDialog.style.width;
		//		glDivCnvMessage.style.height = glDivMessageDialog.style.height;
		//		glDivCnvMessage.style.left = glDivMessageDialog.style.left;
		//		glDivCnvMessage.style.top = glDivMessageDialog.style.top;
		//

		glCtxMessage.canvas.width = outerWidth;
		glCtxMessage.canvas.height = 300;

		//	glDialogBackColor = "#60606a"; 
		//glDialogBackColor = "#eaddcd";
		// glLightTextColor = "#eaddcd";


	},

}

