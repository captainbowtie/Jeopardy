<?php

/* 
 * Copyright (C) 2017 allen
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

//Connect to array
require_once "privileges.php";
$db = new mysqli(host, username, passwd, dbname);

//Fetch scores
$scoreQuery = "SELECT score FROM users WHERE isAdmin=0";
$scoreResult = $db->query($scoreQuery);

//Fill in score data
$scoreResult->data_seek(0);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$caleb = $score[0];
$scoreResult->data_seek(1);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$sophia = $score[0];
$scoreResult->data_seek(2);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$bri = $score[0];
$scoreResult->data_seek(3);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$reilly = $score[0];
$scoreResult->data_seek(4);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$katie = $score[0];
$scoreResult->data_seek(5);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$abby = $score[0];
$scoreResult->data_seek(6);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$lilly = $score[0];


echo<<<_END
<table id='scores'>
<tr>
<td id='comp2' class='competitor'>Caleb</td>
<td id='comp3' class='competitor'>Bri</td>
<td id='comp4' class='competitor'>Sophia</td>
<td id='comp5' class='competitor'>Reilly</td>
<td id='comp6' class='competitor'>Katie</td>
<td id='comp7' class='competitor'>Abby</td>
<td id='comp8' class='competitor'>Lilly</td>
</tr>
<tr>
<td id='score2' class='score'>$caleb</td>
<td id='score3' class='score'>$sophia</td>
<td id='score4' class='score'>$bri</td>
<td id='score5' class='score'>$reilly</td>
<td id='score6' class='score'>$katie</td>
<td id='score7' class='score'>$abby</td>
<td id='score8' class='score'>$lilly</td>
</tr>
</table>
_END;
