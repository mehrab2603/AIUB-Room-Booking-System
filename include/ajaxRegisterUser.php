<?php
    require "database.php";

    $arr = json_decode($_POST["data"]);

    $user = new User($arr->username, $arr->password, $arr->fullName, $arr->id, $arr->position, $arr->department, $arr->phone, $arr->email, $arr->type);

    $db = new Database();

    $result = $db->insertUser($user);

    if($result) echo "true";
    else echo "false";
?>