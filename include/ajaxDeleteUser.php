<?php
    require "database.php";

    $db = new Database();

    $ret = $db->deleteUser($_POST["user"]);

    if($ret) echo "true";
    else echo "false";
?>