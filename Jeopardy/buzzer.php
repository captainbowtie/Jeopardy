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
        <script src='jquery-3.2.1.min.js'></script>
<link rel="Stylesheet" href="buzzer.css" type="text/css" />
    </head>
_END;

$db = new mysqli(host, username, passwd, dbname);

if (!isset($_SESSION['id'])) {
    echo<<<_END
    <body>
_END;
    $nameQuery = "SELECT id,name FROM users WHERE isAdmin=0";
    $nameResult = $db->query($nameQuery);
    for ($a = 0; $nameResult->num_rows; $a++) {
        $nameResult->data_seek($a);
        $name = $nameResult->fetch_array(MYSQLI_ASSOC);
        echo "<input type='button' class='idButton' id='b" . $name["id"] . "' value='" . $name["name"] . "'>\n";
    }
    echo<<<_END
    <script src='buzzer.js'></script>
    </body>
_END;
} else {
    $id = $_SESSION['id'];
    $userQuery = "SELECT name FROM users WHERE id=$id";
    $userResult = $db->query($userQuery);
    $user = $userResult->fetch_array(MYSQLI_ASSOC);
    $name = $user['name'];

    echo<<<_END
    <body>
<div id="name">
  $name
</div>
<div id="buzzerDiv">
  <input id="buzzer" type="button" value="Buzz In">
</div>

<div>
        <form>
<input id="bid" type="number" inputmode="numeric" pattern="[0-9]*">
        </form>
</div>
        <script src='buzzer.js'></script>
</body>
_END;
}
echo "</html>";
