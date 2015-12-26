<?php
    require "database.php";

    $db = new Database();

    $ret = $db->deleteRoom($_POST["room"]);

    if($ret) echo "true";
    else echo "false";
?>