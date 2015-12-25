<?php
    require "database.php";

    $db = new Database();

    $arr = json_decode($_POST["data"]);

    $user = new User($arr->username, $arr->password, $arr->fullname, $arr->id, $arr->position, $arr->department, $arr->phone, $arr->email, $arr->type);

    $ret = $db->updateUser($user);

    if($ret) echo "true";
    else echo "false";
?>