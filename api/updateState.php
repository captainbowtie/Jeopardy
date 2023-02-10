<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

$data = json_decode(file_get_contents("php://input"));

if (
	isset($_POST["display"]) &&
	isset($_POST["category"]) &&
	isset($_POST["value"]) &&
	isset($_POST["buzz"])
) {
	$display = htmlspecialchars(strip_tags($_POST["display"]));
	$qCategory = htmlspecialchars(strip_tags($_POST["category"]));
	$qValue = htmlspecialchars(strip_tags($_POST["value"]));
	$buzz = htmlspecialchars(strip_tags($_POST["buzz"]));

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "UPDATE gameState SET display = '$display', qCategory = $qCategory, qValue = $qValue, buzz = $buzz";

	$result = $db->prepare($sql);

	$result->execute();
} else {
	echo "{'error':'invalid state parameters'}";
}
