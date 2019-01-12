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

require_once "privileges.php";

function createTables() {
    $db = new mysqli(host, username, passwd, dbname);

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
            . "score MEDIUMINT SIGNED NOT NULL DEFAULT '0') ENGINE InnoDB";

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
}
