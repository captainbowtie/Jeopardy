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

session_start();

//Connect to database
require_once "../privileges.php";
$db = new mysqli(host, username, passwd, dbname);

//Get status
$statusResult = $db->query("SELECT * FROM status");
$statusResult->data_seek(0);
$status = $statusResult->fetch_array(MYSQLI_ASSOC);

$category = $status["category"];
$value = $status["value"];

$questionQuery = "SELECT question,isDailyDouble FROM questions WHERE category=$category && value=$value";

$questionResult = $db->query($questionQuery);

$question = $questionResult->fetch_array(MYSQLI_ASSOC);

if (!$question["isDailyDouble"] == 0 && $status["dailyDoubleWager"] < 1) {
    echo "<div id='question'>\n";
    echo "DAILY DOUBLE\n";
    echo "</div>";
    if ($status["dailyDoubleWager"] == -1) {
        $updateStatus = "UPDATE status SET dailyDoubleWager=0 WHERE 1=1";
        $db->query($updateStatus);
    }
} else {
    require_once("timer.php");
    echo "<div id='question'>\n";
    echo $question["question"];
    echo "\n</div>";
}