<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT id,name,score FROM players");
$stmt->execute();
$state = $stmt->fetchAll(\PDO::FETCH_ASSOC);

echo json_encode($state);
