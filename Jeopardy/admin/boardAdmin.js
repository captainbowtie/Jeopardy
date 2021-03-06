/* 
 * Copyright (C) 2019 allen
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

setInterval(getBoardData, 1000);

$(".unselectedQuestion").click(function () {
    var cat = $(this).attr("category");
    var val = this.value;
    $.get("../getStatus.php", function (statusString) {
        var status = $.parseJSON(statusString);
        status["status"] = "question";
        status["category"] = cat;
        status["value"] = val;
        status["buzzStatus"] = -2;
        var postData = "data=" + JSON.stringify(status);
        $.ajax({
            data: postData,
            url: "../postStatus.php",
            type: "POST",
            success: function () {

            }
        });
    });
});

function getBoardData() {
    $.ajax({
        url: "../getGameboardData.php",
        dataType: "json",
        success: function (json) {
            for (var a = 0; a < 6; a++) {
                $("#c" + a).html(json.categories[a].name);
                for (var b = 0; b < 5; b++) {
                    var t = "#c" + a + "-" + b;
                    $("#c" + a + "-" + b).attr("value", json.questions[a][b].value);
                    if(json.questions[a][b].selected === 1){
                        $("#c" + a + "-" + b).css("color", "red");
                        $("#c" + a + "-" + b).prop("disabled",true);
                    }else{
                        $("#c" + a + "-" + b).css("color", "black");
                        $("#c" + a + "-" + b).prop("disabled",false);
                    }
                }
            }
        }
    });
}