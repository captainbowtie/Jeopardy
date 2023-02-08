var category;
var value;

$(".unanswered").click(function () {
	category = $(this).attr("category");
	value = $(this).attr("value");
	$(this).attr("disabled", true);
	displayQuestion();
});

$("#startTimer").click(function () {
	$.post("api/startTimer.php");
});

function displayQuestion() {
	$.post("api/updateState.php", { display: "question", category: category, value: value, buzz: -1 });
	$.get("api/getQA.php", { category: category, value: value }, function (qa) {
		$("#question").html(qa.question);
		$("#answer").html(qa.answer);
	}, "json");
}