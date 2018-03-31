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

echo<<<_END

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src='jquery-3.3.1.min.js'></script>
	<script src='display.js'></script>
<link rel="Stylesheet" href="display.css" type="text/css" />
    </head>
    <body>
    	<div id='displayDiv' content='gameboard'>
_END;
require_once 'gameboard.php';
echo<<<_END
    	</div>
<div id='scoresDiv'>
_END;
//TODO: absolute position scores to stay on bottom
require_once 'scores.php';
echo<<<_END
</div>
    </body>
</html>

_END;
