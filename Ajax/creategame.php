<?php

include_once '../Class/Game.php';
include_once '../Class/JSONDatabase.php';

if (!file_exists(realpath(dirname(__FILE__) . "/json"))) {
    mkdir(dirname(__FILE__) . "/json");
}
$name = isset($_POST["name"]) ? $_POST["name"] : "" or exit("No Name");
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
    ));
} else {
    echo json_encode(array(
        "success" => FALSE,
        "error" => $return["message"],
    ));
}


