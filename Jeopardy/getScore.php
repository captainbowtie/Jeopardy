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

$db = new mysqli(host, username, passwd, dbname);

$id = $_SESSION['id'];

if ($id > 1) {
    $scoreQuery = "SELECT score FROM users WHERE id=$id";
    $scoreResult = $db->query($scoreQuery);
    $score = $scoreResult->fetch_array(MYSQLI_NUM);
    echo $score[0];
} else {
    $scoreQuery = "SELECT id,score FROM users WHERE id>1";
    $return = "{";
    for ($a = 2; $a < 9; $a++) {
        $scoreResult = $db->query($scoreQuery);
        $scoreResult->data_seek($a-2);
        $score = $scoreResult->fetch_array(MYSQLI_NUM);
        $return = $return.'"'.$score[0].'":'.$score[1];
        if($a!=8){
            $return = $return.",";
        }else{
            $return = $return."}";
        }
    }
    echo $return;
}

