<?php

function sendemail($id, $email, $name) {
    require "../Mailer/PHPMailerAutoload.php";
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

$id = isset($_GET["ID"]) ? $_GET["ID"] : exit("No ID");
$name = isset($_POST["name"]) ? $_POST["name"] : exit("No Name");
$email = isset($_POST["email"]) ? $_POST["email"] : exit("No email");
echo json_encode(array(
    "success" => sendemail($id,$email, $name)
));
