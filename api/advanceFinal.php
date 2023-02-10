<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT display FROM gameState");
$stmt->execute();
$state = $stmt->fetchAll(\PDO::FETCH_ASSOC);

if ($state[0]["display"] == "finalQ") {
	$updateStmt = $db->prepare("UPDATE gameState SET display = 'finalA', buzz = 0");
} elseif ($state[0]["display"] == "finalC") {
	$updateStmt = $db->prepare("UPDATE gameState SET display = 'finalQ'");
} elseif ($state[0]["display"] == "finalA") {
	$updateStmt = $db->prepare("UPDATE gameState SET buzz = buzz + 1");
} else {
	$updateStmt = $db->prepare("UPDATE gameState SET display = 'finalC'");
}

$updateStmt->execute();
