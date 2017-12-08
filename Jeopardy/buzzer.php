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

echo<<<_END
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
<link rel="Stylesheet" href="buzzer.css" type="text/css" />
    </head>
_END;

if(!isset($_SESSION['id'])){
    echo<<<_END
    <body>
    <input type="button" class="idButton" id="b2" value="Caleb">
    <input type="button" class="idButton" id="b3" value="Sophia">
    <input type="button" class="idButton" id="b4" value="Bri">
    <input type="button" class="idButton" id="b5" value="Reilly">
    <input type="button" class="idButton" id="b6" value="Katie">
    <input type="button" class="idButton" id="b7" value="Abby">
    <input type="button" class="idButton" id="b8" value="Lilly">
    <script src='buzzer.js'></script>
    </body>
_END;
    
}else{
    $id = $_SESSION['id'];
    $db = new mysqli(host, username, passwd, dbname);
    $userQuery = "SELECT name,score FROM users WHERE id=$id";
    $userResult = $db->query($userQuery);
    $user = $userResult->fetch_array(MYSQLI_ASSOC);
    $name = $user['name'];
    $score = $user['score'];
    
echo<<<_END
    <body>
<div id="name">
  $name
</div>
<div id="money">
  $score
</div>
<div id="buzzerDiv">
  <input id="buzzer" type="button" value="Buzz In">
</div>

<div>
<input id="bid" type="number">
</div>
        <script src='buzzer.js'></script>
</body>
_END;
}
echo "</html>";