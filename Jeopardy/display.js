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

setInterval(gameBoardRefresh, 500);

setInterval(scoreRefresh, 500);

function gameBoardRefresh() {

//AJAX to set values of game board

    $.ajax({
        url: "/status.json",
        dataType: "json",
        success: function (status) {
            switch (status["status"]) {
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
                    if ($("#displayDiv").attr("content") == "gameboard") {
                        $.ajax({
                            url: "/question.php",
                            dataType: "html",
                            success: function (question) {
                                $("#displayDiv").html(question);
                                $("#displayDiv").attr("content", "question");
                            }
                        });
                        break;
                    } else if (status["buzzStatus"] > 0) {
                        
                    }
            }
            if(status["buzzStatus"]>0){
                $("#comp"+status["buzzStatus"]).css("background-color","white");
            }else{
                for(var a = 2;a<9;a++){
                    $("#comp"+a).css("background-color","tan");
                }
            }
            
        }
    });
}

function scoreRefresh() {

//AJAX to set values of scores
    $.ajax({
        url: "/getScore.php",
        dataType: "json",
        success: function (scores) {
            for(var a = 2;a<9;a++){
                $("#score"+a).html(scores[a]);
            }
        }
    });

}