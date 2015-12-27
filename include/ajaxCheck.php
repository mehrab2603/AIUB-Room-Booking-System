<?php
    require "database.php";
    header('Content-Type: text/xml');

    $db = new Database();
    echo "<?xml version=\"1.0\" ?>";
    echo "<data>";

    if(isset($_POST["username"])) {
        $username = $_POST["username"];
        $response = $db->isUsernameTaken($username);
        if($response) echo "<username>true</username>";
        else echo "<username>false</username>";
    }
    if(isset($_POST["email"])) {
        $email = $_POST["email"];
        $response = $db->isEmailTaken($email);
        if($response) echo "<email>true</email>";
        else echo "<email>false</email>";
    }
    if(isset($_POST["id"])) {
        $id = $_POST["id"];
        $response = $db->isIdTaken($id);
        if($response) echo "<id>true</id>";
        else echo "<id>false</id>";
    }

    if(isset($_POST["phone"])) {
        $phone = $_POST["phone"];
        $response = $db->isPhoneTaken($phone);
        if($response) echo "<phone>true</phone>";
        else echo "<phone>false</phone>";
    }

    if(isset($_POST["roomId"])) {
        $roomId = $_POST["roomId"];
        $response = $db->isRoomIdTaken($roomId);
        if($response) echo "<roomId>true</roomId>";
        else echo "<roomId>false</roomId>";
    }
    if(isset($_POST["course"])) {
        $room = $_POST["room"];
        $day = $_POST["day"];
        $course = $_POST["course"];
        $response = $db->isAlreadyScheduled($room, $day, $course);
        if($response) echo "<schedule>true</schedule>";
        else echo "<schedule>false</schedule>";
    }
    if(isset($_POST["schedule"])) {
        $arr = json_decode($_POST["schedule"]);
        $schedule = new RoomSchedule($arr->room, $arr->day, $arr->course, $arr->start, $arr->end);
        
        if($db->isScheduleClash($schedule)) echo "<clash>true</clash>";
        else {
            $arr = json_decode($_POST["data"]);
            $booking = new Booking($arr->id, $arr->room, $arr->user, $arr->course, $arr->start, $arr->end, $arr->date, $arr->type);
            if($db->isBookingClash($booking)) {
                echo "<clash>true</clash>";
            }
            else {
                echo "<clash>false</clash>";
            }
        }
    }

    echo "</data>";
    
?>