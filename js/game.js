/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

