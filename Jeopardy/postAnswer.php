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
    //Connect to database
    $db = new mysqli(host, username, passwd, dbname);

    //Get status
    $statusResult = $db->$query("SELECT * FROM status");
    $statusResult->data_seek(0);
    $status = $statusResult->fetch_array(MYSQLI_ASSOC);
    //$status = json_decode(file_get_contents("status.json"), true);

    $playerId = $status["buzzStatus"];
    $getScoreQuery = "SELECT score FROM users WHERE id=$playerId";
    $scoreResult = $db->query($getScoreQuery);
    $scoreResult->data_seek(0);
    $scoreRow = $scoreResult->fetch_array(MYSQLI_NUM);

    if ($status["dailyDoubleWager"] > 0) { //check if this is daily double
        if ($_POST["correct"] == 1) {
            $newScore = $scoreRow[0] + $status["dailyDoubleWager"];
        } else {
            $newScore = $scoreRow[0] - $status["dailyDoubleWager"];
        }
        resetForNextQuestion($db, $status);
    } else { //if it's not a daily double, then
        if ($_POST["correct"] == 1) {
            $newScore = $scoreRow[0] + $status["value"];
            $status["dailyDoublePlayer"] = $playerId;
            resetForNextQuestion($db, $status);
        } else if ($_POST["correct"] == 0) {
            //DEDUCT points from user
            $newScore = $scoreRow[0] - $status["value"];
            //CHECK if any other user could still buzz-in
            $remainingQuery = "SELECT id FROM buzzes WHERE id>1 && answered=0";
            $remainingResult = $db->query($remainingQuery);
            if ($remainingResult->num_rows > 0) {
                $status["buzzStatus"] = -1;
                file_put_contents("status.json", json_encode($status), LOCK_EX);
            } else {
                resetForNextQuestion($db, $status);
            }
        } else if ($_POST["correct"] == -1) {
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
    $status["buzzStatus"] = -2;
    $status["dailyDouble"]["wager"] = -1;
    $doubleQuery = "SELECT category,hasBeenSelected FROM questions WHERE category>6 && hasBeenSelected=0";
    $doubleResult = $db->query($doubleQuery);
    if ($doubleResult->num_rows > 0) {
        $status["status"] = "gameboard";
    } else {
        $status["status"] = "finalJeopardy";
    }
    file_put_contents("status.json", json_encode($status), LOCK_EX);
}
