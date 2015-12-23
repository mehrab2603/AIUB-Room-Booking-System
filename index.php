<?php
require "include/database.php";
session_start();

$db = new Database();
$user = $db->getUser("admin");
if(password_verify("admin", $user->getPassword())) {
    $_SESSION["user"] = $user;
    header("Location: admin_panel.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
    </head>

    <body>
    </body>
</html>