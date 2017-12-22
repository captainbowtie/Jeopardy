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

require_once "privileges.php";

if ($isAdmin) {
    $status = json_decode(file_get_contents("status.json"), true);
    $db = new mysqli(host, username, passwd, dbname);
    $playerId = $status["buzzStatus"];
    $getScoreQuery = "SELECT score FROM users WHERE id=$playerId";
    $scoreResult = $db->query($getScoreQuery);
    $scoreResult->data_seek(0);
    $scoreRow = $scoreResult->fetch_array(MYSQLI_NUM);
    if ($_POST["correct"] == 1) {
        $newScore = $scoreRow[0] + $status["value"];
        resetForNextQuestion($db, $status);
    } else {
        //DEDUCT points from user
        $newScore = $scoreRow[0] - $status["value"];
        //CHECK if any other user could still buzz-in
        $remainingQuery = "SELECT id FROM buzzes WHERE id>1 && answered=0";
        $remainingResult = $db->query($remainingQuery);
        if ($remainingResult->num_rows > 0) {
            $status["buzzStatus"] = -1;
            file_put_contents("status.json", json_encode($status));
        } else {
            resetForNextQuestion($db, $status);
        }
    }
    $updateScoreQuery = "UPDATE users SET score=$newScore WHERE id=$playerId";
    $db->query($updateScoreQuery);
}

function resetForNextQuestion($db, $status) {
    //RESET buzzes table
    $buzzQuery = "UPDATE buzzes SET time=0, answered=0 WHERE id>1";
    $db->query($buzzQuery);

    //MARK question as asked
    $category = $status["category"];
    $value = $status["value"];
    $questionQuery = "UPDATE questions SET hasBeenSelected=1 WHERE category=$category && value=$value";
    $db->query($questionQuery);

    //RESET status file to gameboard and buzz status to -2
    $status["status"] = "gameboard";
    $status["buzzStatus"] = -2;
    file_put_contents("status.json", json_encode($status));
}
