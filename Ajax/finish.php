<?php

function sendemail($id, $players) {
    require "../Mailer/PHPMailerAutoload.php";
    $ok = false;
    foreach ($players AS $player) {
        $tempplayer =  (object) $player;
        $name = $tempplayer->name;
        $email = $tempplayer->email;
        if ($email != "") {
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = "mail.kwanwing.tk";
            $mail->SMTPAuth = true;
            $mail->Username = "kwanwing@kwanwing.tk";
            $mail->Password = "abcd1234!";
            $mail->Port = 25;
            $mail->setFrom("kwanwing@kwanwing.tk", "Ghost Leg Game Admin");
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = "The game have ended. Check out what you get";
            $mail->Body = ""
                    . "<p>Dear " . $name . " </p>"
                    . "<p>Hello, The game is end. </p>"
                    . "<p>You can come to the link to see what you get.</p>"
                    . "<p><a href='http://spd4517ia.kwanwing.tk/game.php?ID=" . $id . "'>http://spd4517ia.kwanwing.tk/game.php?ID=" . $id . "</a></p>"
                    . "<p>Regards,</p>"
                    . "<p>Admin</p>";
            $mail->AltBody = ""
                    . "Dear " . $name . " \n"
                    . "Hello, The game is end. \n"
                    . "You can come to the link to see what you get\n"
                    . "Link: http://spd4517ia.kwanwing.tk/game.php?ID=" . $id . "\n"
                    . "Regards,\n"
                    . "Admin\n";
            $ok = $mail->send();
        }
    }
    return $ok;
}

include_once '../Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
$name = isset($_POST["name"]) ? $_POST["name"] : "" or exit("No Name");
$db = new JSONDatabase();
$game = $db->readJSON($id) or exit("No Such game");
$allfinish = 0;
foreach ($game->player AS $i => $player) {
    if ($player->name == $name) {
        $game->player[$i] = array(
            "name" => $game->player[$i]->name,
            "email" => $game->player[$i]->email,
            "seat" => $game->player[$i]->seat,
            "finish" => TRUE,
        );
        $allfinish++;
        continue;
    }
    if ($player->finish == TRUE) {
        $allfinish++;
    }
}
if ($allfinish >= sizeof($game->player)) {
    $game->end = true;
    $ok = $db->updateJSON($id, $game) ? TRUE : FALSE;
    sendemail($id, $game->player);
    echo $ok ? "S" : "Error";
} else {
    $ok = $db->updateJSON($id, $game) ? TRUE : FALSE;
    echo $ok ? "S" : "Error";
}