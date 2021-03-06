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

setInterval(checkStatus, 1000);

var numberOfPlayers = 3;

var finalJeopardyIndicator = "#comp2";

$(document).ready(function () {

    $.get("../getNumberPlayers.php", function (number) {
        numberOfPlayers = number;
    });

    $("#score").load("./scoreAdmin.php");
    $("#board").load("./boardAdmin.php");

});

function checkStatus() {
    $.get("../getStatus.php", function (statusString) {
        var status = $.parseJSON(statusString);

        switch (status["status"]) {
            case "gameboard":
                $("#qDiv").html("Question: N/A");
                $("#aDiv").html("Answer: N/A");
                for (a = 0; a < numberOfPlayers; a++) {
                    $("#comp" + (a + 2)).css("background-color", "white");
                }
                break;
            case "question":
                $.get("./getQA.php", function (qa) {
                    var question = $.parseJSON(qa);
                    $("#qDiv").html("Question: " + question["question"]);
                    $("#aDiv").html("Answer: " + question["answer"]);
                    if (status["buzzStatus"] == 0) {
                        //setTimeout(function () {  Not sure why this was set on a timer loop
                        //Commented out loop on theory it's not needed
                        //If stuff gets broken, then uncomment
                        $.ajax({
                            url: "./getBuzz.php",
                            dataType: "text",
                            success: function (buzzWinner) {

                                $("#comp" + buzzWinner).css("background-color", "green");
                            }
                        });
                        //}, 500);  Uncomment this too
                    } else if (status["buzzStatus"] < 0) {
                        for (a = 0; a < numberOfPlayers; a++) {
                            $("#comp" + (a + 2)).css("background-color", "white");
                        }
                    }
                });
                break;
            case "finalJeopardy":
                $(finalJeopardyIndicator).css("background-color", "green");
                break;
        }
    });

}

$("#correct").click(function () {
    $.get("../getStatus.php", function (statusString) {
        var status = $.parseJSON(statusString);
        //If status is -2 (buzzing in disabled) and there's a question displayed
        //Then enable buzzing in
        if (status["status"] == "question" && status["buzzStatus"] == -2) {
            status["buzzStatus"] = -1;
            var postData = "data=" + JSON.stringify(status);
            $.ajax({
                data: postData,
                url: "../postStatus.php",
                type: "POST",
                success: function () {

                }
            });
            //If status is greater than 1 (someone buzzed in) and there's a question
            //Displayed, then indicate the person that buzzed in answered correctly
        } else if (status["status"] == "question" && status["buzzStatus"] > 1) {
            $.ajax({
                data: "correct=1",
                type: "POST",
                url: "./postAnswer.php",
                success: function () {

                }
            });
            //Time was expired when the correct button was hit
        } else if (status["status"] == "question" && status["buzzStatus"] == -3) {
            $.ajax({
                data: "correct=-1",
                type: "POST",
                url: "./postAnswer.php",
                success: function () {

                }
            });
            //If status is final jeopardy, then indicate the highlighted person
            //Answered correctly
        } else if (status["status"] == "finalJeopardy") {
            finalJeopardy(1);
        }
    });
});

$("#wrong").click(function () {
    $.get("../getStatus.php", function (statusString) {
        var status = $.parseJSON(statusString);
        if (status["status"] == "question") {
            $.ajax({
                data: "correct=0",
                type: "POST",
                url: "./postAnswer.php",
                success: function () {

                }
            });
        } else if (status["status"] == "finalJeopardy") {
            finalJeopardy(0);
        }
    });

});

function finalJeopardy(isCorrect) {
    var playerId = finalJeopardyIndicator.substring(5);
    var postData = "playerId=" + playerId + "&isCorrect=" + isCorrect;
    postData["playerId"] = playerId;
    postData["isCorrect"] = isCorrect;
    $.ajax({
        data: postData,
        type: "POST",
        url: "./postFinal.php",
        success: function () {

        }
    });
    $(finalJeopardyIndicator).css("background-color", "white");
    playerId++;
    finalJeopardyIndicator = "#comp" + playerId;
    $(finalJeopardyIndicator).css("background-color", "green");
}

