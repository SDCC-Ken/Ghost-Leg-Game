<?php

function sendemail($email, $name) {
    require "../Mailer/PHPMailerAutoload.php";
    $id = isset($_POST["gameid"]) ? $_POST["gameid"] : "" ;
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = "mail.kwanwing.tk";
    $mail->SMTPAuth = true;
    $mail->Username = "kwanwing@kwanwing.tk";
    $mail->Password = "abcd1234!";
    $mail->Port = 25;
    $mail->setFrom("kwanwing@kwanwing.tk", "Ghost leg");
    $mail->addAddress($email, $name);
    $mail->isHTML(true);
    $mail->Subject = "You have create a Ghost leg game!";
    $mail->Body = ""
            . "<p>Dear" + $name + "</p>"
            . "<p>Hello, You have created the game. </p>"
            . "<p>You can come to the link to share to other if you haven't do it.</p>"
            . "<p><a href='http://spd4517ia.kwanwing.tk/share.php?ID=" + $id + "'>http://spd4517ia.kwanwing.tk/share.php?ID=" + $id + "</a></p>"
            . "<p>Regards,</p>"
            . "<p>Admin</p>";
    $mail->AltBody = ""
            . "Dear" + $name + "\n"
            . "Hello, You have created the game. \n"
            . "You can come to the link to share to other if you haven't do it.\n"
            . "Link: http://spd4517ia.kwanwing.tk/share.php?ID=" + $id + "\n"
            . "Regards,\n"
            . "Admin\n";
    return $mail->send();
}

include_once '../Class/Game.php';
include_once '../Class/JSONDatabase.php';
$name = isset($_POST["name"]) ? $_POST["name"] : "" or exit("No Name");
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$gameid = isset($_POST["gameid"]) ? $_POST["gameid"] : "" or exit("No Game ID");
$player = isset($_POST["player"]) ? $_POST["player"] : "" or exit("Please enter how many player");
$goals = isset($_POST["goals"]) ? json_decode($_POST["goals"]) : "" or exit("No Goals");
$success = false;
$checker = false;
if (!sizeof($goals) == $player) {
    exit("Please enter how many player");
}
$return = (new Game())->create($_POST);
if ($return["success"]) {
    echo json_encode(array(
        "success" => TRUE,
        "id" => $gameid,
        "email" => sendemail($email, $name),
    ));
} else {
    echo json_encode(array(
        "success" => FALSE,
        "error" => $return["message"],
    ));
}


