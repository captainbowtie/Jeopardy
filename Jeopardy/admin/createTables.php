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

function createTables() {
    $db = new mysqli(host, username, passwd, dbname);

    //Drop any existing tables
    $db->query("DROP TABLE categories");
    $db->query("DROP TABLE questions");
    $db->query("DROP TABLE users");
    $db->query("DROP TABLE status");
    $db->query("DROP TABLE buzzes");


    //Create querys to add tables
    $categoryTable = "CREATE TABLE categories("
            . "id TINYINT UNSIGNED NOT NULL KEY, "
            . "category VARCHAR(64) NOT NULL, "
            . "isDouble BINARY(1) NOT NULL DEFAULT '0') "
            . "ENGINE InnoDB";
    $questionTable = "CREATE TABLE questions("
            . "id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT KEY, "
            . "category TINYINT UNSIGNED NOT NULL, "
            . "question VARCHAR(500) NOT NULL, "
            . "answer VARCHAR(500) NOT NULL, "
            . "value SMALLINT UNSIGNED NOT NULL, "
            . "isDailyDouble BINARY(1) NOT NULL DEFAULT '0', "
            . "hasBeenSelected BINARY(1) NOT NULL DEFAULT '0'"
            . ") ENGINE InnoDB";
    $userTable = "CREATE TABLE users("
            . "id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT KEY, "
            . "name VARCHAR(64) NOT NULL DEFAULT 'Missing Name', "
            . "password CHAR(128) NOT NULL, "
            . "isAdmin BINARY(1) NOT NULL DEFAULT '0', "
            . "score MEDIUMINT SIGNED NOT NULL DEFAULT '0', "
            . "finalWager MEDIUMINT SIGNED NOT NULL DEFAULT '-1') "
            . "ENGINE InnoDB";
    $buzzTable = "CREATE TABLE buzzes("
            . "id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT KEY, "
            . "time BIGINT UNSIGNED NOT NULL DEFAULT '0', "
            . "answered BINARY(1) NOT NULL DEFAULT '0') "
            . "ENGINE InnoDB";
    $statusTable = "CREATE TABLE status("
            . "id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT KEY, "
            . "display VARCHAR(16) NOT NULL DEFAULT 'gameboard', "
            . "category TINYINT UNSIGNED NOT NULL DEFAULT '1', "
            . "value SMALLINT UNSIGNED NOT NULL DEFAULT '100', "
            . "buzzStatus TINYINT SIGNED NOT NULL DEFAULT '-2', "
            . "dailyDoublePlayer TINYINT UNSIGNED NOT NULL DEFAULT '2', "
            . "dailyDoubleWager SMALLINT UNSIGNED NOT NULL DEFAULT '0') "
            . "ENGINE InnoDB";

    //Submit queries to create tables
    $db->query($categoryTable);
    $db->query($questionTable);
    $db->query($userTable);
    $db->query($buzzTable);
    $db->query($statusTable);

    //Populate admin user into table
    $generateAdmin = "INSERT INTO users(name, password, isAdmin) "
            . "VALUES('allen', "
            . "'3a529b6b94cc39b76acb3284f2aced744a5e798bd84bb72a3b5879175ecdf021bd53b801add327f94480ca74b3cb7b50943a3ba85f07c672ba5778bf6732d05d', " //Whirlpool hash for 'mock'
            . "'1')";
    $db->query($generateAdmin);

    //Populate status into table
    $generateStatus = "INSERT INTO status(display,category,value,buzzStatus,dailyDoublePlayer,dailyDoubleWager) "
            . "VALUES("
            . "'gameboard', "
            . "0, "
            . "100, "
            . "1, "
            . "2, "
            . "-1)";

    $db->query($generateStatus);
}
