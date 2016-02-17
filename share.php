<?php
include_once 'Class/JSONDatabase.php';
$db = new JSONDatabase();
$game = $db->readJSON(isset($_GET["ID"]) ? $_GET["ID"] : "") or exit("No Such game");
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

        <!-- jQuery Language -->
        <script src="bower_components/jquery-lang-js/js/jquery-lang.js" type="text/javascript"></script>

        <!-- sweetalert-->
        <link href="bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>

        <link rel="stylesheet" href="css/main.css">
        <style>
            .box{
                display: none;
                width: 100%;
            }

            a:hover + .box,.box:hover{
                display: block;
                position: relative;
                z-index: 100;
            }
        </style>
        <script src="js/main.js"></script>
        <script>
            $(document).ready(function () {
                $("#player").change(function () {
                    console.log(Number($(this).val()));
                    $("#goal").html("");
                    for (var i = 0; i < Number($(this).val()); i++) {
                        $("#goal").append('<input type="text" class="form-control" id="goal' + (i + 1) + '" name="goal' + (i + 1) + '" required="required">');
                    }
                });
            })
        </script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">SPD4517 Indivdual Assignment 1</a>
                </div>
            </div>
        </nav>
        <main class="container-fluid">
            <h1>Game (ID:<?php echo $_GET["ID"]; ?>)</h1>
            <p>Creator: <?php echo $game->creator; ?></p>
            <p>Player: </p>
            <?php
            $noplayer = 0;
            foreach ($game->player AS $player):
                if ($player->name == NULL):
                    $noplayer++;
                else:
                    ?>
                    <p><?php echo $player->name; ?></p>
                <?php
                endif;
            endforeach;
            ?>
            <p><?php echo $noplayer ?> more  player can join</p>
            <p>Goals: 
                <?php
                foreach ($game->goal AS $i => $goal) {
                    echo $goal;
                    if ($i != sizeof($game->goal) - 1) {
                        echo ",";
                    }
                }
                ?>
            </p>
            <div>
                <a href="game.php?ID=<?php echo $_GET["ID"]; ?>">Play</a>
            </div>
            <p>Share:</p>
            <p>Link: <a href="game.php?ID=<?php echo $_GET["ID"]; ?>">http://skydreamcity.hk/SPEED/game.php?ID=<?php echo $_GET["ID"]; ?></a></p>

        </main>
        <footer class="navbar-fixed-bottom">
            <p>&copy; Chan Kwan Wing 14011142S</p>
        </footer>      

    </body>
</html>