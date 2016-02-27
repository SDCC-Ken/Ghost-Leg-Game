<?php
include_once 'Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
$db = new JSONDatabase();
$game = $db->readJSON($id) or exit("No Such game");
$seats = array();
foreach ($game->player AS $player) {
    if ($player->name != NULL && $player->seat != NULL) {
        $seats[$player->seat] = $player->name;
    }
}
if ($game->end == TRUE) {
    header('Location:result.php?ID=' . $id);
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

        <!-- Bootstrap -->
        <link href="bower_components/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <link href="bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

        <!--waitMe-->
        <link href="bower_components/waitMe/waitMe.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/waitMe/waitMe.js" type="text/javascript"></script>

        <script src="bower_components/Ken_JQuery_Bootstrp_Alert/dist/js/ken-jquery-bootstrap-alert.js" type="text/javascript"></script>

        <script src="bower_components/enjoyhint/enjoyhint.js" type="text/javascript"></script>
        <link href="bower_components/enjoyhint/enjoyhint.css" rel="stylesheet" type="text/css"/>

        <link href="css/main.css" rel="stylesheet" type="text/css"/>
        <style>body{margin: 0px;}</style>

        <script>
            var canvas = {<?php foreach ($game->player AS $i => $player): ?>"canvas<?php echo $i ?>": [],<?php endforeach; ?>};
            var id = '<?php echo isset($_GET["ID"]) ? $_GET["ID"] : ""; ?>';
            var game = JSON.parse('<?php echo json_encode($game); ?>');
        </script>
        <script src="js/gameframe.js" type="text/javascript"></script>
    </head>
    <body>
        <p id="errortext"></p>
        <div style="width:<?php echo sizeof($game->player) * 100 + 200; ?>px;margin:0px 0px;overflow: hidden;">
            <?php foreach ($game->player AS $i => $player): ?>
                <div style="width: 100px;padding: 0;display: inline-block; text-align: center;"><?php echo isset($seats[$i]) ? $seats[$i] : ""; ?></div>
            <?php endforeach; ?>
        </div>
        <div id="gameborad" style="width:<?php echo sizeof($game->player) * 100 + 200; ?>px;margin:0px 50px;overflow: hidden;">
            <?php for ($i = 0; $i < sizeof($game->player) - 1; $i++): ?>
                <canvas id="canvas<?php echo $i ?>" width='100' height='500'></canvas>
            <?php endfor; ?>
        </div>
        <div style="width:<?php echo sizeof($game->player) * 100 + 200; ?>px;margin:0px 0px;overflow: hidden;">
            <?php foreach ($game->goal AS $goal): ?>
                <div style="width: 100px;padding: 0;display: inline-block; text-align: center;"><?php echo $goal; ?></div>
            <?php endforeach; ?>
        </div>

    </body>
</html>
