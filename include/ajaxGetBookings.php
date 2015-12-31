<?php
    require "database.php";

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

    $db = new Database();

    echo "<data>";

    $bookingPerPage = isset($_POST["bookingPerPage"]) ? intval($_POST["bookingPerPage"]) : null;
    if(!isset($bookingPerPage)) $bookingPerPage = isset($_COOKIE["bookingPerPage"]) ? intval($_COOKIE["bookingPerPage"]) : 15;

    $page = isset($_POST["page"]) ? intval($_POST["page"]) : 0;
    $room = isset($_POST["room"]) ? $_POST["room"] : null;
    $user = isset($_POST["user"]) ? $_POST["user"] : null;
    $course = isset($_POST["course"]) ? $_POST["course"] : null;
    $start = isset($_POST["start"]) ? $_POST["start"] : null;
    $end = isset($_POST["end"]) ? $_POST["end"] : null;
    $date = isset($_POST["date"]) ? $_POST["date"] : null;
    $type = isset($_POST["type"]) ? $_POST["type"] : null;
    $like = isset($_POST["like"]) ? true : false;
    $expired = isset($_POST["expired"]) ? $_POST["expired"] : null;
    $order = isset($_POST["order"]) ? json_decode($_POST["order"]) : null;
    $dateRange = isset($_POST["dateRange"]) ? json_decode($_POST["dateRange"]) : null;

    $orderProcessed = array();
    if($order) {
        foreach($order as $o) {
            $orderProcessed[$o[0]] = $o[1]; 
        }
    }
    else {
        $orderProcessed = null;
    }


    $bookingCount = $db->getBookingCount(new Booking(-1, $room, $user, $course, $start, $end, $date, $type), $like, $dateRange, $expired);

    $pageRequired = ceil($bookingCount / $bookingPerPage);

    if($page >= $pageRequired) $page = $pageRequired - 1;
    else if($page < 0) $page = 0;

    $ret = $db->getBookingList(new Booking(-1, $room, $user, $course, $start, $end, $date, $type), $bookingPerPage, $page * $bookingPerPage, $dateRange, $expired, $orderProcessed, $like);


    echo "<pageRequired>".$pageRequired."</pageRequired>";
    foreach($ret as $b) {
        echo "<booking>";

        echo "<id>".$b->getId()."</id>";
        echo "<room>".$b->getRoom()."</room>";
        echo "<user>".$b->getUser()."</user>";
        echo "<course>".$b->getCourse()."</course>";
        echo "<start>".$b->getStart()."</start>";
        echo "<end>".$b->getEnd()."</end>";
        echo "<date>".$b->getClassDate()."</date>";
        echo "<type>".$b->getType()."</type>";

        echo "</booking>";
    }
    echo "</data>";

?>