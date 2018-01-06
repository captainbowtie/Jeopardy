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
    if ($lagTrials >= 1) {
        //Add up the individual lags for each player
        $lags = [];
        for($a = 2;$a<9;$a++){
            $playerLagQuery = "SELECT time FROM lag WHERE playerId = $a";
            $playerLagResult = $db->query($playerLagQuery);
            $lags[$a] = 0;
            for($b = 0;$b<$lagTrials;$b++){
                $playerLagResult->data_seek($b);
                $playerLag = $playerLagResult->fetch_array(MYSQLI_NUM);
                $lags[$a] += $playerLag[0];
            }
        }
        
        //Find which player has the lowest total lag
        $minLag = $lags[2];
        for($a = 3;$a<9;$a++){
            if($lags[$a]<$minLag){
                $minLag = $lags[$a];
            }
        }
        
        //Subtract mimimum lag from all lags, then divide by number of trials
        for($a = 2;$a<9;$a++){
            $lag = ($lags[$a]-$minLag)/$lagTrials;
            $lagWriteQuery = "UPDATE buzzes SET lag = $lag WHERE id = $a";
            $db->query($lagWriteQuery);
            echo "$a: ".$lag."\n";
        }
        
        
    }
    //Delete all lag rows
    $db->query("DELETE FROM lag WHERE 1 = 1");
}