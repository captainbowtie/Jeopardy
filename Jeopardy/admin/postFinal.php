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

require_once "../privileges.php";

if ($isAdmin) {
    //Set variables
    $playerId = $_POST["playerId"];
    $isCorrect = $_POST["isCorrect"];

    //Get score and wager
    $wagerQuery = "SELECT score,finalWager FROM users WHERE id = $playerId";
    $db = new mysqli(host, username, passwd, dbname);
    $wagerResult = $db->query($wagerQuery);
    $wagerResult->data_seek(0);
    $wagerRow = $wagerResult->fetch_array(MYSQLI_NUM);
    $oldScore = $wagerRow[0];
    $wager = $wagerRow[1];

    //Set new score
    if ($isCorrect) {
        $newScore = $oldScore + $wager;
    } else {
        $newScore = $oldScore - $wager;
    }

    //Write score to database
    $scoreQuery = "UPDATE users SET score = $newScore WHERE id = $playerId";
    $db->query($scoreQuery);
}