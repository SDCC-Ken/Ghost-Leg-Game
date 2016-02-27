$("document").ready(function () {
    
    $("#playform").submit(function (e) {
        e.preventDefault();
        $('#playform').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
        $.ajax(
                {
                    method: "GET",
                    url: "Ajax/checkgame.php?ID=" + $("#gameid").val(),
                    success: function (result) {
                        $('#playform').waitMe("hide");
                        if (result.success) {
                            window.location.href = "game.php?ID=" + $("#gameid").val();
                        } else {
                            $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + result.message});
                        }
                    },
                    fail: function (error) {
                        $('#playform').waitMe("hide");
                        $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + error});
                    },
                }
        );
    });
});


