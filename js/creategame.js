var inputChange = function () {
    if ($(this).val() === "" && $(this).is(":invalid")) {
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
}
$("document").ready(function () {
    $('#name').focus();
    $('#name').tooltip({'trigger': 'focus', 'title': 'Enter your name'});
    $('#email').tooltip({'trigger': 'focus', 'title': 'Enter your email and we will send you email for the result.'});
    $('#gameid').tooltip({'trigger': 'focus', 'title': 'You should type a unique game ID for sharing to other'});
    $('#player').tooltip({'trigger': 'focus', 'title': 'You should enter how many player can join the game and click "TAB" in your keyboard'});
    $("#player").change(function (e) {
        e.preventDefault();
        $("#goal").html("");
        for (var i = 0; i < Number($("#player").val()); i++) {
            $("#goal").append(
                    '<div class="form-group has-feedback">'
                    + '<input type="text" class="form-control goalinput" id="goal' + i + '" name="goal' + i + '" required="required" />'
                    + '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>'
                    + '<span class="sr-only">(error)</span>'
                    + '</div>'
                    );
            $('#goal' + i).tooltip({'trigger': 'focus', 'title': 'Enter the goal'});
            $("#goal" + i).change(inputChange);
        }
        $('#goal0').focus();
    });
    $("form#createform :input").each(function () {
        $(this).change(inputChange);
    });
    $("#createform").submit(function (e) {
        e.preventDefault();
        $('#createform').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
        var goals = [];
        $(".goalinput").each(function () {
            if ($(this).is("input")) {
                goals.push($(this).val());
            }
        });
        $.ajax(
                {
                    method: "POST",
                    url: "Ajax/creategame.php?ID=" + $("#gameid").val(),
                    data: {
                        name: $("#name").val(),
                        email: $("#email").val(),
                        gameid: $("#gameid").val(),
                        player: $("#player").val(),
                        goals: JSON.stringify(goals),
                    },
                    datatype: "json",
                    success: function (jsonresult) {
                        var result = JSON.parse(jsonresult);
                        $('#createform').waitMe("hide");
                        if (result.success) {
                            setLocal("Ghost_Leg_player_name", $("#name").val());
                            setLocal("Ghost_Leg_player_email", $("#email").val());
                            $('#ShareDialog').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                            $('#ShareDialog').modal('show');
                            $('#createform').addClass("hidden");
                            $("#share").attr("src", "shareframe.php?ID=" + result.id);
                        } else {
                            $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + result.error});
                        }
                    },
                    fail: function (error) {
                        $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + error});
                    },
                }
        );
    });
});


