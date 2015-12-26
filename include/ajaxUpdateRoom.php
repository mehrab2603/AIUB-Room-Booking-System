<?php
    require "database.php";

    $db = new Database();

    $arr = json_decode($_POST["data"]);

    $room = new Room($arr->id, $arr->floor, $arr->campus, $arr->capacity, $arr->type);

    $ret = $db->updateRoom($room, $_POST["old"]);

    if($ret) echo "true";
    else echo "false";
?>