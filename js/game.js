var finalize = function (result) {
    if (!game.end) {
        if (result.finish) {
            $("#main").html("");
            $("#main").kenJqueryBootstrapAlert({type: "danger", close: false, "message": "You cannot change because you have click finish button."});
        } else {
            $("#gameframe").tooltip({'trigger': 'hover', 'title': 'Click to add line to the game.'});
            $("#submitButton").tooltip({'trigger': 'hover', 'title': 'Click me to finish the game.'});
            $("#gameframe").attr("src", "gameframe.php?ID=" + id);
            $("#finishText").kenJqueryBootstrapAlert({type: "info", close: true, "message": "Click FINISH button to finish the game"});
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
                                    $("#main").html("");
                                    $("#main").kenJqueryBootstrapAlert({type: "success", close: false, "message": "You cannot change because you have click finish button."});
                                } else {
                                    $("#finishText").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + result});
                                }
                            },
                            fail: function (error) {
                                $('#main').waitMe("hide");
                                $("#finishText").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + error});
                            },
                        }
                );
            });
        }
    } else {
        $("#gameframe").attr("src", "result.php?ID=" + id + "&playerseat=" + result.seat);
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
        //$("#seat" + i).tooltip({'trigger': 'hover', 'title': 'Choose Me','placement':'bottom'});
    }
    for (var i = 0; i < game.player.length; i++) {
        if (game.player[i].seat !== null) {
            $("#seat" + game.player[i].seat).html(game.player[i].name);
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
                        if (result === "S") {
                            $('#ChooseSeatDialog').modal('hide');
                            finalize({name: playerName, finish: false, seat: seat});
                        } else {
                            $("#seaterrortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + result});
                        }
                    },
                    fail: function (error) {
                        $('#ChooseSeatDialogFace').waitMe("hide");
                        $("#seaterrortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + error});
                    },
                }
        );
    }
};
var newplayer = function () {
    $('#name').focus();
    $('#name').tooltip({'trigger': 'focus', 'title': 'Enter your name'});
    $('#email').tooltip({'trigger': 'focus', 'title': 'Enter your email and we will send you email for the result.'});
    $("form#EnterNameDialogForm :input").each(function () {
        $(this).change(function () {
            if ($(this).is(":invalid")) {
                $(this).siblings(".form-control-feedback").removeClass("glyphicon-ok");
                $(this).siblings(".form-control-feedback").addClass("glyphicon-remove");
                $(this).siblings(".sr-only").html("(error)");
                $(this).parent(".form-group").removeClass("has-success");
                $(this).parent(".form-group").addClass("has-error");
            } else {
                $(this).siblings(".form-control-feedback").removeClass("glyphicon-remove");
                $(this).siblings(".form-control-feedback").addClass("glyphicon-ok");
                $(this).siblings(".sr-only").html("(success)");
                $(this).parent(".form-group").removeClass("has-error");
                $(this).parent(".form-group").addClass("has-success");
            }
        });
    });
    $('#EnterNameDialogForm').submit(function (e) {
        e.preventDefault();
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
                            setLocal("Ghost_Leg_player_name", $("#name").val());
                            setLocal("Ghost_Leg_player_email", $("#email").val());
                            $('#EnterNameDialog').modal('hide');
                            $("#main").removeClass("hidden");
                            (result.seat !== null) ? finalize(result) : findseat();
                        } else {
                            $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + result.message});
                        }

                    },
                    fail: function (error) {
                        $('#EnterNameDialogFace').waitMe("hide");
                        $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + error});
                    },
                }
        );
    });
    $('#EnterNameDialog').modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#EnterNameDialog').modal('show');
    if (getLocal("Ghost_Leg_player_name") !== null) {
        $("#name").val(getLocal("Ghost_Leg_player_name"));
        $("#name").change();
    }
    if (getLocal("Ghost_Leg_player_email") !== null) {
        $("#email").val(getLocal("Ghost_Leg_player_email"));
        $("#email").change();
    }
}
$(document).ready(function () {
    newplayer();
});
