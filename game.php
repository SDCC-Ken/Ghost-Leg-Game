<?php
include_once 'Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
$db = new JSONDatabase();
$game = $db->readJSON($id) or exit("No Such game");
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

        <!-- jQuery Language -->
        <script src="bower_components/jquery-lang-js/js/jquery-lang.js" type="text/javascript"></script>

        <!--waitMe-->
        <link href="bower_components/waitMe/waitMe.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/waitMe/waitMe.js" type="text/javascript"></script>

        <script src="bower_components/Ken_JQuery_Bootstrp_Alert/dist/js/ken-jquery-bootstrap-alert.js" type="text/javascript"></script>

        <script src="bower_components/enjoyhint/enjoyhint.js" type="text/javascript"></script>
        <link href="bower_components/enjoyhint/enjoyhint.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="css/game.css" />
        <script src="js/main.js" type="text/javascript"></script>
        <script>
            var game = JSON.parse('<?php echo json_encode($game); ?>');
            var id = '<?php echo isset($_GET["ID"]) ? $_GET["ID"] : ""; ?>';
            var playerName = null;
        </script>
        <script src="js/game.js" type="text/javascript"></script>
    </head>
    <body>
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">SPD4517 Individual Assignment 1</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="about.html">About the Game</a></li>
                        <li><a href="walkthrough.html">Game Walkthrough</a></li>
                        <li><a href="https://dl.dropboxusercontent.com/u/79003042/index.html" target="new">About the Game Creator</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true">
                                <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">language</li>
                                <li class="text-center"><a href="#" onclick="window.lang.change('tc');
                                        return false;"><span lang="en">Traditional Chinese</span></a></li>
                                <li class="text-center"><a href="#" onclick="window.lang.change('en');
                                        return false;"><span lang="en">English</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container-fluid">
            <div id="main" class="hidden">
                <div  id="finishText"></div>
                <iframe id="gameframe" src=""></iframe>
                <div class="btn-group" role="group">
                    <button class="btn vtn-primary" id="submitButton">Finish</button>
                </div>
            </div>
        </main>

        <footer class="navbar-fixed-bottom">
            <p>&copy; Chan Kwan Wing 14011142S</p>
        </footer>


        <div id="EnterNameDialog" class="modal fade" tabindex="-1" role="dialog">
            <div id="EnterNameDialogFace" class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="EnterNameDialogForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Enter Your Name and Email</h4>
                        </div>
                        <div class="modal-body">
                            <div id="errortext" class="form-group">
                                <div class="alert alert-info" role="alert">Enter your name and email to join the game</div>
                            </div>
                            <div class="form-group has-feedback inner">
                                <label for="name">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name" required="required" />
                                <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                <span class="sr-only">(error)</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="name">Your Email</label>
                                <input type="email" class="form-control" id="email" name="email" />
                                <span class="help-block">We will send you email of the result.</span>
                                <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                <span class="sr-only">(error)</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="enterNameButton" type="submit" class="btn btn-primary expand-right ladda" data-style="expand-right"><span class="ladda-label">Submit</span></button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div id="ChooseSeatDialog" class="modal fade" tabindex="-1" role="dialog">
            <div id="ChooseSeatDialogFace" class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Choose Seat</h4>
                    </div>
                    <div class="modal-body" style="overflow:scroll;">
                        <div id="seaterrortext" class="form-group">
                            <div class="alert alert-info" role="alert">Choose seat by clicking it.</div>
                        </div>
                        <div class="table-responsive" style="width:<?php echo (sizeof($game->player)) * 100; ?>px;">
                            <table class="text-center">
                                <thead>
                                    <tr>
                                        <?php foreach ($game->player AS $i => $player): ?>
                                            <td id="seat<?php echo $i ?>" style="width: 110px;padding: 0"></td>
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
                                            <td style="width: 110px;padding: 0"><?php echo $goal; ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </body>
</html>
