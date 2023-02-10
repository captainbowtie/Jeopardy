$(".name").click(function () {
	$.post("api/setPlayer.php", { player: $(this).html() }, function () { window.location.reload(); });
});

$("#buzzer").click(function () {
	$.post("api/buzzIn.php");
});

$("#wager").on("change", function (event) {
	$.post("api/setWager.php", { wager: $(this).val() });
	event.preventDefault();
});