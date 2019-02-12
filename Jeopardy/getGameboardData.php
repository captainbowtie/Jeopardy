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

require_once "./privileges.php";

$db = new mysqli(host, username, passwd, dbname);

$singleQuery = "SELECT category,hasBeenSelected FROM questions WHERE category<6 && hasBeenSelected=0";
$singleResult = $db->query($singleQuery);

if ($singleResult->num_rows > 0) {
    $f = 0;
    $questionQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category<6 ORDER BY category,value";
} else {
    $f = 1;
    $questionQuery = "SELECT category,value,hasBeenSelected FROM questions WHERE category>5 ORDER BY category,value";
}

$questionResult = $db->query($questionQuery);

//Get category names
$categoryQuery = "SELECT category FROM categories WHERE isDouble=$f";
$categoriesResult = $db->query($categoryQuery);

//Initialize question array
$result = null;

//Set price string values
$v0 = ($f + 1) * 100;
$v1 = ($f + 1) * 200;
$v2 = ($f + 1) * 300;
$v3 = ($f + 1) * 400;
$v4 = ($f + 1) * 500;

$counter = 0;
for ($a = 0; $a < 6; $a++) {
    $categoriesResult->data_seek($a);
    $cg = $categoriesResult->fetch_array(MYSQLI_NUM);
    $result["categories"][$a]["name"] = $cg[0];
    for ($b = 0; $b < 5; $b++) {
        $questionResult->data_seek($counter);
        $question = $questionResult->fetch_array(MYSQLI_ASSOC);
        $result["questions"][$a][$b]["value"] = ($f + 1) * 100 * ($b + 1);
        if ($question["hasBeenSelected"] == 1) {
            $result["questions"][$a][$b]["selected"] = 1;
        } else {
            $result["questions"][$a][$b]["selected"] = 0;
        }
        $counter++;
    }
}
echo json_encode($result);
