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

//Connect to database
require_once("privileges.php");
$db = new mysqli(host, username, passwd, dbname);

//Read status from database
$statusResult = $db->query("SELECT * FROM status");
$statusResult->data_seek(0);
$status = $statusResult->fetch_array(MYSQLI_ASSOC);

//Write status as string
//{"status":"gameboard","category":"2","value":"400","buzzStatus":-2,"dailyDouble":{"player":"7","wager":-1}}
$status = '{"status":"'.$status["display"].
        '","category":"'.$status["category"].
        '","value":"'.$status["value"].
        '","buzzStatus":'.$status["buzzStatus"].
        ',"dailyDouble":{"player":"'.$status["dailyDoublePlayer"].
        '","wager":'.$status["dailyDoubleWager"].
        '}}';

echo $status;
