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

var numberOfPlayers = 3;

$.get("../getNumberPlayers.php", function (number) {
    numberOfPlayers = number;
});

setInterval(updateScores, 1000);

function updateScores() {
    $.ajax({
        url: "../getScore.php",
        dataType: "json",
        success: function (scores) {
            for (var a = 0; a < numberOfPlayers; a++) {
                $("#score" + (a + 2)).attr("value", scores[a + 2]);
            }
        }
    });
}

$(".scoreButton").click(function () {
    var playerName = $("#comp" + this.id.substring(5)).html();
    var newScore = prompt("Change " + playerName + "'s score to:", this.value);
    if (newScore !== null) {
        var postData = "playerId=" + this.id.substring(5) + "&score=" + newScore;
        $.ajax({
            data: postData,
            type: "POST",
            url: "./postScore.php",
            success: function () {

            }
        });
    }
});