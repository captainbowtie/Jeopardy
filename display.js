displayLoop(){
	getGameState();
	switch (gameState) {
		case board:
			getBoard;
			$(#body).html(board);
			break;
		case question:
			getQuestion;
			$(#body).html(question);
			break;
		case dailyDouble:

			break;
		case finalJeopardy:

			break;
	}
}

function getGameState() {
	return new Promise((resolve, reject) => {
		$.get("api/getGameState.php", function (gameState) {
			resolve(gameState);
		}, "json");
	});
}

function getGameBoard() {
	return new Promise((resolve, reject) => {
		$.get("api/getBoard.php", function (boardHTML) {
			resolve(boardHTML);
		}, "html");
	});
}

function getScores() {
	return new Promise((resolve, reject) => {
		$.get("api/getScores.php", function (scoreHTML) {
			resolve(scoreHTML);
		}, "html");
	});
}

function getQuestion() {
	return new Promise((resolve, reject) => {
		$.get("api/getScores.php", function (questionHTML) {
			resolve(questionHTML);
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