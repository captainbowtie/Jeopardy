<?php
require_once __DIR__ . '/../config.php';
require_once SITE_ROOT . "/database.php";

$data = json_decode(file_get_contents("php://input"));

if (
	isset($_POST["id"]) &&
	isset($_POST["score"])

) {
	$id = htmlspecialchars(strip_tags($_POST["id"]));
	$score = htmlspecialchars(strip_tags($_POST["score"]));

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "UPDATE players SET score = $score WHERE id = $id";

	$result = $db->prepare($sql);

	$result->execute();
} else {
	echo "{'error':'invalid score parameters'}";
}
