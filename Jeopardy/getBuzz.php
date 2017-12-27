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

if($isAdmin){
    $db = new mysqli(host, username, passwd, dbname);
    $buzzQuery = "SELECT id,time-lag AS 'realTime' FROM buzzes WHERE answered=0 && time>0 ORDER BY realTime";
    $buzzResult = $db->query($buzzQuery);
    $buzzResult->data_seek(0);
    $buzz = $buzzResult->fetch_array(MYSQLI_NUM);
    $buzzId = $buzz[0];
    $json = json_decode(file_get_contents("status.json"), true);
    $json["buzzStatus"] = $buzzId;
    file_put_contents("status.json", json_encode($json), LOCK_EX);
    $buzzUpdate = "UPDATE buzzes SET answered=1 WHERE id=$buzzId";
    $db->query($buzzUpdate);
    echo $buzzId;
}