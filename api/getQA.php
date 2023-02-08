<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

if (
	isset($_GET["category"]) &&
	isset($_GET["value"])
) {
	$category = htmlspecialchars(strip_tags($_GET["category"]));
	$value = htmlspecialchars(strip_tags($_GET["value"]));
}


//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT question, answer FROM questions WHERE category = $category && value = $value");
$stmt->execute();
$state = $stmt->fetchAll(\PDO::FETCH_ASSOC);

echo json_encode($state[0]);
