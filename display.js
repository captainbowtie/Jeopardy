setInterval(updateDisplay, 500);
setInterval(updateScores, 500);

var gameState;

var timerStarted = false;
var time1 = null;
var time2 = null;
var time3 = null;
var time4 = null;
var time5 = null;


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
				getQuestion().then((questionHTML) => $("#display").html(questionHTML));
				if (state.buzz == 0 && !timerStarted) {
					startTimer();
				} else if (state.buzz > 0 && timerStarted) {
					stopTimer();
					handleBuzz(state.buzz);
				}
				break;
			default:
				console.log(state);
				break;
		}
	});

}

function startTimer() {
	timerStarted = true;
	time5 = setTimeout(five, 1000);
	time4 = setTimeout(four, 2000);
	time3 = setTimeout(three, 3000);
	time2 = setTimeout(two, 4000);
	time1 = setTimeout(one, 5000);
	$(".five").css("color", "white");
	$(".five").css("background-color", "white");
	$(".four").css("color", "white");
	$(".four").css("background-color", "white");
	$(".three").css("color", "white");
	$(".three").css("background-color", "white");
	$(".two").css("color", "white");
	$(".two").css("background-color", "white");
	$(".one").css("color", "white");
	$(".one").css("background-color", "white");
}

function stopTimer() {
	timerStarted = false;
	$(".five").css("color", "black");
	$(".five").css("background-color", "black");
	$(".four").css("color", "black");
	$(".four").css("background-color", "black");
	$(".three").css("color", "black");
	$(".three").css("background-color", "black");
	$(".two").css("color", "black");
	$(".two").css("background-color", "black");
	$(".one").css("color", "black");
	$(".one").css("background-color", "black");
}

function five() {
	$(".five").css("background-color", "red");
	$(".five").css("color", "red");
}

function four() {
	$(".four").css("background-color", "red");
	$(".four").css("color", "red");
}

function three() {
	$(".three").css("background-color", "red");
	$(".three").css("color", "red");
}

function two() {
	$(".two").css("background-color", "red");
	$(".two").css("color", "red");
}

function one() {
	$(".one").css("background-color", "red");
	$(".one").css("color", "red");
	$.post("api/disableBuzzing.php").then(function () { timerStarted = false; });
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

