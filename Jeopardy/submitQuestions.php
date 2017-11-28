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


echo "<!DOCTYPE html>\n";
echo "<html lang='en'>\n";
echo "<head>\n";
echo "<title>Jeopardy: Admin</title>\n";
echo "<script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>";
echo "</head>\n";
echo "<body>\n";
if($isAdmin){
    echo "<form id='questions'>\n";
    echo "<textarea>";
    echo<<<_END
    //There are six categories in each round
//Each category should begin with "==="
//There are five questions in each category
//Answers should be on the same line as the question, and be separated by " • "
//Indicate a daily double by starting the line with a dollar sign "$", see, e.g. category 2, question 3
//Final jeopardy should be set-off with "===", then the category on one line, then the question and answer on the third line
===Category 1 Name
Example 100 dollar question • Example answer
Example 200 dollar question • Example answer
Example 300 dollar question • Example answer
Example 400 dollar question • Example answer
Example 500 dollar question • Example answer
===Category 2 Name
Example 100 dollar question • Example answer
Example 200 dollar question • Example answer
$Example 300 dollar question • Example answer
Example 400 dollar question • Example answer
Example 500 dollar question • Example answer
===Category 3 Name
Example 100 dollar question • Example answer
Example 200 dollar question • Example answer
Example 300 dollar question • Example answer
Example 400 dollar question • Example answer
Example 500 dollar question • Example answer
===Category 4 Name
Example 100 dollar question • Example answer
Example 200 dollar question • Example answer
Example 300 dollar question • Example answer
Example 400 dollar question • Example answer
Example 500 dollar question • Example answer
===Category 5 Name
Example 100 dollar question • Example answer
Example 200 dollar question • Example answer
Example 300 dollar question • Example answer
Example 400 dollar question • Example answer
Example 500 dollar question • Example answer
===Category 6 Name
Example 100 dollar question • Example answer
Example 200 dollar question • Example answer
Example 300 dollar question • Example answer
Example 400 dollar question • Example answer
Example 500 dollar question • Example answer
===Double Category 1 Name
Example 200 dollar question • Example answer
Example 400 dollar question • Example answer
Example 600 dollar question • Example answer
Example 800 dollar question • Example answer
Example 1000 dollar question • Example answer
===Double Category 2 Name
Example 200 dollar question • Example answer
Example 400 dollar question • Example answer
Example 600 dollar question • Example answer
Example 800 dollar question • Example answer
Example 1000 dollar question • Example answer
===Double Category 3 Name
Example 200 dollar question • Example answer
Example 400 dollar question • Example answer
Example 600 dollar question • Example answer
Example 800 dollar question • Example answer
Example 1000 dollar question • Example answer
===Double Category 4 Name
Example 200 dollar question • Example answer
Example 400 dollar question • Example answer
Example 600 dollar question • Example answer
Example 800 dollar question • Example answer
Example 1000 dollar question • Example answer
===Double Category 5 Name
Example 200 dollar question • Example answer
Example 400 dollar question • Example answer
Example 600 dollar question • Example answer
Example 800 dollar question • Example answer
Example 1000 dollar question • Example answer
===Double Category 6 Name
Example 200 dollar question • Example answer
Example 400 dollar question • Example answer
Example 600 dollar question • Example answer
Example 800 dollar question • Example answer
Example 1000 dollar question • Example answer
===FINAL JEOPARDY
Example final jeopardy category
Example final jeopardy question • example answer
_END;
    echo "</textarea>\n";
    echo "<input type='submit' value='submit'>\n";
    echo "</form>\n";
}else{
    echo "You must be logged in to view this page\n";
    require_once "login.php";
}
echo "</body>\n";
echo "</html>\n";