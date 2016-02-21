<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
$name = isset($_POST["name"]) ? $_POST["name"] : "" or exit("No Name");
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$db = new JSONDatabase();
$game = $db->readJSON($id) or exit("No Such game");
$ok = FALSE;
$seat = NULL;
$finish = FALSE;
foreach ($game->player AS $i => $player) {
    if ($player->name == $name) {
        $ok = TRUE;
        $seat = $player->seat;
        $finish = $player->finish;
        break;
    }
    if ($player->name == NULL) {
        $game->player[$i] = array(
            "name" => $name,
            "email" => $email,
            "seat" => NULL,
            "finish" => FALSE,
        );
        $ok = $db->updateJSON($id, $game)?TRUE:FALSE;
        break;
    }
}
if ($ok) {
    echo json_encode(array(
        "finish" => $finish,
        "success"=>$ok,
        "seat"=>$seat,
    ));
}else{
    echo json_encode(array(
        "success"=>$ok,
        "message"=>"Seat full. You can't join the game",
    ));
}