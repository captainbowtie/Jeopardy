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

// sql to create table
$sql = "CREATE TABLE users (
		id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(12) NOT NULL,
		score MEDIUMINT SIGNED NOT NULL,
		buzzed BOOLEAN NOT NULL,
		wager MEDIUMINT UNSIGNED NOT NULL,
		answer VARCHAR (64) NOT NULL
	)";
