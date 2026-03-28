/*
 * global.js
 */

const glRelease = "4.1.1b";
const glSubKey = "2.1"
const glHighscoreKey = "novotris." + glSubKey + ".highscore";
const glMaxLevelKey = "novotris." + glSubKey + ".maxlevel";
const glUserUuidKey = "novotris." + glSubKey + ".uuid";
const glUserKey = "novotris." + glSubKey + ".user";
const glGeneralKey = "novotris." + glSubKey + ".general";

const glMainCanvas = document.getElementById('mainCanvas');

const glPadding = 13;

const glMaxLevelGlobal = 6;

const glModeClassic = 1;
const glModeSpeed = 2;


const glLevelNeedsScoreDesktop = 1000;
const glLevelNeedsScoreMobile = 750;

var glLevelNeedsScore = glLevelNeedsScoreDesktop;
const glLevelNeedsScoreModeClassic = 1000;
const glLevelNeedsScoreModeSpeed = 1500;

const phpDir = "../../../php/";

/* ----------------------------------------------------------------------------
 * color management
 * ----------------------------------------------------------------------------
 */

const cMainFillColor = "#e8e8e8"; // LightBackColor -> done
const cMainLineColor = "#707070"; // MediumGrey -> done
const cSubLineColor = "#a00000"; // -> ???
const cBackgroundColor = "#404040"; // PlaygroundBackColor -> done
const cLabelColor = "#606060";  // MediumGrey -> done
const cPlayBackColor = "#606060"; // MediumGrey -> done
const cSmallFrameColor = "#606060"; // MediumGrey -> done
const cFilterColor = "#e8e8e8"; // LightBackColor -> done

const glNovotrisColor = "#5a89bf"; // characteristic color of Novotris
const glLightTextColor = "#eaddcd"; // almost white for text with background "NovotrisColor"
const glLightBackColor = "#e8e8e8"; // light grey for general backgrounds
const glDarkTextColor = "#404040";// dark grey for text with LightBackColor background
const glPlaygroundBackColor = "#404040"; // background for the playground
const glPlaygroundLineColor = "#808080"; // lines for the playground
const glMediumGreyColor = "#808080"; // several purposes 
const glDialogBackColor = "#eaddcd";


/* ----------------------------------------------------------------------------
 * text management
 * ----------------------------------------------------------------------------
 */

function getText(key, p1, p2, p3, p4) {
	let lang = glUser.getLanguage();

	if (lang === null)
		lang = "en";

	switch (key) {
		case 'msg1':
			switch (lang) {
				case "de":
					return "meldung 1";
				case "en":
					return "message 1";
			}


		case 'score_highscore':
			switch (lang) {
				case "de":
					return "Du hast in diesem Spiel einen Score von <b>" + p1 + "</b> und damit einen neuen Highscore erreicht!";
				case "en":
					return "You have reached a score of <b>" + p1 + "</b> in this game, which is a new high score!";
			}

		case 'score':
			switch (lang) {
				case "de":
					return "Du hast in diesem Spiel einen Score von <b>" + p1 + "</b> erreicht.";
				case "en":
					return "You have reached a score of <b>" + p1 + "</b> in this game.";
			}

		case 'improved_ranking':
			switch (lang) {
				case "de":
					return "Au&szlig;erdem hast du dich in der Rangliste auf Platz <b>" + p1 + "</b> verbessert!";
				case "en":
					return "You also moved up in the rankings to <b>" + p1 + "</b>!";
			}

		case 'changed_password':
			switch (lang) {
				case "de":
					return "Das Passwort wurde ge&auml;ndert.";
				case "en":
					return "The password has been changed.";
			}

		case 'login_failed':
			switch (lang) {
				case "de":
					return "Diese Kombination aus Username und Passwort ist ung&uuml;ltig.";
				case "en":
					return "This username and password combination is invalid.";
			}

		case 'logout_successful_header':
			switch (lang) {
				case "de":
					return "Abmeldung erfolgreich";
				case "en":
					return "Logout successful";
			}

		case 'logout_successful_text':
			switch (lang) {
				case "de":
					return "Du bist von deinem Account abgemeldet und daher wieder mit deinem automatisch angelegten User '" + p1 + "' unterwegs.";
				case "en":
					return "You are logged out of your account and therefore back to your automatically created user '" + p1 + "'.";
			}

		case 'registration_header':
			switch (lang) {
				case "de":
					return "Registrierung";
				case "en":
					return "Registration";
			}

		case 'registration_text':
			switch (lang) {
				case "de":
					return "Du erh&auml;ltst eine Email, mit der du deinen Account aktivieren kannst.";
				case "en":
					return "You will receive an email to activate your account.";
			}

		case 'registration_invalid':
			switch (lang) {
				case "de":
					return "Name oder EMail ist ung&uuml;ltig bzw. bereits vergeben";
				case "en":
					return "Name or EMail is invalid or already assigned";
			}

		case 'really':
			switch (lang) {
				case "de":
					return "Wirklich?";
				case "en":
					return "Really?";
			}

		case 'reset_password_header':
			switch (lang) {
				case "de":
					return "Passwort zur&uuml;cksetzen";
				case "en":
					return "Reset Password";
			}

		case 'reset_password_text':
			switch (lang) {
				case "de":
					return "Du erh&auml;ltst eine Email, mit der du dein Passwort neu setzen kannst.";
				case "en":
					return "You will receive an email with which you can reset your password.";
			}

		case 'login_successful_header':
			switch (lang) {
				case "de":
					return "Anmeldung erfolgreich";
				case "en":
					return "Login successful";
			}

		case 'login_successful_text':
			switch (lang) {
				case "de":
					return "Du bist jetzt angemeldet und spielst als '" + p1 + "' weiter.";
				case "en":
					return "You are now logged in and continue playing as '" + p1 + "'.";
			}

		case 'activation_failed':
			switch (lang) {
				case "de":
					return "Die Aktivierung ist fehlgeschlagen.";
				case "en":
					return "The activation has failed.";
			}

		case 'activation_successful':
			switch (lang) {
				case "de":
					return "Die Aktivierung war erfolgreich.";
				case "en":
					return "The activation was successful.";
			}

		case 'login':
			switch (lang) {
				case "de":
					return "Anmelden";
				case "en":
					return "Login";
			}

		case 'logout':
			switch (lang) {
				case "de":
					return "Abmelden";
				case "en":
					return "Logout";
			}

		case 'ranking_header':
			switch (lang) {
				case "de":
					return "Rangliste";
				case "en":
					return "Ranking";
			}

		case 'play_title_init':
			switch (lang) {
				case "de":
					return "Level und Modus wählen und los geht's...";
				case "en":
					return "Choose level and mode and off you go...";
			}

		case 'play_title_running':
			switch (lang) {
				case "de":
					return "Spiel läuft...";
				case "en":
					return "Game is running...";
			}

		case 'play_title_pause':
			switch (lang) {
				case "de":
					if (p1 > 0)
						return "Pause..." + p1 + " Punkte Abzug";
					else
						return "Pause...";
				case "en":
					if (p1 > 0)
						return "Break..." + p1 + " points deduction";
					else
						return "Break...";
			}

		case 'play_title_score':
			switch (lang) {
				case "de":
					return p1 + " Punkte geschafft!"
				case "en":
					return p1 + " points achieved!"
			}

		case 'play_button_pause':
			switch (lang) {
				case "de":
					return "Weiter";
				case "en":
					return "Continue";
			}

		case 'play_button_running':
			switch (lang) {
				case "de":
					return "Pause";
				case "en":
					return "Break";
			}

		case 'user_name':
			switch (lang) {
				case "de":
					return "Username";
				case "en":
					return "User name";
			}

		case 'first_game':
			switch (lang) {
				case "de":
					return "Erstes Spiel";
				case "en":
					return "First game";
			}

	case 'last_game':
			switch (lang) {
				case "de":
					return "Letztes Spiel";
				case "en":
					return "Last game";
			}

		case 'nr_games':
			switch (lang) {
				case "de":
					return "Anzahl Spiele";
				case "en":
					return "Number of games";
			}

		case 'nr_users':
			switch (lang) {
				case "de":
					return "Anzahl User";
				case "en":
					return "Number of users";
			}

		case 'level_info_title':
			switch (lang) {
				case "de":
					return "Informationen zu den Levels";
				case "en":
					return "Informations about the levels";
			}

		case 'level_info_mode':
			switch (lang) {
				case "de":
					return "Modus";
				case "en":
					return "Mode";
			}

		case 'level_info_text':
			switch (lang) {
				case "de":
					return p1 + " Punkte geben jeweils den nächsten Level frei.<br>Dein höchster Level: <b>" + p2 + "</b>";
				case "en":
					return p1 + " points unlock the next level.<br>Your highest level: <b>" + p2 + "</b>";
			}


	}
}

function getDateFormatted(s) {
	let lang = glUser.getLanguage();

	if (lang === null)
		lang = "en";

	if (lang == "en")
		return s.substr(3, 2) + "/" + s.substr(0, 2) + "/" + s.substr(6, 2);
	else
		return s;
}

