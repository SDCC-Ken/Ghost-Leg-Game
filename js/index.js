$("document").ready(function () {
    $("#playButton").click(function () {
        $('#playform').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
        $.ajax(
                {
                    method: "GET",
                    url: "Ajax/checkgame.php?ID="+$("#gameid").val(),
                    success: function (result) {
                        $('#playform').waitMe("hide");
                        if (result == "S") {
                            window.location.href = "game.php?ID="+$("#gameid").val();
                        } else {
                            $("#errortext").html("Error:" + result );
                        }
                    },
                    fail: function (error) {
                        $('#ChooseSeatDialogFace').waitMe("hide");
                        $("#errortext").html("Error:" + error );
                    },
                }
        );
    });
});


