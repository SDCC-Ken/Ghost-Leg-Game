$("document").ready(function () {
    $("#player").change(function () {
        $("#goal").html("");
        for (var i = 0; i < Number($(this).val()); i++) {
            $("#goal").append('<input type="text" class="form-control goalinput" id="goal' + (i + 1) + '" name="goal' + (i + 1) + '" required="required" />');
        }
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
                            console.log(result.email);
                            $('#ShareDialog').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                            $('#ShareDialog').modal('show');
                            $('#createform').addClass("hidden");
                            $("#share").attr("src", "shareframe.php?ID=" + result.id);
                        } else {
                            $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true,"message":"Error:" + result.error});
                        }
                    },
                    fail: function (error) {
                        $('#ChooseSeatDialogFace').waitMe("hide");
                        $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true,"message":"Error:" + error});
                    },
                }
        );
    });
});


