<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
$name = $_POST['name'] or exit("No Name");
$db = new JSONDatabase();
$game = $db->readJSON($id) or exit("No Such game");
$ok = FALSE;
$haveseat = FALSE;
foreach($game->player AS $i => $player){
    if($player->name==$name){
        $ok = TRUE;
        break;
    }
    if($player->name==NULL){
        $game->player[$i] = array(
            "name" => $name,
            "seat" => NULL,
        );
        $ok = TRUE;
        break;
    }
}
if($ok && $db->updateJSON($id, $game)){
    echo "S";
}