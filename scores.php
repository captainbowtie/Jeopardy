<?php
//get info for database connection
require_once __DIR__ . "/config.php";
require_once SITE_ROOT . "/database.php";

//get players and scores
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT name, score FROM players ORDER BY id");
$stmt->execute();
$players = $stmt->fetchAll(\PDO::FETCH_ASSOC);

echo "<div id='scores' style='display:grid'>\n";
for ($a = 0; $a < sizeof($players); $a++) {
	$a1 = $a + 1;
	$a2 = $a + 2;
	echo "<div style='grid-row:1/2;grid-column:{$a1}/{$a2}'>" . $players[$a]["name"] . "</div>\n";
	echo "<div style='grid-row:2/3;grid-column:{$a1}/{$a2}'>" . $players[$a]["score"] . "</div>\n";
}
echo "</div>";
