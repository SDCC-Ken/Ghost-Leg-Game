<?php
include_once 'Class/JSONDatabase.php';
$db = new JSONDatabase();
if (isset($_GET["ID"]) && $db->readJSON($_GET["ID"]) == NULL) {
    header('HTTP/1.1 404 Not found');
    exit();
}
$game = $db->readJSON($_GET["ID"]);
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

        <!-- Bootstrap -->
        <link href="bower_components/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <link href="bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>

        <link rel="stylesheet" href="css/main.css">
        <script>
      

        </script>
    </head>
    <body>
        <div id="player">

        </div>
        <div id="gameborad" style="padding-left:50px;">
            <?php for ($i = 0;$i<sizeof($game->player)-1;$i++): ?>
                <canvas id="canvas<?php echo $i ?>" width='100' height='500'></canvas>
            <?php endfor; ?>
        </div>
        <div id="goal">

        </div>
    </body>
</html>
