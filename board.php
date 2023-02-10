<?php
//get info for database connection
require_once __DIR__ . "/config.php";
require_once SITE_ROOT . "/database.php";

//get list of question categories, values, and whether they've been answered
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$doubleStmt = $db->prepare("SELECT category, value, answered FROM questions ORDER BY id");
$doubleStmt->execute();
$double = $doubleStmt->fetchAll(\PDO::FETCH_ASSOC);

//check if all single jeopardy questions have been answered
//start by assuming they have, and then itterate through all of them until we find one that has or the interation finishes
$doubleJeopardy = true;
$index = 0;
while ($doubleJeopardy && $index < 30) {
	if ($double[$index]["answered"] == 0) { //check if a single jeopardy question (index<30) has not been answered
		$doubleJeopardy = false; //if so, it's not time for double jeopardy
	}
	$index++;
}

//get appropriate categories for single or double jeopardy
if (!$doubleJeopardy) {
	$cStmt = $db->prepare("SELECT name FROM categories WHERE id < 7 ORDER BY id");
} else {
	$cStmt = $db->prepare("SELECT name FROM categories WHERE id > 6 ORDER BY id");
}
$cStmt->execute();
$categories = $cStmt->fetchAll(\PDO::FETCH_ASSOC);

//get appropriate questions for signle or double jeopardy
if (!$doubleJeopardy) {
	$qStmt = $db->prepare("SELECT category, value, answered FROM questions WHERE id < 31 ORDER BY value, category");
} else {
	$qStmt = $db->prepare("SELECT category, value, answered FROM questions WHERE id > 30 ORDER BY value, category");
}
$qStmt->execute();
$questions = $qStmt->fetchAll(\PDO::FETCH_ASSOC);

//build table
echo "<div id='board' style='display:grid;'>\n";
for ($a = 0; $a < 6; $a++) { //print category row
	$a1 = $a + 1;
	$a2 = $a + 2;
	echo "<div class='category' style='grid-row:1/2;grid-column:{$a1}/{$a2}'>" . $categories[$a]["name"] . "</div>\n";
}
if (!$doubleJeopardy) {
	$multiplier = 100;
} else {
	$multiplier = 200;
}
for ($a = 0; $a < 30; $a++) {
	if (!$doubleJeopardy) {
		$startColumn = $questions[$a]["category"];
	} else {
		$startColumn = $questions[$a]["category"] - 6;
	}

	$endColumn = $startColumn + 1;
	$startRow = $questions[$a]["value"] + 1;
	$endRow = $startRow + 1;
	$value = $questions[$a]["value"] * $multiplier;
	if ($questions[$a]["answered"] == 0) {
		$class = "class='unanswered'";
	} else {
		$class = "class='answered'";
	}
	echo "<div {$class} style='grid-row:{$startRow}/{$endRow};grid-column:{$startColumn}/{$endColumn}'>" . $value . "</div>\n";
}

echo "</div>";
