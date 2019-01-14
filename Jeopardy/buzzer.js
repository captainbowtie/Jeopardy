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
    if ($("#buzzer").attr("value") == "Buzz In") {
        //Post buzz-in
        var postData = "b=1";
        $.ajax({
            data: postData,
            url: "/postBuzz.php",
            type: "POST",
            success: function () {
        //color button red for 1.5 seconds
        $("#buzzer").css("background-color", "red");
        $("#buzzer").prop("disabled",true);
        var buttonColorTimer = setTimeout(function () {
            $("#buzzer").css("background-color", "green");
            $("#buzzer").prop("disabled",false);
        }, 800);
            }
        });
        
    }else{
        //Post bid
        var postData = "wager=" + $("#bid").val();
        $.ajax({
            data: postData,
            url: "/postWager.php",
            type: "POST",
            success: function () {
                $("#bid").val("");
                $("#buzzer").attr("value", "Buzz In");
            }
        });
    }


});

$('#bid').on('input', function (e) {
    if ($('#bid').val() != "") {
        $("#buzzer").attr("value", "Submit");
    } else {
        $("#buzzer").attr("value", "Buzz In");
    }

});
