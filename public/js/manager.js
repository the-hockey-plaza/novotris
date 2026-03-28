/**
 * manager.js
 */

const Http = new XMLHttpRequest();
const url = 'http://ipinfo.io/66.249.70.123';


function updateIps() {
	console.log("updateIps");

	Http.open("GET", url);
	Http.send();
	


	//	jQuery.ajax({
	//		type: "POST",
	//		url: 'db.php',
	//		data: { db_name: 'novotris_work', functionname: 'updateIps' },
	//		success: function(result) {
	//			updateIpsSuccess(result);
	//		}
	//	});

}



Http.onreadystatechange = (e) => {
	console.log("onreadystatechange");
	console.log(Http.responseText)
}



function updateIpsSuccess(result) {
	console.log("updateIpsSuccess");
	console.log(result);
}

