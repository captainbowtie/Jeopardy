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

require_once "privileges.php";
require_once "createTables.php";

//Check if tables exist, and if not, create them
checkTables();

echo "<!DOCTYPE html>\n";
echo "<html lang='en'>\n";
echo "<head>\n";
echo "<title>Jeopardy: Admin</title>\n";
echo "<script src='jquery-3.3.1.min.js'></script>";
echo "</head>\n";
echo "<body>\n";
if ($isAdmin) {
    boardAdmin();
} else {
    require_once "login.php";
}
echo "<script src='admin.js'></script>";
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

    $db = new mysqli(host, username, passwd, dbname);

    $singleQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category<6 && hasBeenSelected=0";
    $singleResult = $db->query($singleQuery);

    if ($singleResult->num_rows > 0) {
        $f = 0;
    } else {
        $doubleQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category>5 && hasBeenSelected=0";
        $singleResult = $db->query($doubleQuery);
        $f = 1;
    }

    //Get category names
    $categoryQuery = "SELECT category FROM categories WHERE isDouble=$f";
    $categoriesResult = $db->query($categoryQuery);

    //Put category names in string variables
    for ($a = 0; $a < 6; $a++) {
        $categoriesResult->data_seek($a);
        $cg = $categoriesResult->fetch_array(MYSQLI_NUM);
        $categories[$a] = $cg[0];
    }

    //Set category names
    $cat0 = $categories[0];
    $cat1 = $categories[1];
    $cat2 = $categories[2];
    $cat3 = $categories[3];
    $cat4 = $categories[4];
    $cat5 = $categories[5];

    //Set category number for buttons
    $c0 = 0 + 6 * $f;
    $c1 = 1 + 6 * $f;
    $c2 = 2 + 6 * $f;
    $c3 = 3 + 6 * $f;
    $c4 = 4 + 6 * $f;
    $c5 = 5 + 6 * $f;

    //Set price string values
    $v0 = ($f + 1) * 100;
    $v1 = ($f + 1) * 200;
    $v2 = ($f + 1) * 300;
    $v3 = ($f + 1) * 400;
    $v4 = ($f + 1) * 500;

    echo<<<_END
 <div id='display'>
    <table id='gameBoard'>
      <tr id='categories'>
        <td class='category'>$cat0</td>

        <td class='category'>$cat1</td>

        <td class='category'>$cat2</td>

        <td class='category'>$cat3</td>

        <td class='category'>$cat4</td>

        <td class='category'>$cat5</td>
      </tr>

      <tr id='100'>
        <td><input id='c0-0' category='$c0' class='boardButton' type='button' value='$v0' /></td>

        <td><input id='c1-0' category='$c1' class='boardButton' type='button' value='$v0' /></td>

        <td><input id='c2-0' category='$c2' class='boardButton' type='button' value='$v0' /></td>

        <td><input id='c3-0' category='$c3' class='boardButton' type='button' value='$v0' /></td>

        <td><input id='c4-0' category='$c4' class='boardButton' type='button' value='$v0' /></td>

        <td><input id='c5-0' category='$c5' class='boardButton' type='button' value='$v0' /></td>
      </tr>

      <tr id='200'>
        <td><input id='c0-1' category='$c0' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c1-1' category='$c1' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c2-1' category='$c2' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c3-1' category='$c3' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c4-1' category='$c4' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c5-1' category='$c5' class='boardButton' type='button' value='$v1' /></td>
      </tr>

      <tr id='300'>
        <td><input id='c0-2' category='$c0' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c1-2' category='$c1' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c2-2' category='$c2' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c3-2' category='$c3' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c4-2' category='$c4' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c5-2' category='$c5' class='boardButton' type='button' value='$v2' /></td>
      </tr>

      <tr id='400'>
        <td><input id='c0-3' category='$c0' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c1-3' category='$c1' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c2-3' category='$c2' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c3-3' category='$c3' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c4-3' category='$c4' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c5-3' category='$c5' class='boardButton' type='button' value='$v3' /></td>
      </tr>

      <tr id='500'>
        <td><input id='c0-4' category='$c0' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c1-4' category='$c1' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c2-4' category='$c2' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c3-4' category='$c3' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c4-4' category='$c4' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c5-4' category='$c5' class='boardButton' type='button' value='$v4' /></td>
      </tr>
    </table>
  </div>
_END;

    $scoreQuery = "SELECT name,score FROM users WHERE isAdmin=0";
    $scoreResult = $db->query($scoreQuery);

//Fill in score data

    $scores = null;

    for ($a = 0; $a < $scoreResult->num_rows; $a++) {
        $scoreResult->data_seek($a);
        $score = $scoreResult->fetch_array(MYSQLI_NUM);
        $scores[$a]["name"] = $score[0];
        $scores[$a]["score"] = $score[1];
    }


    echo<<<_END
<div>
    <table id='scores'>
      <tr>
_END;

    for ($a = 0; $a < $scoreResult->num_rows; $a++) {
        echo "<td id='comp" . ($a + 2) . "' class='competitor'>" . $scores[$a]["name"] . "</td>\n";
    }
    echo<<<_END
      </tr>

      <tr>
_END;
    for ($a = 0; $a < $scoreResult->num_rows; $a++) {
        echo "<td><input id='score" . ($a + 2) . "' class='scoreButton' type='button' value='" . $scores[$a]["score"] . "'></td>\n";
    }
    echo<<<_END
      </tr>
    </table>
  </div>
            <div id='qDiv'>Question: N/A</div>
            <div id='aDiv'>Answer: N/A</div>
            <div>
            <input id='wrong' type='button' value='Wrong'>
            <input id='correct' type='button' value='Correct'>
            </div>
_END;
}
