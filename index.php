<?php
require "include/database.php";
session_start();

$db = new Database();
$user = $db->getUser("admin");

if(password_verify("admin", $user->getPassword())) {
    $_SESSION["user"] = $user;
    header("Location: user_panel.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
    </head>

    <body>
        <h4>hello world</h4>
    </body>
</html>
