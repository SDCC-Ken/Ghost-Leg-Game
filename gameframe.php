<?php
include_once 'Class/JSONDatabase.php';
$db = new JSONDatabase();
if (isset($_GET["ID"]) && $db->readJSON($_GET["ID"]) == NULL) {
    header('HTTP/1.1 404 Not found');
    exit();
}
$game = $db->readJSON($_GET["ID"]);
$seats = array();
foreach ($game->player AS $player) {
    if ($player->name != NULL && $player->seat != NULL) {
        $seats[$player->seat] = $player->name;
    }
}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>SPD4517 Individual Assignment (Web 2.0)</title>
        <meta name="description" content="An assignment developing a Ghost Leg game using Web 2.0 technologies">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- jQuery -->
        <script src="bower_components/jquery/dist/jquery.js" type="text/javascript"></script>
        <!--waitMe-->
        <link href="bower_components/waitMe/waitMe.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/waitMe/waitMe.js" type="text/javascript"></script>
        <link href="css/main.css" rel="stylesheet" type="text/css"/>
        <style>
            body{
                margin: 0px;
            }
        </style>

        <script>
            var canvas = {
<?php foreach ($game->player AS $i => $player): ?>
                    "canvas<?php echo $i ?>": [
                    ],
<?php endforeach; ?>
            };
            var addline = function (context, area, y) {
                $('#gameborad').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
                $.ajax(
                        {
                            method: "POST",
                            url: "Ajax/addline.php?ID=<?php echo isset($_GET["ID"]) ? $_GET["ID"] : ""; ?>",
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
                                    $("#errortext").html("Server Error! (Error:" + result + ")");
                                }
                            },
                            fail: function (error) {
                                $('#gameborad').waitMe("hide");
                                $("#errortext").html("Server Error (Error:" + error + ")");
                            },
                        }
                );
            }
            function checkok(a, b) {
                return (Math.abs(a - b) > 10) ? true : false;
            }
            var game = JSON.parse('<?php echo json_encode($game); ?>');
            $(document).ready(function () {
                for (var i = 0; i < game.line.length; i++) {
                    var context = $("#"+game.line[i].area)[0].getContext("2d");
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

        </script>
    </head>
    <body>
        <p id="errortext"></p>
        <div style="width:<?php echo (sizeof($game->player)) * 100 + 100; ?>px;margin:0px 50px;overflow: hidden;">
            <?php foreach ($seats AS $seat): ?>
                <div style="width: 100px;padding: 0;display: inline-block;"><?php echo $seat; ?></div>
            <?php endforeach; ?>
        </div>
        <div id="gameborad" style="width:<?php echo (sizeof($game->player)) * 100; ?>px;margin:0px 50px;overflow: hidden;">
            <?php for ($i = 0; $i < sizeof($game->player) - 1; $i++): ?>
                <canvas id="canvas<?php echo $i ?>" width='100' height='500'></canvas>
            <?php endfor; ?>
        </div>
        <div style="width:<?php echo (sizeof($game->player)) * 100 + 100; ?>px;margin:0px 50px;overflow: hidden;">
            <?php foreach ($game->goal AS $goal): ?>
                <div style="width: 100px;padding: 0;display: inline-block;"><?php echo $goal; ?></div>
            <?php endforeach; ?>
        </div>
    </body>
</html>
