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

require_once "privileges.php";
$db = new mysqli(host, username, passwd, dbname);

$singleQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category<7 && hasBeenSelected=0";
$singleResult = $db->query($singleQuery);

if ($singleResult->num_rows > 0) { //Single jeopardy questions still exist
    fillRows(0);
} else {//Single jeopardy questions all gone, see if double jeopardy ones still exist
    $doubleQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category>6 && hasBeenSelected=0";
    $doubleResult = $db->query($doubleQuery);
    if ($doubleResult->num_rows > 0) { //Double jeopardy questions still exist
        fillRows(1); //So fill rows with thsoe questions
    }
}

function fillRows($f) {
    $db = new mysqli(host, username, passwd, dbname);

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

    //Get questions from db
    if ($f == 0) {
        $questionQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category<7";
        $questionResult = $db->query($questionQuery);
    } else {
        $questionQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category>6";
        $questionResult = $db->query($questionQuery);
    }

    //Initialize class array
    $class[][] = [];

    //Interate through values, and assign class accordingly
    $counter = 0;
    for ($a = 0; $a < 6; $a++) {
        for ($b = 1; $b <= 5; $b++) {
            $questionResult->data_seek($counter);
            $question = $questionResult->fetch_array(MYSQLI_ASSOC);
            $q = $question["hasBeenSelected"];
            if ($question["hasBeenSelected"] == 1) {
                $class[$a][$b] = "selected";
            } else {
                $class[$a][$b] = "unselected";
            }
            $counter++;
        }
    }

    //Transfer values from array to values that can be used in quote
    $c0v1 = $class[0][1];
    $c0v2 = $class[0][2];
    $c0v3 = $class[0][3];
    $c0v4 = $class[0][4];
    $c0v5 = $class[0][5];
    $c1v1 = $class[1][1];
    $c1v2 = $class[1][2];
    $c1v3 = $class[1][3];
    $c1v4 = $class[1][4];
    $c1v5 = $class[1][5];
    $c2v1 = $class[2][1];
    $c2v2 = $class[2][2];
    $c2v3 = $class[2][3];
    $c2v4 = $class[2][4];
    $c2v5 = $class[2][5];
    $c3v1 = $class[3][1];
    $c3v2 = $class[3][2];
    $c3v3 = $class[3][3];
    $c3v4 = $class[3][4];
    $c3v5 = $class[3][5];
    $c4v1 = $class[4][1];
    $c4v2 = $class[4][2];
    $c4v3 = $class[4][3];
    $c4v4 = $class[4][4];
    $c4v5 = $class[4][5];
    $c5v1 = $class[5][1];
    $c5v2 = $class[5][2];
    $c5v3 = $class[5][3];
    $c5v4 = $class[5][4];
    $c5v5 = $class[5][5];



    echo<<<_END
<table  id='gameBoard'>
<tr id='categories'>
<td class='category'>$c0</td>
<td class='category'>$c1</td>
<td class='category'>$c2</td>
<td class='category'>$c3</td>
<td class='category'>$c4</td>
<td class='category'>$c5</td>
</tr>
<tr id='100'>
<td id='c0-1' class='$c0v1'>$v1</td>
<td id='c1-1' class='$c1v1'>$v1</td>
<td id='c2-1' class='$c2v1'>$v1</td>
<td id='c3-1' class='$c3v1'>$v1</td>
<td id='c4-1' class='$c4v1'>$v1</td>
<td id='c5-1' class='$c5v1'>$v1</td>
</tr>
<tr id='200'>
<td id='c0-2' class='$c0v2'>$v2</td>
<td id='c1-2' class='$c1v2'>$v2</td>
<td id='c2-2' class='$c2v2'>$v2</td>
<td id='c3-2' class='$c3v2'>$v2</td>
<td id='c4-2' class='$c4v2'>$v2</td>
<td id='c5-2' class='$c5v2'>$v2</td>
</tr>
<tr id='300'>
<td id='c0-3' class='$c0v3'>$v3</td>
<td id='c1-3' class='$c1v3'>$v3</td>
<td id='c2-3' class='$c2v3'>$v3</td>
<td id='c3-3' class='$c3v3'>$v3</td>
<td id='c4-3' class='$c4v3'>$v3</td>
<td id='c5-3' class='$c5v3'>$v3</td>
</tr>
<tr id='400'>
<td id='c0-4' class='$c0v4'>$v4</td>
<td id='c1-4' class='$c1v4'>$v4</td>
<td id='c2-4' class='$c2v4'>$v4</td>
<td id='c3-4' class='$c3v4'>$v4</td>
<td id='c4-4' class='$c4v4'>$v4</td>
<td id='c5-4' class='$c5v4'>$v4</td>
</tr>
<tr id='500'>
<td id='c0-5' class='$c0v5'>$v5</td>
<td id='c1-5' class='$c1v5'>$v5</td>
<td id='c2-5' class='$c2v5'>$v5</td>
<td id='c3-5' class='$c3v5'>$v5</td>
<td id='c4-5' class='$c4v5'>$v5</td>
<td id='c5-5' class='$c5v5'>$v5</td>
</tr>
		</table>

_END;
}
