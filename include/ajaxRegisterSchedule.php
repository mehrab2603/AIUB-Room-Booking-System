<?php
    require "database.php";

    $arr = json_decode($_POST["data"]);

    $schedule = new RoomSchedule($arr->room, $arr->day, $arr->course, $arr->start, $arr->end);

    $db = new Database();

    if($db->isScheduleCreated($schedule)) {
        if($db->isScheduleClash($schedule)) {echo "clash"; return;}
        
        $result = $db->updateSchedule($schedule);
        
        if($result) echo "true";
        else echo "false";
    }
    else {
        $result = $db->insertSchedule($schedule);
        if($result) echo "true";
        else echo "false";
    }
?>