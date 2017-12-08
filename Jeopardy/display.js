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

$(document).ready(function () {













});



//Timers to update gameboard and scores

var gbr = setInterval(gameBoardRefresh, 500);

var sr = setInterval(scoreRefresh, 500);



function gameBoardRefresh() {

//AJAX to set values of game board

    $.ajax({
        url: "/status.json",
        dataType: "json",
        success: function (data) {
            switch (data["status"]) {
                case "gameboard":
                    $.ajax({
                        url: "/gameboard.php",
                        dataType: "html",
                        success: function (gbData) {
                            $("#displayDiv").html(gbData);
                        }
                    });
                    break;
                case "question":
                    
                    $.ajax({ //TODO: get particular question
                        url: "/question.php",
                        dataType: "json",
                        success: function (question) {
                            $("#displayDiv").html(gbData);
                        }
                    });
                    break;
            }
        }

    });

}



function scoreRefresh() {

//AJAX to set values of scores

    $.ajax({
        url: "/scores.php",
        dataType: "html",
        success: function (data) {
            $("#scoresDiv").html(data);
        }
    });

}