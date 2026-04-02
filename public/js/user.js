/**
 * 
 */

class User {
	constructor() {

	}

	init(forceCreate) {
		let storedUserUnparsed = window.localStorage.getItem(glUserKey);
		let storedUser = JSON.parse(storedUserUnparsed);

		if (storedUser === null) {
			this.name = "";
			if (forceCreate) {
				this.id = -1; // enforces creation of a new user
				this.gast_id = null;
				this.#loadFromDb(forceCreate);
			}
		}
		else {
			this.gast_id = storedUser.gast_id;
			this.id = storedUser.id;
			this.name = storedUser.name;
			this.level = storedUser.level;
			this.maxlevel = storedUser.maxlevel;
			this.highscores = storedUser.highscores;
			this.language = storedUser.language;
			this.#loadFromDb(false);

			if (typeof this.language === 'undefined')
				this.language = "de";
		}

		mainUpdateFooter();
	}

	isCreated() {
		return (this.id != -1);
	}

	create() {
		if (this.isCreated())
			return;

		this.uuid = create_UUID();
		//	this.id = 0;
		window.localStorage.setItem(glUserUuidKey, this.uuid);
		this.#loadFromDb(false);
	}

	getId() {
		return this.id;
	}

	getName() {
		return this.name;
	}

	getUuid() {
		return this.uuid;
	}

	getGastId() {
		return this.gast_id;
	}


	changeName(newName) {
		this.tmpName = newName;

		//		if (this.tmpName == "user") {
		//			classDialog.showPrefDialog("invalid");
		//			return;
		//		}


		jQuery.ajax({
			type: "POST",
			url: '../php/db.php',
			data: { db_name: glDbName, functionname: 'saveUserNameToDb', id: this.id, name: this.tmpName },
			success: function (result) {
				glUser.saveUserNameToDbSuccess(result);
			}
		});
	}

	saveUserNameToDbSuccess(result) {
		console.log("saveUserNameToDbSuccess");

		if (result == "Y") {
			this.name = this.tmpName;
			mainUpdateFooter();
		}
		else
			//			classDialog.showPrefDialog("invalid");
			classDialog.showChangeUserNameDialog("invalid");

		this.tmpName = null;
	}

	setHighscore(level, score) {
		this.highscores[glUser.getMode() - 1][level - 1] = score;
	}

	getHighscore(level) {
		return this.highscores[glUser.getMode() - 1][level - 1];
	}

	getModeHighscore(mode, level) {
		return this.highscores[mode - 1][level - 1];
	}

	setLevel(level) {
		this.level = level;
		let userDataLocal = JSON.stringify(this);
		window.localStorage.setItem(glUserKey, userDataLocal);

		jQuery.ajax({
			type: "POST",
			url: '../php/db.php',
			data: { db_name: glDbName, functionname: 'saveLevelToDb', user_id: this.id, level: this.level },
		});
	}

	increaseLevel() {
		if (this.level < glMaxLevelGlobal)
			this.setLevel(this.level + 1);
	}

	decreaseLevel() {
		if (this.level > 1)
			this.setLevel(this.level - 1);
	}

	getLevel() {
		return this.level;
	}

	setMaxLevel(level) {
		this.maxlevel = level;
	}

	getMaxLevel() {
		return this.maxlevel;
	}

	setMode(mode) {
		this.mode = mode;
	}

	getMode() {
		let mode = this.mode;
		if (typeof mode === 'undefined' || mode == 'undefined' || mode === null)
			this.mode = glModeClassic;

		return this.mode;
	}

	#loadFromDb(forceCreate) {
		var mobile;

		if (glIsMobile)
			mobile = "Y";
		else
			mobile = "N";

		if (typeof this.id === 'undefined')
			return;

		jQuery.ajax({
			type: "POST",
			url: '../php/db.php',
			data: { db_name: glDbName, functionname: 'getUserFromDb', id: this.id, mobile: mobile },
			success: function (result) {
				glUser.loadFromDbSuccess(result, forceCreate);
			},
			error: function (xhr, status, error) {
				console.error('loadFromDb error:', status, error, xhr.responseText);
			}
		});
	}

	sendSysLoadMail(mailContent) {
		jQuery.ajax({
			type: "POST",
			url: '../php/mail.php',
			data: {
				functionname: 'sendSysLoadMail', mail_content: mailContent
			},
			success: function (result) {
				glUser.sendSysLoadMailSuccess(result);
			}
		});
	}

	sendSysLoadMailSuccess(result) {
		console.log("sendSysLoadMailSuccess, result = " + result);
	}



	loadFromDbSuccess(result, forceCreate) {
		//	let userDataDb = JSON.parse(result);
		let userDataDb = result;

		this.id = userDataDb.user_id;
		this.name = userDataDb.user_name;
		this.highscores = userDataDb.user_scores;
		this.level = 1;
		this.language = userDataDb.user_language;

		let userDataLocal = JSON.stringify(this);
		window.localStorage.setItem(glUserKey, userDataLocal);

		this.calculateMaxLevel();

		mainUpdateFooter();

		if (this.tmpName == "logout") {
			this.tmpName = "none";

			classDialog.showMessageDialog(getText("logout_successful_header"), getText("logout_successful_text", this.name));
		} else if (glUser.getId() > 0 && forceCreate) {
			novInit();
			// 14.02.2026
			// initStaticRendering();
			choose_level();
		}

	}

	sendActivationMail(to, activationCode) {
		var language = this.getLanguage()

		jQuery.ajax({
			type: "POST",
			url: '../php/mail.php',
			data: {
				functionname: 'sendActivationMail', to: to, activation_code: activationCode, user_name: this.tmpName, user_language: language
			},
			success: function (result) {
				glUser.sendActivationMailSuccess(result);
			}
		});
	}

	sendActivationMailSuccess(result) {
		console.log("sendActivationMailSuccess, result = " + result);
	}

	sendResetPasswordMail(to, activationCode, userName) {
		jQuery.ajax({
			type: "POST",
			url: '../php/mail.php',
			data: {
				functionname: 'sendResetPasswordMail', to: to, activation_code: activationCode, user_name: userName
			},
			success: function (result) {
				glUser.sendResetPasswordMailSuccess(result);
			}
		});
	}

	sendResetPasswordMailSuccess(result) {
		console.log("Success, result = " + result);
	}

	register() {
		let mobile;
		let activationCode = create_UUID();
		let oldUserId = -1;

		if (glIsMobile)
			mobile = "Y";
		else
			mobile = "N";

		this.tmpName = glInputRegistrationUserName.value;

		if (document.getElementById('chk-inherit').checked)
			oldUserId = glUser.id;

		jQuery.ajax({
			type: "POST",
			url: '../php/db.php',
			data: {
				db_name: glDbName, functionname: 'createUserOnDb', user_name: this.tmpName,
				user_email: glInputRegistrationEmail.value, user_password: glInputRegistrationPassword.value, mobile: mobile,
				activation_code: activationCode, old_user_id: oldUserId
			},
			success: function (result) {
				glUser.registerSuccess(result, glInputRegistrationEmail.value, activationCode);
			}
		});

	}

	registerSuccess(result, email, activationCode) {
		console.log("result: " + result);
		let userData = JSON.parse(result);
		let userId = userData.user_id;

		if (userId == 0) {
			document.getElementById('lbl_registration_error_message').innerHTML = getText("registration_invalid");
		}
		else {
			glUser.sendActivationMail(email, activationCode);
			classDialogModus = "registration";
			classDialog.showMessageDialog(getText("registration_header"), getText("registration_text"));
		}
	}

	resetPassword() {
		let activationCode = create_UUID();
		let mobile;

		if (glIsMobile)
			mobile = "Y";
		else
			mobile = "N";

		jQuery.ajax({
			type: "POST",
			url: '../php/db.php',
			data: {
				db_name: glDbName, functionname: 'resetPassword', user_name: glInputRegistrationUserName.value,
				user_email: glInputRegistrationEmail.value, mobile: mobile, activation_code: activationCode
			},
			success: function (result) {
				glUser.resetPasswordSuccess(result, glInputRegistrationEmail.value, glInputRegistrationUserName.value, activationCode);
			}
		});
	}

	resetPasswordSuccess(result, email, userName, activationCode) {
		//	let userData = JSON.parse(result);
		let userData = result;
		let userId = userData.user_id;

		if (userId == -1) {
			document.getElementById('lbl_registration_error_message').innerHTML = getText("really");
		}
		else {
			glUser.sendResetPasswordMail(email, activationCode, userName);
			classDialog.showMessageDialog(getText("reset_password_header"), getText("reset_password_text"));
		}
	}

	//	updatePasswort() {
	//		console.log ("updatePasswort");
	//		let errorMessage = classDialog.validatePassword();
	//		let urlParams = new URLSearchParams(window.location.search);
	//		let activationCode = urlParams.get('changepassword');
	//
	//		if (errorMessage != null) {
	//			document.getElementById('lbl_registration_error_message').innerHTML = errorMessage;
	//			return;
	//		}
	//
	//		jQuery.ajax({
	//			type: "POST",
	//			url: '../php/db.php',
	//			data: {
	//				db_name: glDbName, functionname: 'updatePassword', activation_code: activationCode, user_password: glInputRegistrationPassword.value
	//			},
	//			success: function(result) {
	//				glUser.updatePasswordSuccess(result);
	//			}
	//		});
	//	}

	async updatePasswort() {
		console.log("updatePasswort");
		let errorMessage = classDialog.validatePassword();
		let urlParams = new URLSearchParams(window.location.search);
		let activationCode = urlParams.get('changepassword');
		let msg;

		if (errorMessage != null) {
			document.getElementById('lbl_registration_error_message').innerHTML = errorMessage;
			return;
		}

		try {
			const response = await fetch('../php/db.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ db_name: glDbName, functionname: 'updatePassword', activation_code: activationCode, user_password: glInputRegistrationPassword.value })
			});

			if (!response.ok) {
				throw new Error('HTTP-Fehler: ${response.status}');
			}

			const result = await response.text();
			console.log("updatePasswort, result = " + result);

			if (result == "ok")
				msg = getText("changed_password");
			else
				msg = "internal error";

			document.getElementById('lbl_registration_error_message').innerHTML = msg;
		}
		catch (error) {
			console.error("Netzwerk- oder Parsing-Fehler:", error);
		}
	}

	//		updatePasswordSuccess(result) {
	//			console.log("updatePasswordSuccess, result = " + result);
	//			let msg;
	//
	//			if (result == "ok")
	//				msg = getText("changed_password");
	//			else
	//				msg = "internal error";
	//
	//			document.getElementById('lbl_registration_error_message').innerHTML = msg;
	//		}

	getChangePasswordUser(activationCode) {
		jQuery.ajax({
			type: "POST",
			url: '../php/db.php',
			data: {
				db_name: glDbName, functionname: 'getChangePasswordUser', activation_code: activationCode
			},
			success: function (result) {
				glUser.getChangePasswordUserSuccess(result, activationCode);
			}
		});
	}

	getChangePasswordUserSuccess(result, activationCode) {
		//	let userData = JSON.parse(result);
		let userData = result;
		let userId = userData.user_id;

		if (userId > 0) {
			glUser.id = userId;
			window.location.href = 'change-password.html?changepassword=' + activationCode;
		}
	}

	login(userName) {
		var mobile;

		if (glIsMobile)
			mobile = "Y";
		else
			mobile = "N";

		jQuery.ajax({
			type: "POST",
			url: '../php/db.php',
			data: {
				db_name: glDbName, functionname: 'login', user_name: glInputLoginUserName.value,
				password: glInputLoginPassword.value, mobile: mobile
			},
			success: function (result) {
				glUser.loginSuccess(result);
			}
		});
	}

	loginSuccess(result) {
		//		let userData = JSON.parse(result);
		let userData = result;

		if (userData.user_id < 1) {
			document.getElementById('lbl_login_error_message').innerHTML = getText("login_failed");
			return;
		}

		//	this.uuid = null;
		this.gast_id = this.id;
		this.id = userData.user_id;
		this.name = userData.user_name;
		//TODO
		this.highscores = userData.user_scores;
		this.level = 1;
		this.language = userData.user_language;

		this.calculateMaxLevel();


		let userDataLocal = JSON.stringify(this);
		window.localStorage.setItem(glUserKey, userDataLocal);


		mainUpdateFooter();
		classDialog.showMessageDialog(getText("login_successful_header"), getText("login_successful_text", this.name));
	}

	logout() {
		this.id = this.gast_id;
		this.gast_id = null;
		this.tmpName = "logout";
		this.#loadFromDb(false);
	}

	loginLogout(source) {
		if (glUser.getGastId() != null)
			glUser.logout();
		else {
			let tmp = '{"source": "' + source + '"}';
			window.localStorage.setItem(glGeneralKey, tmp);
			if (source == "play.php")
				do_stop();
			window.location.href = 'login.html';
		}
	}

	calculateMaxLevel() {
		var maxLevel = 1;
		const mode = glUser.getMode();
		let levelNeedsScore;

		if (mode == 1)
			levelNeedsScore = glLevelNeedsScoreModeClassic;
		else
			levelNeedsScore = glLevelNeedsScoreModeSpeed;

		for (var i = 1; i <= glMaxLevelGlobal; ++i) {
			if (this.getModeHighscore(mode, i) >= levelNeedsScore)
				++maxLevel;
			else
				i = glMaxLevelGlobal + 1; // exit loop
		}
		this.setMaxLevel(maxLevel);
	}

	activate(activationCode) {
		jQuery.ajax({
			type: "POST",
			url: '../php/db.php',
			data: {
				db_name: glDbName, functionname: 'activate', activation_code: activationCode
			},
			success: function (result) {
				glUser.activateSuccess(result);
			}
		});
	}

	activateSuccess(result) {
		console.log("activateSuccess, result = " + result);
		if (result == 0) {
			classDialogModus = "login";
			classDialog.showMessageDialog("Aktivierung", "Die Aktivierung ist fehlgeschlagen.");
		}
		else {
			classDialogModus = "registration";
			classDialog.showMessageDialog("Aktivierung", "Die Aktivierung war erfolgreich.");
		}
	}

	getLanguage() {
		let lang = this.language;
		if (typeof lang === 'undefined' || lang == 'undefined' || lang === null)
			this.language = "de";

		return this.language;
	}

	async setLanguage(lang) {
		let oldLang = this.getLanguage();

		if (oldLang != lang) {
			this.language = lang;
			let userDataLocal = JSON.stringify(this);
			window.localStorage.setItem(glUserKey, userDataLocal);

			const response = await fetch('../php/db.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ db_name: glDbName, functionname: 'saveLanguageToDb', user_id: this.id, language: this.language })
			});

			if (!response.ok) {
				throw new Error('HTTP-Fehler: ${response.status}');
			}

			const result = await response.text();
			console.log("setLanguage, result = " + result);

			if (result == "ok") {
				let url = window.location.href;

				url = url.replace("/" + oldLang + "/", "/" + lang + "/");
				window.location.href = url;
			}

			//			jQuery.ajax({
			//				type: "POST",
			//				url: '../php/db.php',
			//				data: { db_name: glDbName, functionname: 'saveLanguageToDb', user_id: this.id, language: this.language },
			//				success: function(result) {
			//					glUser.setLanguageSuccess(result, oldLang, lang);
			//				}
			//			});

		}
	}

	//	setLanguageSuccess(result, oldLang, newLang) {
	//		let url = window.location.href;
	//
	//		url = url.replace("/" + oldLang + "/", "/" + newLang + "/");
	//		window.location.href = url;
	//	}

	chooseLanguage() {
		let drpLanguage = document.getElementById('drp-language');
		let lang;

		if (drpLanguage.selectedIndex == 0)
			lang = "de";
		else
			lang = "en";

		this.setLanguage(lang);
	}
}

var tmpUser = 17;
