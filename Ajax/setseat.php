<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] :  exit("No ID");
$name = isset($_POST["name"]) ? $_POST["name"] :  exit("No Name");
$seat = isset($_POST["seat"]) ? $_POST["seat"] :  exit("Please find a seat");
$db = new JSONDatabase();
$game = $db->readJSON($id) or exit("No Such game");
foreach ($game->player AS $i => $player) {
    if ($player->name == $name) {
        $game->player[$i] = array(
            "name" => $name,
            "seat" => $seat,
            "email" => $game->player[$i]->email,
            "finish" => FALSE,
        );
        echo $db->updateJSON($id, $game)?"S":"";
        break;
    }
}