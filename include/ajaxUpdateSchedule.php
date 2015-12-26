<?php
    require "database.php";

    $db = new Database();

    $arr = json_decode($_POST["data"]);
    $arr2 = json_decode($_POST["old"]);

    $newSchedule = new RoomSchedule($arr->room, $arr->day, $arr->course, $arr->start, $arr->end);
    $oldSchedule = new RoomSchedule($arr2->room, $arr2->day, $arr2->course, $arr2->start, $arr2->end);

    $ret = $db->updateSchedule(new RoomSchedule($oldSchedule->getRoom(), $oldSchedule->getDay(), "", $oldSchedule->getStart(), $oldSchedule->getEnd()));
    if($ret) {
        if($db->isScheduleClash($newSchedule)) {
            $db->updateSchedule($oldSchedule);
            echo "clash";
        }
        else {
            $db->updateSchedule($newSchedule);
            echo "true";
        }
    }
    else {
        echo "false";
    }
?>