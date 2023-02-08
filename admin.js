var category;
var value;

$(".unanswered").click(function () {
	category = $(this).attr("category");
	value = $(this).attr("value");
	$(this).attr("disabled", true);
	displayQuestion();
});

$(".score").on("change", function () {
	let playerID = $(this).attr("id").substring(5);
	let score = $(this).val();
	$.post("api/setScore.php", { id: playerID, score: score });
});

$("#startTimer").click(function () {
	$.post("api/startTimer.php");
});

$("#correct").click(function () {
	$.post("api/setCorrect.php");
});

$("#incorrect").click(function () {
	$.post("api/setIncorrect.php");
});

$("#return").click(function () {
	$.post("api/updateState.php", { display: "board", category: 0, value: 0, buzz: -1 });
	$.post("api/resetBuzzers.php");
});

function displayQuestion() {
	$.post("api/updateState.php", { display: "question", category: category, value: value, buzz: -1 });
	$.get("api/getQA.php", { category: category, value: value }, function (qa) {
		$("#question").html(qa.question);
		$("#answer").html(qa.answer);
	}, "json");
}