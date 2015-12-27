<?php
    require "database.php";
    session_start();

    $db = new Database();

    $arr = json_decode($_POST["data"]);

    $user = new User($arr->username, $arr->password, $arr->fullname, $arr->id, $arr->position, $arr->department, $arr->phone, $arr->email, $arr->type);

    if(isset($_POST["changeUser"]) && !isset($_POST["password"])) {
        $user = new User($arr->username, "", $arr->fullname, $arr->id, $arr->position, $arr->department, $arr->phone, $arr->email, $arr->type);
    }

    $ret = $db->updateUser($user);

    if($ret) {
        if(isset($_POST["changeUser"])) {
            $_SESSION["user"] = $db->getUser($user->getUsername());
        }
        echo "true";
    }
    else echo "false";
?>