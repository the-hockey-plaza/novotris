/*
 * ranking.js 
 */

const glDivRanking = document.getElementById('div-ranking');
const glDivRankingLoading = document.getElementById('div-ranking-loading');
const glBtnRnkShowAll = document.getElementById('btn-rnk-show-all');
const glBtnRnkShowOne = document.getElementById('btn-rnk-show-one');
const glDrpRnkAuswahl = document.getElementById('drp-rnk-auswahl');
const glDrpRnkLevel = document.getElementById('drp-rnk-level');
const glDrpRnkMode = document.getElementById('drp-rnk-mode');
const glDrpRnkPeriod = document.getElementById('drp-rnk-period');

//const glDarkTextColor = "#404040";
// const glLightTextColor = "#eaddcd";
// const glPlaygroundBackColor = "#404040";



var glRankingShowAll = true;

//https://wiki.selfhtml.org/wiki/HTML/Tutorials/Formulare/Auswahllisten
//
var classRanking = {
	init: function() {
		glDrpRnkAuswahl.addEventListener('change', classRanking.show);
		glDrpRnkLevel.addEventListener('change', classRanking.show);
		glDrpRnkMode.addEventListener('change', classRanking.show);
		glDrpRnkPeriod.addEventListener('change', classRanking.show);

		glDrpRnkAuswahl.selectedIndex = 0;
		glDrpRnkLevel.selectedIndex = 1;
		glDrpRnkPeriod.selectedIndex = 0;
	},

	show: function() {
		classRanking.readHighscoreFromDb();
		glDivRanking.scrollTop = 0;
	},

	readHighscoreFromDb: function() {
		var isMobile;
		var userId;
		let auswahl = glDrpRnkAuswahl.selectedIndex;
		let level = glDrpRnkLevel.selectedIndex;
		let mode = glDrpRnkMode.selectedIndex + 1;
		let period = glDrpRnkPeriod.selectedIndex;

		if (glIsMobile)
			isMobile = "Y";
		else
			isMobile = "N";

		if (auswahl == 0)
			userId = 0;
		else
			userId = glUser.getId();

		jQuery.ajax({
			type: "POST",
			url: '../php/db.php',
			data: { db_name: glDbName, functionname: 'readHighscoreFromDb', level: level, mobile: isMobile, user_id: userId, mode: mode, period: period },
			success: function(data) {
				classRanking.showHighscore(data);
			}
		});
	},

	showHighscore: function(values) {
		let rankingTable = document.getElementById("table-body-ranking");
		//		let txtTopic = document.querySelector("[name='topic-text']");
		let rankingHeader = getText("ranking_header");
		let cellColor;
		let cellFontWeight;

		//		if (glUser.getLevel() == 0)
		//			rankingHeader += " gesamt";
		//		else
		//			rankingHeader += " Level " + glUser.getLevel();

		if (glIsMobile)
			rankingHeader += " (mobil)";

		//	txtTopic.innerHTML = rankingHeader;

		var rowCount = rankingTable.rows.length;
		for (var i = 1; i <= rowCount; i++) {
			rankingTable.deleteRow(0);
		}


	//	let data = JSON.parse(values);
		let data = values;
		let countValues = data.length;
		if (countValues > 50)
			countValues = 50;

		for (i = 0; i < countValues; ++i) {
			if (glDrpRnkAuswahl.selectedIndex == 0 && data[i].user_name == glUser.getName()) {
				cellColor = glNovotrisColor;
				cellFontWeight = "bold";
			}
			else {
				cellColor = glPlaygroundBackColor;
				cellFontWeight = "normal";
			}

			let row = rankingTable.insertRow();
			row.className = "class-table-ranking";

			let idx = row.insertCell(0);
			idx.className = "class-table-ranking";
			idx.innerHTML = i + 1;
			idx.style.color = cellColor;
			idx.style.fontWeight = cellFontWeight;

			let username = row.insertCell(1);
			username.className = "class-table-ranking";
			username.innerHTML = data[i].user_name;
			username.style.textAlign = "left";
			username.style.color = cellColor;
			username.style.fontWeight = cellFontWeight;

			let timestamp = row.insertCell(2);
			timestamp.className = "class-table-ranking";
			timestamp.innerHTML = getDateFormatted(data[i].timestamp);
			timestamp.style.textAlign = "center";
			timestamp.style.color = cellColor;
			timestamp.style.fontWeight = cellFontWeight;

			let level = row.insertCell(3);
			level.className = "class-table-ranking";
			level.innerHTML = data[i].level;
			level.style.color = cellColor;
			level.style.fontWeight = cellFontWeight;

			let score = row.insertCell(4);
			score.className = "class-table-ranking";
			score.innerHTML = data[i].score;
			score.style.color = cellColor;
			score.style.fontWeight = cellFontWeight;
		}

		glDivRankingLoading.style.display = "none";
		glDivRanking.style.display = "block";	
	},

	showAll: function() {
		glRankingShowAll = true;
		glBtnRnkShowAll.style.borderStyle = "inset";
		glBtnRnkShowOne.style.borderStyle = "outset";
		classRanking.readHighscoreFromDb();
	},

	showOne: function() {
		glRankingShowAll = false;
		glBtnRnkShowAll.style.borderStyle = "outset";
		glBtnRnkShowOne.style.borderStyle = "inset";
		classRanking.readHighscoreFromDb();
	}
}
