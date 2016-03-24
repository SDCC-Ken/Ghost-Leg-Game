var addline = function (context, area, y) {
    $('#gameborad').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
    $.ajax(
            {
                method: "POST",
                url: "Ajax/addline.php?ID=" + id,
                data: {
                    area: area,
                    y: y,
                },
                datatype: "json",
                success: function (jsonresult) {
                    $('#gameborad').waitMe("hide");
                    var result = JSON.parse(jsonresult);
                    if (result.success) {
                        context.beginPath();
                        context.moveTo(0, y);
                        context.lineTo(300, y);
                        context.stroke();
                        context.beginPath();
                    } else {
                        $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + result});
                    }
                },
                fail: function (error) {
                    $('#gameborad').waitMe("hide");
                    $("#errortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + error});
                },
            }
    );
}
function checkok(a, b) {
    console.log(Math.abs(a - b));
    return (Math.abs(a - b) > 15) ? true : false;
}
$(document).ready(function () {
    for (var i = 0; i < game.line.length; i++) {
        canvas[game.line[i].area].push(game.line[i].y);
//        var context = $("#" + game.line[i].area)[0].getContext("2d");
//        context.clearRect(0, 0, $("#" + game.line[i].area)[0].width, $("#" + game.line[i].area)[0].height);
//        context.beginPath();
//        context.moveTo(0, game.line[i].y);
//        context.lineTo(300, game.line[i].y);
//        context.stroke();
//        context.beginPath();
    }
    console.log(canvas);
    $('canvas').on({
        mousedown: function (e) {
            var ok = false;
            var y = e.pageY - this.offsetTop;
            console.log(canvas);
            if (canvas[$(this).attr('id')].length > 0) {
                if ($(this).prev().length > 0 && canvas[$(this).prev().attr('id')] !== null) {
                    console.log(1);
                    for (var i = 0; i < canvas[$(this).prev("canvas").attr('id')].length; i++) {
                        ok = checkok(canvas[$(this).prev("canvas").attr('id')][i], y);
                        if (!ok) {
                            break;
                        }
                    }
                }
                for (var i = 0; i < canvas[$(this).attr('id')].length; i++) {
                    if(checkok(canvas[$(this).attr('id')][i], y)) {
                        continue;
                    }else{
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
                canvas[$(this).attr('id')].push(y);
                var context = $(this)[0].getContext("2d");
                addline(context, $(this).attr('id'), y);
            }
        }
    });
});