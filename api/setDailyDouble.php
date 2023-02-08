<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

$data = json_decode(file_get_contents("php://input"));

if (
	isset($_POST["id"])

) {
	$id = htmlspecialchars(strip_tags($_POST["id"]));

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//change game state display question and mark the player in question as active
	$sql = "UPDATE gameState SET buzz = $id, display = 'dailyDouble'";

	$result = $db->prepare($sql);

	$result->execute();
} else {
	echo "{'error':'invalid daily double parameters'}";
}
