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

setInterval(function () {
    $.ajax({
        url: "/status.json",
        dataType: "json",
        success: function (data) {
            if (data["buzzStatus"] == -1) {
                setTimeout(five, 1000);
                setTimeout(four, 2000);
                setTimeout(three, 3000);
                setTimeout(two, 4000);
                setTimeout(one, 5000);
            } else {
                $(".five").css("color", "white");
                $(".four").css("color", "white");
                $(".three").css("color", "white");
                $(".two").css("color", "white");
                $(".one").css("color", "white");
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
    $(".one").css("color", "red");
    //Disable buzzing after timer has expired
    $.getJSON("status.json", function (status) {
        status["buzzStatus"] = "-3";
        var postData = "data=" + JSON.stringify(status);
        console.log(postData)
        $.ajax({
            data: postData,
            url: "/postStatus.php",
            type: "POST",
            success: function () {

            }
        });
    });
}