<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//reset player buzzers
$buzzerSQL = "UPDATE players SET buzzed = 0";
$buzzerStmt = $db->prepare($buzzerSQL);
$buzzerStmt->execute();

//reset board
$boardSQL = "UPDATE gameState SET display = 'board', buzz = -1";
$boardStmt = $db->prepare($boardSQL);
$boardStmt->execute();
