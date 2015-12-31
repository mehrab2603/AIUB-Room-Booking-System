<?php
    require "database.php";

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

    echo "<data>";

    $db = new Database();
    $user = $_POST["user"];
    $date = $_POST["date"];

    //public function __construct($id, $room, $user, $course, $start, $end, $classDate, $type)
    //function getBookingList($booking, $limit, $offset, $dateRange, $expired, $order, $like)

    $expired = $db->getBookingList(new Booking(-1, null, $user, null, null, null, date("Y-m-d"), null), 1000000000, 0, null, "true", null, false);
    $valid = $db->getBookingList(new Booking(-1, null, $user, null, null, null, date("Y-m-d"), null), 1000000000, 0, null, "false", null, false);
    $expiredCount = count($expired);
    $validCount = count($valid);
    $total = $expiredCount + $validCount;

    echo "<total>$total</total>";
    echo "<expiredCount>$expiredCount</expiredCount>";
    echo "<validCount>$validCount</validCount>";

    echo "<expired>";
    foreach($expired as $b) {
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
    echo "</expired>";

    echo "<valid>";
    foreach($valid as $c) {
        echo "<booking>";

        echo "<id>".$c->getId()."</id>";
        echo "<room>".$c->getRoom()."</room>";
        echo "<user>".$c->getUser()."</user>";
        echo "<course>".$c->getCourse()."</course>";
        echo "<start>".$c->getStart()."</start>";
        echo "<end>".$c->getEnd()."</end>";
        echo "<date>".$c->getClassDate()."</date>";
        echo "<type>".$c->getType()."</type>";

        echo "</booking>";
    }
    echo "</valid>";

    echo "</data>";
?>