<?php

/*
 * Copyright (C) 2019 allen
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

require_once "../privileges.php";

if ($isAdmin) {

    $db = new mysqli(host, username, passwd, dbname);

    $singleQuery = "SELECT category,hasBeenSelected FROM questions WHERE category<6 && hasBeenSelected=0";
    $singleResult = $db->query($singleQuery);

    $questions = null;

    if ($singleResult->num_rows > 0) {
        $f = 0;
        $questionQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category<6 ORDER BY category,value";
        $questionResult = $db->query($questionQuery);
    } else {
        $f = 1;
        $questionQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category>5 ORDER BY category,value";
        $questionResult = $db->query($questionQuery);
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

    //Initialize class array
    $class[][] = [];

    //Interate through values, and assign class accordingly
    $counter = 0;
    for ($a = 0; $a < 6; $a++) {
        for ($b = 0; $b < 5; $b++) {
            $questionResult->data_seek($counter);
            $question = $questionResult->fetch_array(MYSQLI_ASSOC);
            if ($question["hasBeenSelected"] == 1) {
                $class[$a][$b] = "selectedQuestion";
            } else {
                $class[$a][$b] = "unselectedQuestion";
            }
            $counter++;
        }
    }
    
        //Transfer values from array to values that can be used in quote
    $c0v0 = $class[0][0];
    $c0v1 = $class[0][1];
    $c0v2 = $class[0][2];
    $c0v3 = $class[0][3];
    $c0v4 = $class[0][4];
    $c1v0 = $class[1][0];
    $c1v1 = $class[1][1];
    $c1v2 = $class[1][2];
    $c1v3 = $class[1][3];
    $c1v4 = $class[1][4];
    $c2v0 = $class[2][0];
    $c2v1 = $class[2][1];
    $c2v2 = $class[2][2];
    $c2v3 = $class[2][3];
    $c2v4 = $class[2][4];
    $c3v0 = $class[3][0];
    $c3v1 = $class[3][1];
    $c3v2 = $class[3][2];
    $c3v3 = $class[3][3];
    $c3v4 = $class[3][4];
    $c4v0 = $class[4][0];
    $c4v1 = $class[4][1];
    $c4v2 = $class[4][2];
    $c4v3 = $class[4][3];
    $c4v4 = $class[4][4];
    $c5v0 = $class[5][0];
    $c5v1 = $class[5][1];
    $c5v2 = $class[5][2];
    $c5v3 = $class[5][3];
    $c5v4 = $class[5][4];

    echo<<<_END
    
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
        <td><input id='c0-0' category='$c0' class='$c0v0' type='button' value='$v0' /></td>

        <td><input id='c1-0' category='$c1' class='$c1v0' type='button' value='$v0' /></td>

        <td><input id='c2-0' category='$c2' class='$c2v0' type='button' value='$v0' /></td>

        <td><input id='c3-0' category='$c3' class='$c3v0' type='button' value='$v0' /></td>

        <td><input id='c4-0' category='$c4' class='$c4v0' type='button' value='$v0' /></td>

        <td><input id='c5-0' category='$c5' class='$c5v0' type='button' value='$v0' /></td>
      </tr>

      <tr id='200'>
        <td><input id='c0-1' category='$c0' class='$c0v1' type='button' value='$v1' /></td>

        <td><input id='c1-1' category='$c1' class='$c1v1' type='button' value='$v1' /></td>

        <td><input id='c2-1' category='$c2' class='$c2v1' type='button' value='$v1' /></td>

        <td><input id='c3-1' category='$c3' class='$c3v1' type='button' value='$v1' /></td>

        <td><input id='c4-1' category='$c4' class='$c4v1' type='button' value='$v1' /></td>

        <td><input id='c5-1' category='$c5' class='$c5v1' type='button' value='$v1' /></td>
      </tr>

      <tr id='300'>
        <td><input id='c0-2' category='$c0' class='$c0v2' type='button' value='$v2' /></td>

        <td><input id='c1-2' category='$c1' class='$c1v2' type='button' value='$v2' /></td>

        <td><input id='c2-2' category='$c2' class='$c2v2' type='button' value='$v2' /></td>

        <td><input id='c3-2' category='$c3' class='$c3v2' type='button' value='$v2' /></td>

        <td><input id='c4-2' category='$c4' class='$c4v2' type='button' value='$v2' /></td>

        <td><input id='c5-2' category='$c5' class='$c5v2' type='button' value='$v2' /></td>
      </tr>

      <tr id='400'>
        <td><input id='c0-3' category='$c0' class='$c0v3' type='button' value='$v3' /></td>

        <td><input id='c1-3' category='$c1' class='$c1v3' type='button' value='$v3' /></td>

        <td><input id='c2-3' category='$c2' class='$c2v3' type='button' value='$v3' /></td>

        <td><input id='c3-3' category='$c3' class='$c3v3' type='button' value='$v3' /></td>

        <td><input id='c4-3' category='$c4' class='$c4v3' type='button' value='$v3' /></td>

        <td><input id='c5-3' category='$c5' class='$c5v3' type='button' value='$v3' /></td>
      </tr>

      <tr id='500'>
        <td><input id='c0-4' category='$c0' class='$c0v4' type='button' value='$v4' /></td>

        <td><input id='c1-4' category='$c1' class='$c1v4' type='button' value='$v4' /></td>

        <td><input id='c2-4' category='$c2' class='$c2v4' type='button' value='$v4' /></td>

        <td><input id='c3-4' category='$c3' class='$c3v4' type='button' value='$v4' /></td>

        <td><input id='c4-4' category='$c4' class='$c4v4' type='button' value='$v4' /></td>

        <td><input id='c5-4' category='$c5' class='$c5v4' type='button' value='$v4' /></td>
      </tr>
    </table>
    <script src='./boardAdmin.js'></script>
_END;
}