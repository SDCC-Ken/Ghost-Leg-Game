<?php
include_once 'JSONDatabase.php';
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

        <!-- jQuery Language -->
        <script src="bower_components/jquery-lang-js/js/jquery-lang.js" type="text/javascript"></script>

        <!-- sweetalert-->
        <link href="bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>

        <link rel="stylesheet" href="css/main.css">
        <script>
            $(document).ready(function () {
                var game = JSON.parse('<?php echo json_encode($game); ?>');
                console.log(game);
                swal(
                        {
                            title: "What is your name?",
                            text: "What is your name?",
                            type: "input",
                            closeOnConfirm: false,
                            animation: "slide-from-top",
                            inputPlaceholder: "What is your name?"
                        },
                function (inputValue) {
                    if (inputValue === false)
                        return false;
                    if (inputValue === "") {
                        swal.showInputError("Please write down your name!");
                        return false;
                    }
                    
                }
                );
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
                    <a class="navbar-brand" href="#">SPD4517 Indivdual Assignment 1</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">

                </div><!--/.navbar-collapse -->
            </div>
        </nav>

        <main class="container">
            <iframe src="gameframe.php?ID=<?php echo $_GET["ID"]; ?>" style="width:100%;height: 800px;border:0px;"></iframe>
        </main>

        <footer class="navbar-fixed-bottom">
            <p>&copy; Chan Kwan Wing 14011142S</p>
        </footer>


        <div id="ChooseSeatDialog" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Choose Seat</h4>
                    </div>
                    <div class="modal-body">
                        <table>
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="<?php ?>"></td>
                                </tr>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                        <?php
                        $seats = array();
                        foreach ($game->player AS $i => $player) {
                            
                        }
                        ?>
                        <?php foreach ($game->player AS $seat): ?>

                        <?php endforeach; ?>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </body>
</html>
