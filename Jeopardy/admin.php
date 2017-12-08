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

//Check if tables exist, and if not, create them
checkTables();

echo "<!DOCTYPE html>\n";
echo "<html lang='en'>\n";
echo "<head>\n";
echo "<title>Jeopardy: Admin</title>\n";
echo "<script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>";
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

        //Drop any existing tables
        $db->query("DROP TABLE categories");
        $db->query("DROP TABLE questions");
        $db->query("DROP TABLE users");

        //Create querys to add tables
        $categoryQuery = "CREATE TABLE categories("
                . "id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT KEY, "
                . "category VARCHAR(64) NOT NULL, "
                . "isDouble BINARY(1) NOT NULL DEFAULT '0') "
                . "ENGINE InnoDB";
        $questionQuery = "CREATE TABLE questions("
                . "id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT KEY, "
                . "category TINYINT UNSIGNED NOT NULL, "
                . "question VARCHAR(500) NOT NULL, "
                . "answer VARCHAR(500) NOT NULL, "
                . "value SMALLINT UNSIGNED NOT NULL, "
                . "isDailyDouble BINARY(1) NOT NULL DEFAULT '0', "
                . "hasBeenSelected BINARY(1) NOT NULL DEFAULT '0'"
                . ") ENGINE InnoDB";
        $userQuery = "CREATE TABLE users("
                . "id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT KEY, "
                . "name VARCHAR(64) NOT NULL DEFAULT 'Missing Name', "
                . "password CHAR(128) NOT NULL, "
                . "isAdmin BINARY(1) NOT NULL DEFAULT '0', "
                . "score MEDIUMINT UNSIGNED NOT NULL DEFAULT '0') ENGINE InnoDB";

        //Submit queries to create tables
        $db->query($categoryQuery);
        $db->query($questionQuery);
        $db->query($userQuery);

        //Populate admin user into table
        $generateAdmin = "INSERT INTO users(name, password, isAdmin) "
                . "VALUES('allen', "
                . "'66746ad3c2025daae865c793d2becd6e6f5719e0e528adc0ae2f5228332702081a5f100f2bb3e6c56c7b7de872af0c3dc755b4673c2490e1bd7a7002565ebfe8', " //Whirlpool hash for 'mock'
                . "'1')";
        $db->query($generateAdmin);

        //Reset session
        $_SESSION = array();
        session_destroy();
        echo '<meta http-equiv="refresh" content="0;url=/admin.php">';
    }
}

function boardAdmin() {

    $db = new mysqli(host, username, passwd, dbname);

    $singleQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category<7 && hasBeenSelected=0";
    $singleResult = $db->query($singleQuery);

    if ($singleResult->num_rows > 0) {
        $f = 0;
    } else {
        $doubleQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category>6 && hasBeenSelected=0";
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
    $c0 = $categories[0];
    $c1 = $categories[1];
    $c2 = $categories[2];
    $c3 = $categories[3];
    $c4 = $categories[4];
    $c5 = $categories[5];

    //Set price string values
    $v1 = ($f + 1) * 100;
    $v2 = ($f + 1) * 200;
    $v3 = ($f + 1) * 300;
    $v4 = ($f + 1) * 400;
    $v5 = ($f + 1) * 500;

    echo<<<_END
 <div id='display'>
    <table id='gameBoard'>
      <tr id='categories'>
        <td class='category'>$c0</td>

        <td class='category'>$c1</td>

        <td class='category'>$c2</td>

        <td class='category'>$c3</td>

        <td class='category'>$c4</td>

        <td class='category'>$c5</td>
      </tr>

      <tr id='100'>
        <td><input id='c0-1' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c1-1' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c2-1' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c3-1' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c4-1' class='boardButton' type='button' value='$v1' /></td>

        <td><input id='c5-1' class='boardButton' type='button' value='$v1' /></td>
      </tr>

      <tr id='200'>
        <td><input id='c0-2' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c1-2' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c2-2' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c3-2' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c4-2' class='boardButton' type='button' value='$v2' /></td>

        <td><input id='c5-2' class='boardButton' type='button' value='$v2' /></td>
      </tr>

      <tr id='300'>
        <td><input id='c0-3' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c1-3' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c2-3' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c3-3' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c4-3' class='boardButton' type='button' value='$v3' /></td>

        <td><input id='c5-3' class='boardButton' type='button' value='$v3' /></td>
      </tr>

      <tr id='400'>
        <td><input id='c0-4' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c1-4' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c2-4' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c3-4' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c4-4' class='boardButton' type='button' value='$v4' /></td>

        <td><input id='c5-4' class='boardButton' type='button' value='$v4' /></td>
      </tr>

      <tr id='500'>
        <td><input id='c0-5' class='boardButton' type='button' value='$v5' /></td>

        <td><input id='c1-5' class='boardButton' type='button' value='$v5' /></td>

        <td><input id='c2-5' class='boardButton' type='button' value='$v5' /></td>

        <td><input id='c3-5' class='boardButton' type='button' value='$v5' /></td>

        <td><input id='c4-5' class='boardButton' type='button' value='$v5' /></td>

        <td><input id='c5-5' class='boardButton' type='button' value='$v5' /></td>
      </tr>
    </table>
  </div>
_END;
    
    $scoreQuery = "SELECT score FROM users WHERE isAdmin=0";
$scoreResult = $db->query($scoreQuery);

//Fill in score data
$scoreResult->data_seek(0);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$caleb = $score[0];
$scoreResult->data_seek(1);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$sophia = $score[0];
$scoreResult->data_seek(2);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$bri = $score[0];
$scoreResult->data_seek(3);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$reilly = $score[0];
$scoreResult->data_seek(4);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$katie = $score[0];
$scoreResult->data_seek(5);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$abby = $score[0];
$scoreResult->data_seek(6);
$score = $scoreResult->fetch_array(MYSQLI_NUM);
$lilly = $score[0];


echo<<<_END
<div>
    <table id='scores'>
      <tr>
        <td class='competitor'>Caleb</td>

        <td class='competitor'>Sophia</td>

        <td class='competitor'>Bri</td>

        <td class='competitor'>Reilly</td>

        <td class='competitor'>Katie</td>

        <td class='competitor'>Abby</td>

        <td class='competitor'>Lilly</td>
      </tr>

      <tr>
        <td><input type='button' value='$caleb'></td>

        <td><input type='button' value='$sophia'></td>

        <td><input type='button' value='$bri'></td>

        <td><input type='button' value='$reilly'></td>

        <td><input type='button' value='$katie'></td>

        <td><input type='button' value='$abby'></td>

        <td><input type='button' value='$lilly'></td>
      </tr>
    </table>
  </div>
_END;
}
