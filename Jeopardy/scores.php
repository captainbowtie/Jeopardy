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
$scoreQuery = "SELECT id,name,score FROM users WHERE isAdmin=0";
$scoreResult = $db->query($scoreQuery);

//Fill in score data
$scores = [];

for ($a = 0; $a < $scoreResult->num_rows; $a++) {
    $scoreResult->data_seek($a);
    $score = $scoreResult->fetch_array(MYSQLI_ASSOC);
    $scores[$a]["id"] = $score["id"];
    $scores[$a]["name"] = $score["name"];
    $scores[$a]["score"] = $score["score"];
}

echo<<<_END
<table id='scores'>
<tr>
_END;
for ($a = 0; $a < $scoreResult->num_rows; $a++) {
    echo "<td id='comp" . $scores[$a]["id"] . "' class='competitor'>" . $scores[$a]["name"] . "</td>\n";
}
echo<<<_END
</tr>
<tr>
_END;
for ($a = 0; $a < $scoreResult->num_rows; $a++) {
    echo "<td id='score" . $scores[$a]["id"] . "' class='score'>" . $scores[$a]["score"] . "</td>\n";
}
echo<<<_END
</tr>
</table>
_END;
