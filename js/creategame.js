$("document").ready(function () {
    //initialize instance
    var enjoyhint_instance = new EnjoyHint({});
    var enjoyhint_script_steps = [
        {
            "key #name": "Please Enter your name and Press tab",
            keyCode: 9,
            showNext:true,
        },
        {
            "key #email": "Please Enter your email (We will send you the result this email) and Press tab",
            keyCode: 9,
            showNext:true,
        },
        {
            "key #gameid": "Please Enter game ID and Press tab",
            keyCode: 9,
            showNext:true,
        },
        {
            "key #player": "Please Enter no of player and Press tab",
            keyCode: 9,
            showNext:true,
        },
        {
            "key #goal": "Please Enter the goals and Press tab",
            keyCode: 9,
            showNext:true,
        },
        {
            "click #createButton": "Click to Create",
        },
    ];
    enjoyhint_instance.set(enjoyhint_script_steps);
    enjoyhint_instance.run();
    $("#player").change(function (e) {
        e.preventDefault();
        var goals = [];
        $(".goalinput").each(function () {
            if ($(this).is("input")) {
                goals.push($(this).val());
            }
        });
        $("#goal").html("");
        for (var i = 0; i < Number($(this).val()); i++) {
            $("#goal").append(
                    '<div class="form-group has-feedback">'
                    + '<input type="text" class="form-control goalinput" id="goal' + i + '" name="goal' + i + '" required="required" />'
                    + '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>'
                    + '<span class="sr-only">(error)</span>'
                    + '</div>'
                    );
            $("#goal" + i).val(goals[i]);
            $("#goal" + i).change(function () {
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
        }
        $(this).trigger('change');
    });
    $("form#createform :input").each(function () {
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
                            setLocal("Ghost_Leg_player_name",$("#name").val());
                            setLocal("Ghost_Leg_player_email",$("#email").val());
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
                        $('#ChooseSeatDialogFace').waitMe("hide");
                        $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + error});
                    },
                }
        );
    });
});


