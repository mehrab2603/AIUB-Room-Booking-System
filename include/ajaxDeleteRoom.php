<?php
    require "database.php";

    $db = new Database();

    $ret = $db->deleteRoom($_POST["id"]);

    if($ret) echo "true";
    else echo "false";
?>