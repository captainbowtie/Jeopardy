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

var timerStarted = 0;
var time1 = null;
var time2 = null;
var time3 = null;
var time4 = null;
var time5 = null;

setInterval(function () {
    $.ajax({
        url: "/status.json",
        dataType: "json",
        success: function (data) {
            console.log(data["buzzStatus"]);
            if (data["buzzStatus"] == -1 && timerStarted == 0) {
                console.log("timerstart");
                timerStarted = 1;
                time5 = setTimeout(five, 1000);
                time4 = setTimeout(four, 2000);
                time3 = setTimeout(three, 3000);
                time2 = setTimeout(two, 4000);
                time1 = setTimeout(one, 5000);
            } else if (timerStarted == 1 && data["buzzStatus"] > -1) {
                console.log("timerstop");
                clearTimeout(time1);
                clearTimeout(time2);
                clearTimeout(time3);
                clearTimeout(time4);
                clearTimeout(time5);
                $(".five").css("color", "white");
                $(".four").css("color", "white");
                $(".three").css("color", "white");
                $(".two").css("color", "white");
                $(".one").css("color", "white");
                timerStarted = 0;
            }
        }
    });
}, 500);

function five() {
    $(".five").css("color", "red");
}

function four() {
    $(".four").css("color", "red");
}

function three() {
    $(".three").css("color", "red");
}

function two() {
    $(".two").css("color", "red");
}

function one() {
    console.log("one");
    $(".one").css("color", "red");
    timerStarted = 0;
    //Disable buzzing after timer has expired
    $.getJSON("status.json", function (status) {
        status["buzzStatus"] = "-3";
        var postData = "data=" + JSON.stringify(status);
        $.ajax({
            data: postData,
            url: "/postStatus.php",
            type: "POST",
            success: function () {

            }
        });
    });
}