<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
$area = isset($_POST["area"]) ? $_POST["area"] : "" or exit("Please choose line");
$y = isset($_POST["y"]) ? $_POST["y"] : "" or exit("Please choose line");
$db = new JSONDatabase();
$game = $db->readJSON($id) or exit("No Such game");
if ($game->line == NULL) {
    $line = array();
} else {
    $line = $game->line;
}
if(array_search(array("area" => $area, "y" => $y), $line)>=0){
    $game->line = array_merge($line, array(array("area" => $area, "y" => $y)));
}
$ok = $db->updateJSON($id, $game) ? TRUE : FALSE;
echo $ok ? json_encode(array("success" => $ok)) : json_encode(array("success" => $ok, "message" => "Error!",));
