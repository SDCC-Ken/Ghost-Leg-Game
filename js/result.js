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
    context.lineWidth = 5;
    context.strokeStyle = '#ff0000';
    var x = 0;
    var area = seat;
    var leftcanvas = new Array();
    var rightcanvas = new Array();
    do {
        leftcanvas = (area <= 0) ? new Array() : canvas["canvas" + (area - 1)];
        rightcanvas = (area >= maxcanvas) ? new Array() : canvas["canvas" + area];
        var oldx = x;
        var leftx = 510;
        var rightx = 510;
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
        x = Math.min(leftx, rightx);
        var areastart = 50 + 100 * area;
        area = (x === leftx) ? (area-1<0?0:(area - 1)) : (area>maxcanvas?maxcanvas:(area + 1));
        var areaend = 50 + 100 * area;
        context.beginPath();
        context.moveTo(areastart, oldx);
        context.lineTo(areastart, x);
        context.stroke();
        if (x <= 500) {
            context.beginPath();
            context.moveTo(areastart, x);
            context.lineTo(areaend, x);
            context.stroke();
        }
        
    } while (x <= 500);
    console.log(area);
    for (var i = 0; i < game.player.length; i++) {
        if (game.player[i].seat == seat) {
            $("#myText").html(game.player[i].name + " get " + game.goal[area]);
            break;
        }
    }
}
$(document).ready(function () {
    var context = $("#readgamecanvas")[0].getContext("2d");
    draw(context);

    for (var i = 0; i < game.player.length; i++) {
        $("#seat" + game.player[i].seat).html(game.player[i].name);
    }
    for (var i = 0; i < game.line.length; i++) {
        canvas[game.line[i].area].push(Number(game.line[i].y));
    }
    
    for (var i = 0; i < maxcanvas; i++) {
        console.log(canvas["canvas" + i]);
        canvas["canvas" + i].sort(function (a, b) {
            return a - b;
        });
        canvas["canvas" + i].push(510);
    }
    drawAnswer(playerseat);
});