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

require_once 'privileges.php';

if ($isAdmin) {
    $db = new mysqli(host, username, passwd, dbname);
    $lagQuery = "SELECT playerId,time FROM lag ORDER BY time";
    $lagResult = $db->query($lagQuery);
    $lagTrials = ($lagResult->num_rows) / 7;
    $lags = [[]];
    //Go through all lags
    for ($a = 0; $a < $lagTrials; $a++) {
        //For each group of 7, subtract the smallest from the rest
        $minLag = 0;
        for ($b = 0; $b < 7; $b++) {
            $lagResult->data_seek($a * 7 + $b);
            $resultRow = $lagResult->fetch_array(MYSQLI_ASSOC);
            $playerId = $resultRow["playerId"];
            $time = $resultRow["time"];
            $lags[$playerId][$a] = $time;
            if ($b == 0) {
                $minLag = $time;
            }
        }

        for ($b = 2; $b < 9; $b++) {
            $lags[$b][$a] = $lags[$b][$a] - $minLag;
        }
    }

    //Calculate each player's average lag
    $averageLags = [];
    for ($a = 2; $a < 9; $a++) {
        $averageLags[$a] = 0;
        for ($b = 0; $b < $lagTrials; $b++) {
            $averageLags[$a] += $lags[$a][$b];
        }
        $averageLags[$a] = $averageLags[$a] / $lagTrials;
    }

    //Find minimum lag, then subtract minimum lag from all the others
    //Find minimum
    $minLag = $averageLags[2];
    for ($a = 2; $a < 9; $a++) {
        if ($averageLag[$a] < $minLag) {
            $minLag = $averageLag[$a];
        }
    }
    //Subtract it from others, and write to DB
    for($a = 2;$a<9;$a++){
        //Subtract
        $lag = $averageLag[$a]-$minLag;
        //Write
        $lagQuery = "UPDATE buzzes SET lag = $lag WHERE id = $a";
        $db->query($lagQuery);
    }
    
    //Delete all lag rows
    $db->query("DELETE FROM buzzes WHERE 1 = 1");
    
}