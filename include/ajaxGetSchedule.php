<?php
    require "database.php";

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

    $db = new Database();

    echo "<data>";

    if(isset($_POST["single"])) {
        $s = $db->getRoom($_POST["schedule"]);
        echo "<schedule>";

        echo "<id>".$r->getId()."</id>";
        echo "<floor>".$r->getFloor()."</floor>";
        echo "<campus>".$r->getCampus()."</campus>";
        echo "<capacity>".$r->getCapacity()."</capacity>";
        echo "<type>".$r->getType()."</type>";

        echo "</schedule>";
        
    }
    else {
        $schedulePerPage = isset($_POST["schedulePerPage"]) ? intval($_POST["schedulePerPage"]) : null;
        if(!isset($schedulePerPage)) $schedulePerPage = isset($_COOKIE["schedulePerPage"]) ? intval($_COOKIE["schedulePerPage"]) : 15;

        
        $page = isset($_POST["page"]) ? intval($_POST["page"]) : 0;
        $room = $_POST["room"];
        $day = $_POST["day"];
        

        $ret = $db->getScheduleList($room, $day);
        
        $scheduleCount = count($ret);
        
        $pageRequired = ceil($scheduleCount / $schedulePerPage);
        
        if($page >= $pageRequired) $page = $pageRequired - 1;
        else if($page < 0) $page = 0;

        
        echo "<pageRequired>".$pageRequired."</pageRequired>";
        
        $skipped = 0;
        $taken = 0;
        $offset = $page * $schedulePerPage;
        
        foreach($ret as $r) {
            if($skipped < $offset) {$skipped++; continue;}
            echo "<schedule>";
            
            echo "<course>".$r->getCourse()."</course>";
            echo "<start>".$r->getStart()."</start>";
            echo "<end>".$r->getEnd()."</end>";

            echo "</schedule>";
            $taken++;
            if($taken == $schedulePerPage) break;
        }
    }
    echo "</data>";

?>