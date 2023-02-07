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
echo "<table>\n";
echo "<tr>\n";
for ($a = 0; $a < 6; $a++) { //print category row
	echo "<th>" . $categories[$a]["name"] . "</th>\n";
}
echo "</tr>\n";

for ($a = 0; $a < 30; $a++) { //print question rows
	if ($a % 6 == 0) { //if index is a multiple of 5, then its the start of a row
		echo "<tr>\n";
	}
	if (!$doubleJeopardy) { //check whether to use single or double jeopardy questions
		echo "<td ";
		if ($questions[$a]["answered"] == 0) {
			echo "class='unanswered'>";
		} else {
			echo "class='answered'>";
		}
		echo ($questions[$a]["value"] * 100) . "</td>\n";
	} else {
		echo "<td>" . ($questions[$a + 30]["value"] * 200) . "</td>\n";
	}
	if ($a % 6 == 5) { //if index is a multiple of 6 - 1, then its the end of a row
		echo "</tr>\n";
	}
}
echo "</table>\n";

/*
if(thereAreSingleQuestions){
	categories = single categories;
	$v = 200;
}else{
	categories = double categories;
	$v = 400;
}

?>
<table id="board">
	<tr id='categories'>
		<td class='category'><?php echo $c0; ?></td>
		<td class='category'><?php echo $c1; ?></td>
		<td class='category'><?php echo $c2; ?></td>
		<td class='category'><?php echo $c3; ?></td>
		<td class='category'><?php echo $c4; ?></td>
		<td class='category'><?php echo $c5; ?></td>
	</tr>
	<tr id='row1'>
		<td id='c0-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c1-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c2-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c3-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c4-0' class='question'>$<?php echo $v * 1; ?></td>
		<td id='c5-0' class='question'>$<?php echo $v * 1; ?></td>
	</tr>
	<tr id='row2'>
		<td id='c0-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c1-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c2-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c3-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c4-1' class='question'>$<?php echo $v * 2; ?></td>
		<td id='c5-1' class='question'>$<?php echo $v * 2; ?></td>
	</tr>
	<tr id='row3'>
		<td id='c0-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c1-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c2-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c3-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c4-2' class='question'>$<?php echo $v * 3; ?></td>
		<td id='c5-2' class='question'>$<?php echo $v * 3; ?></td>
	</tr>
	<tr id='row4'>
		<td id='c0-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c1-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c2-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c3-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c4-3' class='question'><?php echo $v * 4; ?></td>
		<td id='c5-3' class='question'><?php echo $v * 4; ?></td>
	</tr>
	<tr id='row5'>
		<td id='c0-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c1-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c2-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c3-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c4-4' class='question'><?php echo $v * 5; ?></td>
		<td id='c5-4' class='question'><?php echo $v * 5; ?></td>
	</tr>
</table>*/