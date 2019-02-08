<?php

/*
 * Copyright (C) 2019 allen
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

require_once "../privileges.php";

if ($isAdmin) {

    $db = new mysqli(host, username, passwd, dbname);

    $scoreQuery = "SELECT name,score FROM users WHERE isAdmin=0";
    $scoreResult = $db->query($scoreQuery);

//Fill in score data

    $scores = null;

    for ($a = 0; $a < $scoreResult->num_rows; $a++) {
        $scoreResult->data_seek($a);
        $score = $scoreResult->fetch_array(MYSQLI_NUM);
        $scores[$a]["name"] = $score[0];
        $scores[$a]["score"] = $score[1];
    }


    echo<<<_END
<div>
    <table id='scores'>
      <tr>
_END;

    for ($a = 0; $a < $scoreResult->num_rows; $a++) {
        echo "<td id='comp" . ($a + 2) . "' class='competitor'>" . $scores[$a]["name"] . "</td>\n";
    }
    echo<<<_END
      </tr>

      <tr>
_END;
    for ($a = 0; $a < $scoreResult->num_rows; $a++) {
        echo "<td><input id='score" . ($a + 2) . "' class='scoreButton' type='button' value='" . $scores[$a]["score"] . "'></td>\n";
    }
    echo<<<_END
      </tr>
    </table>
  </div>
    <script src="./scoreAdmin.js"></script>
_END;
}