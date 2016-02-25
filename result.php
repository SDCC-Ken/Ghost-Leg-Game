<?php
include_once 'Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
$playerseat = isset($_GET["playerseat"]) ? $_GET["playerseat"] : "" ;
$db = new JSONDatabase();
$game = $db->readJSON($id) or exit("No Such game");
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

        <!-- Bootstrap -->
        <link href="bower_components/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <link href="bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

        <!--waitMe-->
        <link href="bower_components/waitMe/waitMe.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/waitMe/waitMe.js" type="text/javascript"></script>

        <link href="css/game.css" rel="stylesheet" type="text/css"/>
        <style>body{margin: 0px;}</style>

        <script>
            var canvas = {<?php for ($i = 0;$i<sizeof($game->player)-1;$i++): ?>"canvas<?php echo $i ?>": [],<?php endfor; ?>};
            var id = '<?php echo $id; ?>';
            var playerseat = <?php echo $playerseat; ?>;
            var game = JSON.parse('<?php echo json_encode($game); ?>');
            var maxcanvas = <?php echo sizeof($game->player)-1;?>;
        </script>
        <script src="js/result.js" type="text/javascript"></script>
    </head>
    <body>
        <p id="errortext">Game end</p>
        <p id="myText"></p>
        <div class="table-responsive" style="width:<?php echo (sizeof($game->player)) * 100; ?>px;">
            <table class="text-center">
                <thead>
                    <tr>
                        <?php foreach ($game->player AS $i => $player): ?>
                            <td id="seat<?php echo $i ?>" style="width: 100px;padding: 0"></td>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="<?php echo sizeof($game->player); ?>" style="width:<?php echo (sizeof($game->player)) * 100; ?>px;margin:0px 50px;">
                            <canvas id="readgamecanvas" width='<?php echo (sizeof($game->player)) * 100; ?>' height='500'></canvas>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <?php foreach ($game->goal AS $goal): ?>
                            <td style="width: 100px;padding: 0"><?php echo $goal; ?></td>
                        <?php endforeach; ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>
