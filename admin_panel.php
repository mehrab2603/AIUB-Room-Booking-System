<?php
    require "include/classes.php";
    session_start();

    if(!isset($_SESSION["user"]) || $_SESSION["user"]->getType() != "admin") {
        header("Location: index.php");
    }
    $page = new AdminPanelPage("hello world");
    $page->display();
?>
