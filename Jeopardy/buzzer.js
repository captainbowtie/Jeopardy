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


setInterval(updateScore, 1000);

$(".idButton").click(function () {
    var postData = "studentLoginId=" + $(this).attr("id").substring(1);
    console.log(postData);
    $.ajax({
        data: postData,
        url: "/postLogin.php",
        type: "POST",
        success: function () {
            location.reload();
        }
    });
});


$("#buzzer").click(function () {
    //Post buzz-in time
    var date = new Date();
    var time = date.getTime() /*- 1515386389999*/;
    var postData = "time=" + time;
    console.log(postData);
    $.ajax({
        data: postData,
        url: "/postBuzz.php",
        type: "POST",
        success: function () {

        }
    });

    //color button red for 1.5 seconds
    $("#buzzer").css("background-color", "red");
    var buttonColorTimer = setTimeout(function () {
        $("#buzzer").css("background-color", "green");
    }, 1500);

});

function updateScore() {

    $.ajax({
        url: "/getScore.php",
        dataType: "text",
        success: function (data) {
            $("#money").html(data);
        }
    });
}
