<?php

/*
 * Copyright (C) 2023 allen
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

// Get config information
require_once __DIR__ . "/../config.php";
require_once SITE_ROOT . "/database.php";

$sql = "CREATE TABLE gameState (
	display VARCHAR(10) NOT NULL,
	qCategory TINYINT UNSIGNED NOT NULL,
	qValue TINYINT UNSIGNED NOT NULL,
	buzz TINYINT SIGNED NOT NULL,
	finalC VARCHAR(256) NOT NULL,
	finalQ VARCHAR(256) NOT NULL,
	finalA VARCHAR (256) NOT NULL
)";

$createTable = $db->exec($sql);

/*Codes for buzz:
	-2 time has expired
	-1 buzzing disabled
	0 buzzing enabled
	1+ playerID of person that buzzed in
	*/
