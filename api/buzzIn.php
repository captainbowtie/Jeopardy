<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sStmt = $db->prepare("SELECT buzz FROM gameState");
$pStmt = $db->prepare("SELECT id,buzzed FROM players WHERE name = '" . $_SESSION["player"] . "'");
$sStmt->execute();
$pStmt->execute();
$state = $sStmt->fetchAll(\PDO::FETCH_ASSOC);
$player = $pStmt->fetchAll(\PDO::FETCH_ASSOC);

if ($state[0]["buzz"] == 0 && $player[0]["buzzed"] == 0) {
	$bStmt = $db->prepare("UPDATE gameState SET buzz = " . $player[0]["id"]);
	$bStmt->execute();
	$bzStmt = $db->prepare("UPDATE players SET buzzed = 1 WHERE id = " . $player[0]["id"]);
}
