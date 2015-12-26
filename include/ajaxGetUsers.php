<?php
    require "database.php";

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

    $database = new Database();

    echo "<data>";

    if(isset($_POST["single"])) {
        $u = $database->getUser($_POST["user"]);
        echo "<user>";

        echo "<username>".$u->getUsername()."</username>";
        echo "<password>".$u->getPassword()."</password>";
        echo "<fullname>".$u->getFullname()."</fullname>";
        echo "<id>".$u->getId()."</id>";
        echo "<position>".$u->getPosition()."</position>";
        echo "<department>".$u->getDepartment()."</department>";
        echo "<phone>".$u->getPhone()."</phone>";
        echo "<email>".$u->getEmail()."</email>";
        echo "<type>".$u->getType()."</type>";

        echo "</user>";
        
    }
    else {
        $userPerPage = isset($_POST["userPerPage"]) ? intval($_POST["userPerPage"]) : null;
        if(!isset($userPerPage)) $userPerPage = isset($_COOKIE["userPerPage"]) ? intval($_COOKIE["userPerPage"]) : 15;

        
        $page = isset($_POST["page"]) ? intval($_POST["page"]) : 0;
        $user = isset($_POST["user"]) ? $_POST["user"] : "";
        
        $userCount = $database->getUserCount($user);

        $pageRequired = ceil($userCount / $userPerPage);

        if($page >= $pageRequired) $page = $pageRequired - 1;
        else if($page < 0) $page = 0;

        $ret = $database->getUserList($user, $userPerPage, $page * $userPerPage);

        
        echo "<pageRequired>".$pageRequired."</pageRequired>";
        foreach($ret as $u) {
            echo "<user>";

            echo "<username>".$u->getUsername()."</username>";
            echo "<password>".$u->getPassword()."</password>";
            echo "<fullname>".$u->getFullname()."</fullname>";
            echo "<id>".$u->getId()."</id>";
            echo "<position>".$u->getPosition()."</position>";
            echo "<department>".$u->getDepartment()."</department>";
            echo "<phone>".$u->getPhone()."</phone>";
            echo "<email>".$u->getEmail()."</email>";
            echo "<type>".$u->getType()."</type>";

            echo "</user>";
        }
    }
    echo "</data>";

?>