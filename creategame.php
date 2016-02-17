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
        <style>body {padding-top: 50px;padding-bottom: 20px;}</style>

        <link href="bower_components/waitMe/waitMe.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/waitMe/waitMe.js" type="text/javascript"></script>

        <link rel="stylesheet" href="css/main.css">
        <script src="js/main.js"></script>
        <script src="js/creategame.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">SPD4517 Indivdual Assignment 1</a>
                </div>
            </div>
        </nav>
        <main class="container-fluid">
            <form id="createform">
                <p id="errortext"></p>
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" required="required" />
                </div>
                <div class="form-group">
                    <label for="gameid">Game ID</label>
                    <input type="text" class="form-control" id="gameid" name="gameid" maxlength="5" required="required" />
                </div>
                <div class="form-group">
                    <label for="player">No of player</label>
                    <input type="number" class="form-control" id="player" name="player" required="required" />
                </div>
                <div class="form-group">
                    <label for="goal">Goals</label>
                    <div id="goal">
                        <?php
                        if (isset($_POST["player"]) && $_POST["player"] != "") :
                            for ($i = 0; $i < $_POST["player"]; $i++) :
                                ?>
                                <input type="text" class="form-control" id="goal<?php echo $i + 1; ?>" name="goal<?php echo $i + 1; ?>" required="required">
                                <?php
                            endfor;
                        endif;
                        ?>
                    </div>
                    <span class="help-block">When you type the no of player, the number of goal input would display.</span>
                </div>
                <button id="createButton" type="button" class="btn btn-default" name="submit">Create</button>
            </form>
        </main>

        <footer class="navbar-fixed-bottom">
            <p>&copy; Chan Kwan Wing 14011142S</p>
        </footer>  
        
        <div id="ShareDialog" class="modal fade" tabindex="-1" role="dialog">
            <div id="ShareDialogFace" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Share Game</h4>
                    </div>
                    <div class="modal-body">
                        <iframe id="share" src="" style="width:100%;height: 700px;"></iframe>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </body>
</html>