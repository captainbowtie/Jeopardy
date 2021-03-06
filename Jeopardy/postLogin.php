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
require_once "functions.php";

if (isset($_POST['name']) && isset($_POST['pass'])) {
    $name = sanitize_string($_POST['name']);
    $password = sanitize_string($_POST['pass']);
    $hashedPass = hash('whirlpool', $password);
    $loginQuery = "SELECT id FROM users WHERE "
            . "name='$name' && password='$hashedPass'";
    $connection = new mysqli(host, username, passwd, dbname);
    $result = $connection->query($loginQuery);
    $connection->close();
    if ($result->num_rows == 0) {
        echo "1";
    } else {
        $result->data_seek(0);
        $idRow = $result->fetch_array(MYSQLI_ASSOC);
        $_SESSION['id'] = $idRow['id'];
        echo "0";
    }
} else if (isset($_POST["studentLoginId"]) && $_POST["studentLoginId"] != 1) {
    $_SESSION['id'] = $_POST["studentLoginId"];
}