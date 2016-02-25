<?php
header('Content-Type: application/json;');
include_once '../Class/JSONDatabase.php';
if (isset($_GET["ID"])) {
    $db = new JSONDatabase();
    if ($db->readJSON($_GET["ID"])) {
        echo json_encode(
                array(
                    "success" => true,
                )
        );
    } else {
        echo json_encode(
                array(
                    "success" => false,
                    "message" => "No such game"
                )
        );
    }
} else {
    echo json_encode(
            array(
                "success" => false,
                "message" => "Please Enter ID"
            )
    );
}
