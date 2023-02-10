<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT buzz FROM gameState");
$stmt->execute();
$state = $stmt->fetchAll(\PDO::FETCH_ASSOC);

if ($state[0]["buzz"] == 0) {
	$result = $db->prepare("UPDATE gameState SET  buzz = -2");
	$result->execute();
}
