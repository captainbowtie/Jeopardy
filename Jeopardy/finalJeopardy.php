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

echo "<div>FINAL JEOPARDY</div>\n<div>Expert Opinions</div>\n";

require_once "privileges.php";
$db = new mysqli(host, username, passwd, dbname);

$wageredQuery = "SELECT finalWager FROM users";
$wagerResult = $db->query($wageredQuery);

$allWagered = TRUE;

for ($a = 0; $a < $wagerResult->num_rows; $a++) {
    $wagerResult->data_seek($a);
    $wager = $wagerResult->fetch_array(MYSQLI_NUM);
    if ($wager[0] < 0) {
        $allWagered = FALSE;
    }
}

if($allWagered){
    echo "<div>These are the four prongs of 702</div>";
}