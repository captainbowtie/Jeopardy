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
				$(".player").css("background-color", "tan");
				$(".timerBox").css("color", "black");
				$(".timerBox").css("background-color", "black");
				break;
			case "question":
				getQuestion().then((questionHTML) => $("#display").html(questionHTML));
				if (state.buzz == 0 && !timerStarted) {
					startTimer();
					$(".player").css("background-color", "tan");
				} else if (state.buzz > 0 && timerStarted) {
					stopTimer();
					handleBuzz(state.buzz);
				}
				break;
			case "dailyDouble":
				getDailyDouble().then((dailyDoubleHTML) => $("#display").html(dailyDoubleHTML));
				break;
			case "finalC":
				getFinal().then((finalHTML) => $("#display").html(finalHTML));
				break;
			case "finalQ":
				getFinal().then((finalHTML) => $("#display").html(finalHTML));
				break;
			case "finalA":
				getFinal().then((finalHTML) => $("#display").html(finalHTML));
				if (state.buzz > 0) {
					handleBuzz(state.buzz);
				}
				break;
			default:
				console.log(state);
				break;
		}
	});

}

function handleBuzz(player) {
	$(".player").css("background-color", "tan");
	$(`#player${player}`).css("background-color", "white");
}

function startTimer() {
	timerStarted = true;
	time5 = setTimeout(five, 1000);
	time4 = setTimeout(four, 2000);
	time3 = setTimeout(three, 3000);
	time2 = setTimeout(two, 4000);
	time1 = setTimeout(one, 5000);
	$(".timerBox").css("color", "white");
	$(".timerBox").css("background-color", "white");
}

function stopTimer() {
	timerStarted = false;
	clearTimeout(time1);
	clearTimeout(time2);
	clearTimeout(time3);
	clearTimeout(time4);
	clearTimeout(time5);
	$(".timerBox").css("color", "black");
	$(".timerBox").css("background-color", "black");
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
	getScores().then((scores) => {
		scores.forEach(player => {
			$(`#score${player.id}`).html(player.score);
		})
	});
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
		$.get("api/getScores.php", function (scores) {
			resolve(scores);
		}, "json");
	});
}



function getDailyDouble() {
	return new Promise((resolve, reject) => {
		$.get("dailyDouble.php", function (dailyDoubleHTML) {
			resolve(dailyDoubleHTML);
		}, "html");
	});
}

function getFinal() {
	return new Promise((resolve, reject) => {
		$.get("final.php", function (finalHTML) {
			resolve(finalHTML);
		}, "html");
	});
}

