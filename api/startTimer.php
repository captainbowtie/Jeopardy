<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "UPDATE gameState SET  buzz = 0";

$result = $db->prepare($sql);

$result->execute();
