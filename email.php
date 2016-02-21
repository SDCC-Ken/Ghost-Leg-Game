<?php
require "Mailer/PHPMailerAutoload.php";
$email = "wingwingchan2002@gmail.com";
$name = "s";
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
$mail->Body = "Testing";
$mail->AltBody = "Testing";
$mail->send();