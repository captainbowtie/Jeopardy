<?php
session_start();

if (isset($_SESSION["player"])) {
	$bodyHTML = "<div style='display:grid'>";
	$bodyHTML .= "<div id='player' style='grid-column:1/3;grid-row:1/2'>" . $_SESSION["player"] . "</div>";
	$bodyHTML .= "<button id='buzzer' style='grid-column:1/3;grid-row:3/5'>Buzz In</button>";
	$bodyHTML .= "<div style='grid-column:1/2;grid-row:5/6'>Wager</div>";
	$bodyHTML .= "<input id='wager' style='grid-column:2/3;grid-row:5/6'></input>";
	$bodyHTML .= "<div style='grid-column:1/2;grid-row:6/7'>Answer</div>";
	$bodyHTML .= "<input id='answer' style='grid-column:2/3;grid-row:6/7'></input>";
	$bodyHTML .= "</div>";
	$bodyHTML .= "</div>";
} else {
	//get info for database connection
	require_once __DIR__ . "/config.php";
	require_once SITE_ROOT . "/database.php";

	//get players and scores
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//get list of all players
	$stmt = $db->prepare("SELECT name, score FROM players ORDER BY id");
	$stmt->execute();
	$players = $stmt->fetchAll(\PDO::FETCH_ASSOC);

	$bodyHTML = "<h1>Please select your name:</h1>\n";
	$bodyHTML .= "<div style='display:grid'>";
	for ($a = 0; $a < sizeof($players); $a++) {
		$a1 = $a + 1;
		$a2 = $a + 2;
		$bodyHTML .= "<button class='name' style='grid-column:1/2;grid-row:$a1/$a2'>" . $players[$a]["name"] . "</button>";
	}


	$bodyHTML .= "</div>";
}
echo <<<_END
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title></title>
    <script src="./jquery.js"></script>
    <link rel="Stylesheet" href="./player.css" type="text/css" />
  </head>
  <body>
_END;
echo $bodyHTML;
echo <<<_END
</body>
  <script src="./player.js"></script>
</html>
_END;
