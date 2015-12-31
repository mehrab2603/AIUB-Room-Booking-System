<?php
    require "database.php";

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

    $db = new Database();

    echo "<data>";

    if(isset($_POST["single"])) {
        $r = $db->getRoom($_POST["id"]);
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
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $floor = isset($_POST["floor"]) ? $_POST["floor"] : null;
        $campus = isset($_POST["campus"]) ? $_POST["campus"] : null;
        $capacity = isset($_POST["capacity"]) ? $_POST["capacity"] : null;
        $type = isset($_POST["type"]) ? $_POST["type"] : null;
        $order = isset($_POST["order"]) ? json_decode($_POST["order"]) : null;
        
        $orderProcessed = array();
        if($order) {
            foreach($order as $o) {
                $orderProcessed[$o[0]] = $o[1]; 
            }
        }
        else {
            $orderProcessed = null;
        }
        
        if(count($order) == 0) $order = null;
        
        $roomCount = $db->getRoomCount(new Room($id, $floor, $campus, $capacity, $type), true);
        
        if($roomCount) {

            $pageRequired = ceil($roomCount / $roomPerPage);

            if($page >= $pageRequired) $page = $pageRequired - 1;
            else if($page < 0) $page = 0;

            //getRoomList($room, $limit, $offset, $order, $like)


            $ret = $db->getRoomList(new Room($id, $floor, $campus, $capacity, $type), $roomPerPage, $page * $roomPerPage, $orderProcessed, true);


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
    }
    echo "</data>";

?>