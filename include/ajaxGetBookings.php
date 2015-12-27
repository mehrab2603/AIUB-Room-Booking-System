<?php
    require "database.php";

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

    $db = new Database();

    echo "<data>";

    $bookingPerPage = isset($_POST["bookingPerPage"]) ? intval($_POST["bookingPerPage"]) : null;
    if(!isset($bookingPerPage)) $bookingPerPage = isset($_COOKIE["bookingPerPage"]) ? intval($_COOKIE["bookingPerPage"]) : 15;


    $page = isset($_POST["page"]) ? intval($_POST["page"]) : 0;
    $room = isset($_POST["room"]) ? $_POST["room"] : "";
    $user = isset($_POST["user"]) ? $_POST["user"] : "";
    $like = isset($_POST["like"]) ? true : false;

    $date =  isset($_POST["date"]) ? $_POST["date"] : "";
    $expired = isset($_POST["expired"]) ? $_POST["expired"] : "";

    $bookingCount = $db->getBookingCount($user, $room, $like, $date, $expired);

    $pageRequired = ceil($bookingCount / $bookingPerPage);

    if($page >= $pageRequired) $page = $pageRequired - 1;
    else if($page < 0) $page = 0;

    $ret = $db->getBookingList($user, $room, $like, $bookingPerPage, $page * $bookingPerPage, $date, $expired);


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