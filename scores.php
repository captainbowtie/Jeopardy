<?php
//get info for database connection
require_once __DIR__ . "/config.php";
require_once SITE_ROOT . "/database.php";

//get players and scores
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT name, score FROM players ORDER BY id");
$stmt->execute();
$players = $stmt->fetchAll(\PDO::FETCH_ASSOC);

echo "<table>\n<tr>\n";
for ($a = 0; $a < sizeof($players); $a++) {
	echo "<th>" . $players[$a]["name"] . "</th>\n";
}
echo "</tr>\n<tr>";
for ($a = 0; $a < sizeof($players); $a++) {
	echo "<td>" . $players[$a]["score"] . "</td>\n";
}
echo "</tr>\n</table>\n";
