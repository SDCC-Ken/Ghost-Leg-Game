function checkok(a, b) {
    return (Math.abs(a - b) > 10) ? true : false;
}
$(document).ready(function () {
    for (var i = 0; i < game.line.length; i++) {
        var context = $("#" + game.line[i].area)[0].getContext("2d");
        context.beginPath();
        context.moveTo(0, game.line[i].y);
        context.lineTo(300, game.line[i].y);
        context.stroke();
        context.beginPath();
    }
    $('canvas').on({
        mousedown: function (e) {
            var ok = false;
            var y = e.pageY - this.offsetTop;
            if (canvas[$(this).attr('id')].length > 0) {
                if ($(this).prev().length > 0 && canvas[$(this).prev().attr('id')] !== null) {
                    for (var i = 0; i < canvas[$(this).prev("canvas").attr('id')].length; i++) {
                        ok = checkok(canvas[$(this).prev("canvas").attr('id')][i], y);
                        if (!ok) {
                            break;
                        }
                    }
                }
                for (var i = 0; i < canvas[$(this).attr('id')].length; i++) {
                    ok = checkok(canvas[$(this).attr('id')][i], y);
                    if (!ok) {
                        break;
                    }
                }
                if ($(this).next().length > 0 && canvas[$(this).next("canvas").attr('id')] !== null) {
                    for (var i = 0; i < canvas[$(this).next("canvas").attr('id')].length; i++) {
                        ok = checkok(canvas[$(this).next("canvas").attr('id')][i], y);
                        if (!ok) {
                            break;
                        }
                    }
                }
            } else {
                ok = true;
            }
            if (ok) {
                var context = $(this)[0].getContext("2d");
                addline(context, $(this).attr('id'), y);
            }
        }
    });
});