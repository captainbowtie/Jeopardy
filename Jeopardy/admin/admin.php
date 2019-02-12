<?php

/*
  Copyright (C) 2017 allen

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();

require_once "../privileges.php";
require_once "./createTables.php";

//Check if tables exist, and if not, create them
checkTables();

echo "<!DOCTYPE html>\n";
echo "<html lang='en'>\n";
echo "<head>\n";
echo "<title>Jeopardy: Admin</title>\n";
echo "<script src='../jquery-3.3.1.min.js'></script>\n";
echo "<link rel='Stylesheet' href='./admin.css' type='text/css' />\n";
echo "</head>\n";
echo "<body>\n";
if ($isAdmin) {
    boardAdmin();
} else {
    require_once "../login.php";
}
echo "<script src='./admin.js'></script>";
echo "</body>\n";
echo "</html>\n";

function checkTables() {
    $db = new mysqli(host, username, passwd, dbname);
    $existQuery = "SHOW TABLES LIKE 'users'";
    $existResult = $db->query($existQuery);
    if (!($existResult->num_rows > 0)) {

        createTables();

        //Reset session
        $_SESSION = array();
        session_destroy();
        echo '<meta http-equiv="refresh" content="0;url=/admin.php">';
    }
}

function boardAdmin() {

    echo "<div id='board'></div>\n";
    echo "<div id='score'></div>\n";
    echo "<div id='question'></div>\n";
    echo<<<_END
            <div id='qDiv'>Question: N/A</div>
            <div id='aDiv'>Answer: N/A</div>
            <div>
            <input id='wrong' type='button' value='Wrong'>
            <input id='correct' type='button' value='Correct'>
            </div>
_END;
}
