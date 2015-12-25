<?php
    require "database.php";
    header('Content-Type: text/xml');

    $db = new Database();
    echo "<?xml version=\"1.0\" ?>";

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
?>