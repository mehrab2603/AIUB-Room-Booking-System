<?php
    require "database.php";

    $arr = json_decode($_POST["data"]);

    $booking = new Booking($arr->id, $arr->room, $arr->user, $arr->course, $arr->start, $arr->end, $arr->date, $arr->type);

    $db = new Database();

    $ret = $db->insertBooking($booking);

    if($ret) echo "true";
    else echo "false";
?>