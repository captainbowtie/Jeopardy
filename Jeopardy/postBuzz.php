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

//connect to db
require_once "privileges.php";
$db = new mysqli(host, username, passwd, dbname);

//Get status
$statusResult = $db->query("SELECT * FROM status");
$statusResult->data_seek(0);
$status = $statusResult->fetch_array(MYSQLI_ASSOC);

$id = $_SESSION['id'];

$answeredQuery = "SELECT id FROM buzzes WHERE id=$id && answered=0";

$answerResult = $db->query($answeredQuery);
echo $status["buzzStatus"]." ".$id;
//Also need to check if buzzing in is allowed
if ($status["buzzStatus"] > -2 && $status["buzzStatus"] < 1 && ($answerResult->num_rows > 0)) {

    $time = gettimeofday(true) * 10000;

    //Write buzz to buzz table
    $buzzQuery = "UPDATE buzzes SET time=$time WHERE id=$id";
    $db->query($buzzQuery);

    //Write that someone buzzed in to status file
    $updateStatus = "UPDATE status SET buzzStatus=0";
    $db->query($updateStatus);
}