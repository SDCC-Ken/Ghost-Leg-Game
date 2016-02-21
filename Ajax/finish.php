<?php

function sendemail() {
    require "../Mailer/PHPMailerAutoload.php";
    $id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
    $db = new JSONDatabase();
    $game = $db->readJSON($id) or exit("No Such game");
    $ok = false;
    foreach ($game->player AS $player) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = "mail.kwanwing.tk";
        $mail->SMTPAuth = true;
        $mail->Username = "kwanwing@kwanwing.tk";
        $mail->Password = "abcd1234!";
        $mail->Port = 25;
        $mail->setFrom("kwanwing@kwanwing.tk", "Ghost leg");
        $mail->addAddress($player->email, $player->name);
        $mail->isHTML(true);
        $mail->Subject = "You have create a Ghost leg game!";
        $mail->Body = "Testing2";
        $mail->AltBody = "Testing2";
        $ok = $mail->send();
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
    sendemail();
    echo $ok ? "S" : "Error";
} else {
    $ok = $db->updateJSON($id, $game) ? TRUE : FALSE;
    echo $ok ? "S" : "Error";
}