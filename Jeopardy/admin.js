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

var finalJeopardyIndicator = "#comp2";

function checkStatus() {
    $.get("getStatus.php", function (statusString) {
        var status = $.parseJSON(statusString);
        if (status["status"] == "question") {
            $.get("getQA.php", function (qa) {
                var question = $.parseJSON(qa);
                $("#qDiv").html("Question: " + question["question"]);
                $("#aDiv").html("Answer: " + question["answer"]);
                if (status["buzzStatus"] == 0) {
                    setTimeout(function () {
                        $.ajax({
                            url: "/getBuzz.php",
                            dataType: "text",
                            success: function (buzzWinner) {

                                $("#comp" + buzzWinner).css("background-color", "green");
                            }
                        });
                    }, 500);
                } else if (status["buzzStatus"] < 0) {
                    for (a = 2; a < 9; a++) {
                        $("#comp" + a).css("background-color", "white");
                    }
                }
            })
        } else {
            $("#qDiv").html("Question: N/A");
            $("#aDiv").html("Answer: N/A");
            for (a = 2; a < 9; a++) {
                $("#comp" + a).css("background-color", "white");
            }
        }
        if (status["status"] == "finalJeopardy") {
            $(finalJeopardyIndicator).css("background-color", "green");
        }
    });
    $.ajax({
        url: "/getScore.php",
        dataType: "json",
        success: function (scores) {
            for (var a = 2; a < 9; a++) {
                $("#score" + a).attr("value", scores[a]);
            }
        }
    });
}

$(".boardButton").click(function () {
    var cat = $(this).attr("category");
    var val = this.value;
    $.get("getStatus.php", function (statusString) {
        var status = $.parseJSON(statusString);
        status["status"] = "question";
        status["category"] = cat;
        status["value"] = val;
        status["buzzStatus"] = -2;
        var postData = "data=" + JSON.stringify(status);
        console.log(postData);
        $.ajax({
            data: postData,
            url: "/postStatus.php",
            type: "POST",
            success: function () {

            }
        });
    });
});

$("#correct").click(function () {
    $.get("getStatus.php", function (statusString) {
        var status = $.parseJSON(statusString);
        if (status["status"] == "question" && status["buzzStatus"] == -2) {
            status["buzzStatus"] = -1;
            var postData = "data=" + JSON.stringify(status);
            console.log(postData)
            $.ajax({
                data: postData,
                url: "/postStatus.php",
                type: "POST",
                success: function () {

                }
            });
        } else if (status["status"] == "question" && status["buzzStatus"] > 1) {
            $.ajax({
                data: "correct=1",
                type: "POST",
                url: "postAnswer.php",
                success: function () {

                }
            });
        } else if (status["status"] == "finalJeopardy") {
            finalJeopardy(1);
        }
    });
});

$("#wrong").click(function () {
    $.get("getStatus.php", function (statusString) {
        var status = $.parseJSON(statusString);
        if (status["status"] == "question") {
            $.ajax({
                data: "correct=0",
                type: "POST",
                url: "postAnswer.php",
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
    var postData;
    postData["playerId"] = playerId;
    postData["isCorrect"] = isCorrect;
    $.ajax({
        data: postData,
        type: "POST",
        url: "postFinal.php",
        success: function () {

        }
    });
    $(finalJeopardyIndicator).css("background-color", "white");
    playerId++;
    finalJeopardyIndicator = "#comp" + playerId;
    $(finalJeopardyIndicator).css("background-color", "green");
}