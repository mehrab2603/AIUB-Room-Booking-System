<?php
    require "database.php";

    $db = new Database();

    $ret = $db->deleteBooking($_POST["id"]);

    if($ret) echo "true";
    else echo "false";
?>