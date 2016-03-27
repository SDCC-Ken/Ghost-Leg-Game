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
    }
    $('canvas').on({
        mousedown: function (e) {
            var y = e.pageY - this.offsetTop;
            canvas[$(this).attr('id')].push(y);
            var context = $(this)[0].getContext("2d");
            addline(context, $(this).attr('id'), y);
        }
    });
});