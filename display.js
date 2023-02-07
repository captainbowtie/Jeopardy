setInterval(updateDisplay, 500);
setInterval(updateScores, 500);

function getState() {
	return new Promise((resolve, reject) => {
		$.get("api/getState.php", function (state) {
			resolve(state);
		}, "json");
	});
}

function updateDisplay() {
	getState().then(state => {
		switch (state.display) {
			case "board":
				getBoard().then((boardHTML) => $("#display").html(boardHTML));
				break;
			case "question":
				getQuestion().then((questionHTML) => $("#display").html(questionHTML + timerHTML));
			default:
				console.log(state);
				break;
		}
	});

}

function updateScores() {
	getScores().then((scoreHTML) => $("#scores").html(scoreHTML));
}

function getQuestion() {
	return new Promise((resolve, reject) => {
		$.get("question.php", function (questionHTML) {
			resolve(questionHTML);
		}, "html");
	});
}

function getBoard() {
	return new Promise((resolve, reject) => {
		$.get("board.php", function (boardHTML) {
			resolve(boardHTML);
		}, "html");
	});
}

function getScores() {
	return new Promise((resolve, reject) => {
		$.get("scores.php", function (scoreHTML) {
			resolve(scoreHTML);
		}, "html");
	});
}



function getDailyDouble() {
	return new Promise((resolve, reject) => {
		$.get("api/getScores.php", function (doubleHTML) {
			resolve(doubleHTML);
		}, "html");
	});
}

function getFinalJeopardy() {
	return new Promise((resolve, reject) => {
		$.get("api/getScores.php", function (finalHTML) {
			resolve(doubleHMTL);
		}, "html");
	});
}

var timerHTML = '<table><tr><td class="five">-</td><td class="four">-</td><td class="three">-</td><td class="two">-</td><td class="one">-</td> <td class="two">-</td><td class="three">-</td><td class="four">-</td><td class="five">-</td></tr></table>';