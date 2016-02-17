<?php
include_once 'Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
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

        <!-- sweetalert-->
        <link href="bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>

        <!--waitMe-->
        <link href="bower_components/waitMe/waitMe.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/waitMe/waitMe.js" type="text/javascript"></script>
        
        <script src="js/game.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/main.css">
        <script>
            var game = JSON.parse('<?php echo json_encode($game); ?>');
            var playerName = null;
            var finalize = function () {
                $("#gameframe").attr("src", "gameframe.php?ID=<?php echo isset($_GET["ID"]) ? $_GET["ID"] : ""; ?>");
            };
            var setseat = function (seat) {
                console.log(seat);
                if (playerName !== null) {
                    $('#ChooseSeatDialogFace').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
                    $.ajax(
                            {
                                method: "POST",
                                url: "Ajax/setseat.php?ID=<?php echo isset($_GET["ID"]) ? $_GET["ID"] : ""; ?>",
                                data: {
                                    seat: seat,
                                    name: playerName,
                                },
                                datatype: "json",
                                success: function (result) {
                                    $('#ChooseSeatDialogFace').waitMe("hide");
                                    if (result == "S") {
                                        $('#ChooseSeatDialog').modal('hide');
                                        finalize();
                                    } else {
                                        $("#seaterrortext").html("Server Error! (Error:" + result + ")");
                                    }
                                },
                                fail: function (error) {
                                    $('#ChooseSeatDialogFace').waitMe("hide");
                                    $("#seaterrortext").html("Server Error (Error:" + error + ")");
                                },
                            }
                    );
                }
            };
            $(document).ready(function () {
                $('#EnterNameDialog').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('#EnterNameDialog').modal('show');
                $('#enterNameButton').click(function () {
                    $('#EnterNameDialogFace').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
                    console.log($("#name").val());
                    $.ajax(
                            {
                                method: "POST",
                                url: "Ajax/addname.php?ID=<?php echo isset($_GET["ID"]) ? $_GET["ID"] : ""; ?>",
                                data: {
                                    name: $("#name").val(),
                                },
                                datatype: "json",
                                success: function (jsonresult) {
                                    $('#EnterNameDialogFace').waitMe("hide");
                                    var result = JSON.parse(jsonresult);
                                    if (result.success) {
                                        playerName = $("#name").val();
                                        if (result.seat !== null) {
                                            $('#EnterNameDialog').modal('hide');
                                            finalize();
                                        } else {
                                            findseat();
                                        }
                                    } else {
                                        $("#errortext").html("Server Error! (Error:" + result + ")");
                                    }

                                },
                                fail: function (error) {
                                    $('#EnterNameDialogFace').waitMe("hide");
                                    $("#errortext").html("Server Error (Error:" + error + ")");
                                },
                            }
                    );
                });
            });
        </script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">SPD4517 Indivdual Assignment 1</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">

                </div><!--/.navbar-collapse -->
            </div>
        </nav>

        <main class="container">
            <iframe id="gameframe" src="" style="width:100%;height: 700px;"></iframe>
        </main>

        <footer class="navbar-fixed-bottom">
            <p>&copy; Chan Kwan Wing 14011142S</p>
        </footer>


        <div id="EnterNameDialog" class="modal fade" tabindex="-1" role="dialog">
            <div id="EnterNameDialogFace" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enter your name</h4>
                    </div>
                    <div class="modal-body">
                        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
                        <h1 class="text-center">What is your name?</h1>
                        <p class="text-center"><label for="name"><input type="text" id="name" /></label></p>
                        <p id="errortext"></p>
                        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

                    </div>
                    <div class="modal-footer">
                        <button id="enterNameButton" type="button" class="btn btn-primary expand-right ladda" data-style="expand-right"><span class="ladda-label">Submit</span></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="ChooseSeatDialog" class="modal fade" tabindex="-1" role="dialog">
            <div id="ChooseSeatDialogFace" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Choose Seat</h4>
                    </div>
                    <div class="modal-body">
                        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
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
                        <p id="seaterrortext"></p>
                        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </body>
</html>
