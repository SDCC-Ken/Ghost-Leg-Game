<?php
include_once '../Class/JSONDatabase.php';
$id = isset($_GET["ID"]) ? $_GET["ID"] : "" or exit("No ID");
$db = new JSONDatabase();
$game = $db->readJSON(isset($_GET["ID"]) ? $_GET["ID"] : "") or exit("No Such game");
echo "S";