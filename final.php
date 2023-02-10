<?php
//get info for database connection
require_once __DIR__ . "/config.php";
require_once SITE_ROOT . "/database.php";

//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT display, finalC, finalQ, finalA, buzz FROM gameState");
$stmt->execute();
$state = $stmt->fetchAll(\PDO::FETCH_ASSOC);

switch ($state[0]["display"]) {
	case "finalC":
		echo "<div id='final'>" . $state[0]["finalC"] . "</div>";
		break;
	case "finalQ":
		echo "<div id='final'>" . $state[0]["finalQ"] . "</div>";
		break;
	case "finalA":
		if ($state[0]["buzz"] <= 0) {
			echo "<div id='final'>" . $state[0]["finalA"] . "</div>";
		} else {
			$ansrSQL = "SELECT answer,wager FROM players WHERE id = " . $state[0]["buzz"];
			$ansrStmt = $db->prepare($ansrSQL);
			$ansrStmt->execute();
			$answer = $ansrStmt->fetchAll(\PDO::FETCH_ASSOC);
			echo "<div id='final'>" . $answer[0]["wager"] . "<br>" . $answer[0]["answer"] . "</div>";
		}

		break;
	default:
		break;
}
