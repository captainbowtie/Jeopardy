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

$status = json_decode(file_get_contents("status.json"), true);

if ($status["status"] == finalJeopardy) {
    $db = new mysqli(host, username, passwd, dbname);
    $wager = $_POST["wager"];
    $playerId = $_SESSION["id"];
    $wagerQuery = "UPDATE users SET finalWager = $wager WHERE id = $playerId";
    $db->query($wagerQuery);
    
    
} else {
    if ($status["dailyDouble"]["player"] == $_SESSION["id"] && $status["dailyDouble"]["wager"] == 0) {
        $status["dailyDouble"]["wager"] = $_POST["wager"];
        file_put_contents("status.json", json_encode($status), LOCK_EX);
    }
}

