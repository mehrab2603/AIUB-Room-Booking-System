<?php
    session_start();

    if(isset($_COOKIE["user"])) unset($_COOKIE["user"]);
    if(isset($_SESSION["user"])) unset($_SESSION["user"]);
    
    setcookie("user", null, -1, '/');
    session_destroy();
    
    echo "true";
?>