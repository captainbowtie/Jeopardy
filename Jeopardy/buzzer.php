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

echo<<<_END
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
<link rel="Stylesheet" href="buzzer.css" type="text/css" />
    </head>
    <body>
<div id="name">
  Name
</div>
<div id="money">
  Money
</div>
<div id="buzzerDiv">
  <input id="buzzer" type="button" value="Buzz In">
</div>

<div>
<input id="bid" type="number">
</div>
</body>
</html>
_END;
