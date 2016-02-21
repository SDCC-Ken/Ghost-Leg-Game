var draw = function (context) {
    for (var i = 0; i < game.player.length; i++) {
        var x = 50 + i * 100;
        context.beginPath();
        context.moveTo(x, 0);
        context.lineTo(x, 500);
        context.stroke();
    }
    for (var i = 0; i < game.line.length; i++) {
        var areastart = game.line[i].area;
        var xstart = 50 + 100 * Number(areastart.substring(6, areastart.length));
        var xend = 50 + 100 * (Number(areastart.substring(6, areastart.length)) + 1);
        context.beginPath();
        context.moveTo(xstart, game.line[i].y);
        context.lineTo(xend, game.line[i].y);
        context.stroke();
    }
};
var drawAnswer = function (seat) {
    var context = $("#readgamecanvas")[0].getContext("2d");
    var x = 0;
    var area = seat;
    var leftcanvas = new Array();
    var rightcanvas = new Array();
    do {
        leftcanvas = (area === 0) ? new Array() : canvas["canvas" + (area - 1)];
        rightcanvas = canvas["canvas" + area];
        var oldx = x;
        var leftx = x;
        var rightx = x;
        for (var i = 0; i < leftcanvas.length; i++) {
            if (leftcanvas[i] > x) {
                leftx = leftcanvas[i];
                break;
            }
        }
        for (var i = 0; i < rightcanvas.length; i++) {
            if (rightcanvas[i] > x) {
                rightx = rightcanvas[i];
                break;
            }
        }
        x = (leftx > rightx) ? leftx : rightx;
        var areastart = 50 + 100 * area;
        var areaend = 50 + 100 * ((leftx > rightx) ? (area - 1) : (area + 1));
        context.beginPath();
        context.moveTo(areastart, oldx);
        context.lineTo(areastart, x);
        context.lineWidth = 5;
        context.strokeStyle = '#ff0000';
        context.stroke();
        context.beginPath();
        context.moveTo(areastart, x);
        context.lineTo(areaend, x);
        context.lineWidth = 5;
        context.strokeStyle = '#ff0000';
        context.stroke();
        var area = (leftx > rightx) ? area - 1 : area + 1;
    } while (x <= 500);
    $("#myText").html(game.player[seat].name+" get "+game.goal[seat]);
}
$(document).ready(function () {
    var context = $("#readgamecanvas")[0].getContext("2d");
    draw(context);
    drawAnswer(playerseat);
    for (var i = 0; i < game.player.length; i++) {
        $("#seat" + i).html(game.player[i].name);
    }
    for (var i = 0; i < game.line.length; i++) {
        canvas[game.line[i].area].push(Number(game.line[i].y));
    }
    for (var i = 0; i < game.player.length; i++) {
        canvas["canvas" + i].sort(function (a, b) {
            return a - b
        });
        if (i !== game.player.length - 1) {
            canvas["canvas" + i].push(510);
        }
    }
});