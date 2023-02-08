<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stateStmt = $db->prepare("SELECT buzz,qCategory,qValue FROM gameState");
$stateStmt->execute();
$state = $stateStmt->fetchAll(\PDO::FETCH_ASSOC);

if ($state[0]["qCategory"] > 6) {
	$multiplier = 200;
} else {
	$multiplier = 100;
}

//update scores
$scoreSQL = "UPDATE players SET score = score + " . ($multiplier * $state[0]["qValue"]) . " WHERE id = " . $state[0]["buzz"];
$scoreStmt = $db->prepare($scoreSQL);
$scoreStmt->execute();

//reset player buzzers
$buzzerSQL = "UPDATE players SET buzzed = 0";
$buzzerStmt = $db->prepare($buzzerSQL);
$buzzerStmt->execute();

//reset board
$boardSQL = "UPDATE gameState SET display = 'board', buzz = -1";
$boardStmt = $db->prepare($boardSQL);
$boardStmt->execute();
