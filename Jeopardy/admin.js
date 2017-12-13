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

function checkStatus() {
    $.getJSON("status.json", function (status) {
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
        }
    });
}

$(".boardButton").click(function () {
    var category = this.id.substring(1, 2);
    var val = this.value;
    var postData = 'data={"status":"question","category":' + category + ',"value":' + val + ',"buzzStatus":-2,"wager":5}';
    $.ajax({
        data: postData,
        url: "/postStatus.php",
        type: "POST",
        success: function () {

        }
    });
});

$("#correct").click(function () {
    $.getJSON("status.json", function (status) {
        if (status["buzzStatus"] == -2) {
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
        } else {
            $.ajax({
                data: "correct=1",
                type: "POST",
                url: "postAnswer.php",
                success: function () {

                }
            });
        }
    });
});

$("#wrong").click(function () {
    $.ajax({
        data: "correct=0",
        type: "POST",
        url: "postAnswer.php",
        success: function () {

        }
    });
});