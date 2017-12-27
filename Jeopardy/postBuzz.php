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
$time = $_POST['time'];

$answeredQuery = "SELECT id FROM buzzes WHERE id=$id && answered=0";

$answerResult = $db->query($answeredQuery);

//Also need to check if buzzing in is allowed
$status = json_decode(file_get_contents("status.json"),true);

if ($status["buzzStatus"] > -2 && $status["buzzStatus"] < 1 && ($answerResult->num_rows > 0)) {

//Write buzz to buzz table
    $buzzQuery = "UPDATE buzzes SET time=$time WHERE id=$id";
    $db->query($buzzQuery);

//Write that someone buzzed in to status file
    $status["buzzStatus"] = 0;
    file_put_contents("status.json", json_encode($status), LOCK_EX);
}


