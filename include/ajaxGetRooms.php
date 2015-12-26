<?php
    require "database.php";

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

    $db = new Database();

    echo "<data>";

    if(isset($_POST["single"])) {
        $r = $db->getRoom($_POST["room"]);
        echo "<room>";

        echo "<id>".$r->getId()."</id>";
        echo "<floor>".$r->getFloor()."</floor>";
        echo "<campus>".$r->getCampus()."</campus>";
        echo "<capacity>".$r->getCapacity()."</capacity>";
        echo "<type>".$r->getType()."</type>";

        echo "</room>";
        
    }
    else {
        $roomPerPage = isset($_POST["roomPerPage"]) ? intval($_POST["roomPerPage"]) : null;
        if(!isset($roomPerPage)) $roomPerPage = isset($_COOKIE["roomPerPage"]) ? intval($_COOKIE["roomPerPage"]) : 15;

        
        $page = isset($_POST["page"]) ? intval($_POST["page"]) : 0;
        $room = isset($_POST["room"]) ? $_POST["room"] : "";
        
        $roomCount = $db->getRoomCount($room);

        $pageRequired = ceil($roomCount / $roomPerPage);

        if($page >= $pageRequired) $page = $pageRequired - 1;
        else if($page < 0) $page = 0;

        $ret = $db->getRoomList($room, $roomPerPage, $page * $roomPerPage);

        
        echo "<pageRequired>".$pageRequired."</pageRequired>";
        foreach($ret as $r) {
            echo "<room>";
            
            echo "<id>".$r->getId()."</id>";
            echo "<floor>".$r->getFloor()."</floor>";
            echo "<campus>".$r->getCampus()."</campus>";
            echo "<capacity>".$r->getCapacity()."</capacity>";
            echo "<type>".$r->getType()."</type>";

            echo "</room>";
        }
    }
    echo "</data>";

?>