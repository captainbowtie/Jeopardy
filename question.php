<?php
//get info for database connection
require_once __DIR__ . "/config.php";
require_once SITE_ROOT . "/database.php";

//get game state
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT qCategory, qValue FROM gameState");
$stmt->execute();
$state = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$qStmt = $db->prepare("SELECT question,dailyDouble FROM questions WHERE category={$state[0]['qCategory']} && value={$state[0]['qValue']}");
$qStmt->execute();
$question = $qStmt->fetchAll(\PDO::FETCH_ASSOC);

$aStmt = $db->prepare("UPDATE questions SET answered = 1 WHERE category={$state[0]['qCategory']} && value={$state[0]['qValue']}");
$aStmt->execute();

if ($question[0]["dailyDouble"] == 1) {
	echo "<div id='dailyDouble'>Daily Double</div>";
} else {
	echo "<div id='question'>" . $question[0]["question"] . "</div>";
}
