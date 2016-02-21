var finalize = function () {
    if (!game.end) {
        $("#submitButton").click(function () {
            $('#main').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
            $.ajax(
                    {
                        method: "POST",
                        url: "Ajax/finish.php?ID=" + id,
                        data: {
                            name: playerName,
                        },
                        datatype: "json",
                        success: function (result) {
                            $('#main').waitMe("hide");
                            if (result == "S") {
                                $("#main").html("You cannot change because you have click finish button.");
                            } else {
                                $("#finishText").html("Server Error! (Error:" + result + ")");
                            }
                        },
                        fail: function (error) {
                            $('#main').waitMe("hide");
                            $("#finishText").html("Server Error (Error:" + error + ")");
                        },
                    }
            );
        });
    } else {
        $("#submitButton").addClass("hidden");
    }

};
var findseat = function () {
    $('#EnterNameDialog').modal('hide');
    $('#ChooseSeatDialog').modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#ChooseSeatDialog').modal('show');
    var context = $("#readgamecanvas")[0].getContext("2d");
    for (var i = 0; i < game.player.length; i++) {
        var x = 50 + i * 100;
        context.beginPath();
        context.moveTo(x, 0);
        context.lineTo(x, 500);
        context.stroke();
        context.beginPath();
        $("#seat" + i).html('<button onClick="setseat(' + i + ')" type="button" class="btn btn-primary expand-right ladda" data-style="expand-right"><span class="ladda-label">Seat ' + i + '</span></button>');
    }
    var context = $("#readgamecanvas")[0].getContext("2d");
    for (var i = 0; i < game.player.length; i++) {
        var x = 50 + i * 100;
        context.beginPath();
        context.moveTo(x, 0);
        context.lineTo(x, 500);
        context.stroke();
        for (var i = 0; i < game.player.length; i++) {
            if (game.player[i].seat !== null) {
                $("#seat" + game.player[i].seat).html(game.player[i].name);
            }
        }
    }
}
var setseat = function (seat) {
    if (playerName !== null) {
        $('#ChooseSeatDialogFace').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
        $.ajax(
                {
                    method: "POST",
                    url: "Ajax/setseat.php?ID=" + id,
                    data: {
                        seat: seat,
                        name: playerName,
                    },
                    datatype: "json",
                    success: function (result) {
                        $('#ChooseSeatDialogFace').waitMe("hide");
                        if (result == "S") {
                            $('#ChooseSeatDialog').modal('hide');
                            finalize();
                        } else {
                            $("#seaterrortext").html("Server Error! (Error:" + result + ")");
                        }
                    },
                    fail: function (error) {
                        $('#ChooseSeatDialogFace').waitMe("hide");
                        $("#seaterrortext").html("Server Error (Error:" + error + ")");
                    },
                }
        );
    }
};
var newplayer = function () {
    $('#EnterNameDialog').modal({
        backdrop: 'static',
        keyboard: false
    })
    $('#EnterNameDialog').modal('show');
    $('#enterNameButton').click(function () {
        $('#EnterNameDialogFace').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
        $.ajax(
                {
                    method: "POST",
                    url: "Ajax/addname.php?ID=" + id,
                    data: {
                        name: $("#name").val(),
                        email: $("#email").val(),
                    },
                    datatype: "json",
                    success: function (jsonresult) {
                        $('#EnterNameDialogFace').waitMe("hide");
                        var result = JSON.parse(jsonresult);
                        if (result.success) {
                            playerName = $("#name").val();
                            $('#EnterNameDialog').modal('hide');
                            $("#main").removeClass("hidden");
                            if (game.end) {
                                $("#gameframe").attr("src", "result.php?ID=" + id+"&playerseat="+result.seat);
                                finalize();
                            } else {
                                if (result.finish) {
                                    $("#main").html("You cannot change because you have click finish button.");
                                } else {
                                    (result.seat !== null) ? finalize() : findseat();
                                }
                            }

                        } else {
                            $("#errortext").html("Server Error! (Error:" + result.message + ")");
                        }

                    },
                    fail: function (error) {
                        $('#EnterNameDialogFace').waitMe("hide");
                        $("#errortext").html("Server Error (Error:" + error + ")");
                    },
                }
        );
    });
}
$(document).ready(function () {
    newplayer();
});
