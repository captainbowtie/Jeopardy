<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";




if ( //no point in doing anything if the wager data is improper
	isset($_POST["wager"])

) {
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$wager = htmlspecialchars(strip_tags($_POST["wager"]));
	//check if it is displaying dailyDouble ("question") or final jeopardy category
	$stateStmt = $db->prepare("SELECT display FROM gameState");
	$stateStmt->execute();
	$state = $stateStmt->fetchAll(\PDO::FETCH_ASSOC);
	if ($state[0]["display"] == "finalC" || $state[0]["display"] == "question") {
		//only if final category or daily double is displayed, allow wager submission
		$wagerStmt = $db->prepare("UPDATE players SET wager = " . $wager . " WHERE name = '" . $_SESSION["player"] . "'");
		$wagerStmt->execute();
	}
} else {
	echo "Invalid wager data";
}
