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

echo "<!DOCTYPE html>\n";
echo "<html lang='en'>\n";
echo "<head>\n";
echo "<title>Jeopardy: Gameboard</title>\n";
echo "</head>\n";
echo "<body>\n";

//Question Select Table
echo "<div>\n";
echo "<table>\n";
echo "<tr>\n";
echo "<td id='0.0'></td>\n";
echo "<td id='0.1'></td>\n";
echo "<td id='0.2'></td>\n";
echo "<td id='0.3'></td>\n";
echo "<td id='0.4'></td>\n";
echo "<td id='0.5'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td id='1.0'></td>\n";
echo "<td id='1.1'></td>\n";
echo "<td id='1.2'></td>\n";
echo "<td id='1.3'></td>\n";
echo "<td id='1.4'></td>\n";
echo "<td id='1.5'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td id='2.0'></td>\n";
echo "<td id='2.1'></td>\n";
echo "<td id='2.2'></td>\n";
echo "<td id='2.3'></td>\n";
echo "<td id='2.4'></td>\n";
echo "<td id='2.5'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td id='3.0'></td>\n";
echo "<td id='3.1'></td>\n";
echo "<td id='3.2'></td>\n";
echo "<td id='3.3'></td>\n";
echo "<td id='3.4'></td>\n";
echo "<td id='3.5'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td id='4.0'></td>\n";
echo "<td id='4.1'></td>\n";
echo "<td id='4.2'></td>\n";
echo "<td id='4.3'></td>\n";
echo "<td id='4.4'></td>\n";
echo "<td id='4.5'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td id='5.0'></td>\n";
echo "<td id='5.1'></td>\n";
echo "<td id='5.2'></td>\n";
echo "<td id='5.3'></td>\n";
echo "<td id='5.4'></td>\n";
echo "<td id='5.5'></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</div>\n";

//Score Display
echo "<div id='scoreDisplay'></div>";

echo "<script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>";
echo "<script src='gameboard.js'></script>";
echo "</body>\n";
echo "</html>\n";

