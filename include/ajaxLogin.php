<?php
    require "database.php";

    session_start();

    $db = new Database();

    if(isset($_POST["username"]) && isset($_POST["password"])) {
        if($db->isUsernameTaken($_POST["username"])) {
            $user = $db->getUser($_POST["username"]);
            if(password_verify($_POST["password"], $user->getPassword())) {
                $_SESSION["user"] = $user;
                if(isset($_POST["checked"])) {setcookie("user", $user->getUsername(), time() + (86400 * 30), "/");}
                if($user->getType() == "admin") echo "admin";
                else echo "user";
            }
            else echo "false";
        }
        else echo "false";
    }
?>