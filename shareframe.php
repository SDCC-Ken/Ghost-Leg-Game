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
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="Ghost leg game" />
        <meta property="og:description"   content="Let play ghost leg together!" />
        <!-- jQuery -->
        <script src="bower_components/jquery/dist/jquery.js" type="text/javascript"></script>

        <!-- Bootstrap -->
        <link href="bower_components/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <link href="bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

        <link href="bower_components/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        
        <link href="bower_components/waitMe/waitMe.css" rel="stylesheet" type="text/css"/>
        <script src="bower_components/waitMe/waitMe.js" type="text/javascript"></script>
        
        <script src="bower_components/Ken_JQuery_Bootstrp_Alert/dist/js/ken-jquery-bootstrap-alert.js" type="text/javascript"></script>
        
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
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
        <p>Share by link:</p>
        <p>Link: <a target="_parent" href="game.php?ID=<?php echo $_GET["ID"]; ?>">http://spd4517ia.kwanwing.tk/game.php?ID=<?php echo $_GET["ID"]; ?></a></p>
        <p>Share by email:</p>
        <form id="emailForm" class="form-inline" data-gameid="<?php echo $_GET["ID"]; ?>">
            <div id="emailerrortext"></div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" />
            </div>
            <button type="submit" class="btn btn-default">Send invitation</button>
        </form>
        <p>Share by Social Network Button:</p>
        <div
            class="fb-share-button" 
            data-href="" 
            data-text="Let play ghost leg together!" 
            data-layout="button">
        </div>
        <a 
            href="https://twitter.com/share" 
            class="twitter-share-button" 
            data-url="http://spd4517ia.kwanwing.tk/game.php?ID=<?php echo $_GET["ID"]; ?>" 
            data-text="Let play ghost leg together!"  
            data-related="KenChan2012cc" 
            data-hashtags="SPD4517">
        </a>
        <div 
            class="g-plus" 
            data-action="share" 
            data-height="24" 
            data-href="http://spd4517ia.kwanwing.tk/game.php?ID=<?php echo $_GET["ID"]; ?>"
            data-text="Let play ghost leg together!"
            data-annotation="none">
        </div>
        <div id="fb-root"></div>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script>
            window.___gcfg = {
                lang: 'en-GB',
                parsetags: 'onload'
            };
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/zh_HK/sdk.js#xfbml=1&version=v2.5&appId=1087864911276380";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            !function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + '://platform.twitter.com/widgets.js';
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, 'script', 'twitter-wjs');
            $('#emailForm').submit(function (e) {
                e.preventDefault();
                $('#emailForm').waitMe({effect: 'bounce', text: '', bg: '#FFF', color: '#000', sizeW: '', sizeH: '', source: ''});
                $.ajax(
                        {
                            method: "POST",
                            url: "Ajax/share.php?ID=" + $(this).data("gameid"),
                            data: $(this).serialize(),
                            datatype: "json",
                            success: function (jsonresult) {
                                var result = JSON.parse(jsonresult);
                                $('#emailForm').waitMe("hide");
                                if (result.success) {
                                    $("#emailerrortext").kenJqueryBootstrapAlert({type: "primary", close: true, "message": "Share Success"});
                                } else {
                                    $("#emailerrortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Share Error" });
                                }
                            },
                            fail: function (error) {
                                $('#emailForm').waitMe("hide");
                                $("#emailerrortext").kenJqueryBootstrapAlert({type: "danger", close: true, "message": "Error:" + error});
                            },
                        }
                );
            });
        </script>
    </body>
</html>