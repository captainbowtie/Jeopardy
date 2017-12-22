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

define("host","localhost");
define("dbname","jeopardy");
define("username","test");
define("passwd","password");

$isAdmin = FALSE;

if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $connection = new mysqli(host, username, passwd, dbname);
    $userQuery = "SELECT isAdmin FROM users WHERE id=$id";
    $userResult = $connection->query($userQuery);
    $userResult->data_seek(0);
    $roleArray = $userResult->fetch_array(MYSQLI_ASSOC);
    $userResult->close();
    if($roleArray['isAdmin']==1){
        $isAdmin=TRUE;
    }
}