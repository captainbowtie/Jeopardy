<?php
//get info for database connection
require_once __DIR__ . "/config.php";
require_once SITE_ROOT . "/database.php";

//get players and scores
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("SELECT name, score FROM players ORDER BY id");
$stmt->execute();
$players = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$scoreHTML = "<div id='scores' style='display:grid'>\n";
for ($a = 0; $a < sizeof($players); $a++) {
  $a1 = $a + 1;
  $a2 = $a + 2;
  $scoreHTML .= "<div id='player$a1' class='player' style='grid-row:1/2;grid-column:{$a1}/{$a2}'>" . $players[$a]["name"] . "</div>\n";
  $scoreHTML .= "<div id='score$a1' style='grid-row:2/3;grid-column:{$a1}/{$a2}'>" . $players[$a]["score"] . "</div>\n";
}
$scoreHTML .= "</div>";


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <title></title>
  <script src="./jquery.js"></script>
  <link rel="Stylesheet" href="./display.css" type="text/css" />
</head>

<body>
  <div id="display"></div>
  <div id="timer" style="display: grid">
    <div class="five timerBox" style="grid-column: 1/2; grid-row: 1/2">-</div>
    <div class="four timerBox" style="grid-column: 2/3; grid-row: 1/2">-</div>
    <div class="three timerBox" style="grid-column: 3/4; grid-row: 1/2">
      -
    </div>
    <div class="two timerBox" style="grid-column: 4/5; grid-row: 1/2">-</div>
    <div class="one timerBox" style="grid-column: 5/6; grid-row: 1/2">-</div>
    <div class="two timerBox" style="grid-column: 6/7; grid-row: 1/2">-</div>
    <div class="three timerBox" style="grid-column: 7/8; grid-row: 1/2">
      -
    </div>
    <div class="four timerBox" style="grid-column: 8/9; grid-row: 1/2">-</div>
    <div class="five timerBox" style="grid-column: 9/10; grid-row: 1/2">
      -
    </div>
  </div>
  <?php echo $scoreHTML; ?>
</body>
<script src="./display.js"></script>

</html>