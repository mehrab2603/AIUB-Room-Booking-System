<?php
    require "database.php";

    $db = new Database();

    if(isset($_POST["all"])) {
        $ret = $db->deleteAllRoomDaySchedule($_POST["room"], $_POST["day"]);
        if($ret) echo "true";
        else echo "false";
    }
    else {
        $arr = json_decode($_POST["data"]);

        $schedule = new RoomSchedule($arr->room, $arr->day, $arr->course, $arr->start, $arr->end);

        $ret = $db->updateSchedule(new RoomSchedule($schedule->getRoom(), $schedule->getDay(), "", $schedule->getStart(), $schedule->getEnd()));
        if($ret) echo "true";
        else echo "false";
    }
    
?>