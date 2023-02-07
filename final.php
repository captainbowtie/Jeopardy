<?php
//get info for database connection
require_once __DIR__ . "/config.php";
require_once SITE_ROOT . "/database.php";

//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT display, finalC, finalQ, finalA FROM gameState");
$stmt->execute();
$state = $stmt->fetchAll(\PDO::FETCH_ASSOC);

switch ($state[0]["display"]) {
	case "finalC":
		echo $state[0]["finalC"];
		break;
	case "finalQ":
		echo $state[0]["finalQ"];
		break;
	case "finalA":
		echo $state[0]["finalA"];
		break;
	default:
		break;
}
