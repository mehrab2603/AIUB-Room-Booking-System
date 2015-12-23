<?php
    require "database.php";

    $database = new Database();

    $userPerPage = isset($_POST["userPerPage"]) ? intval($_POST["userPerPage"]) : null;
    if(!isset($userPerPage)) $userPerPage = isset($_COOKIE["userPerPage"]) ? intval($_COOKIE["userPerPage"]) : 15;
    
    $userCount = $database->getUserCount();

    $pageRequired = ceil($userCount / $userPerPage);
    $page = isset($_POST["page"]) ? intval($_POST["page"]) : 0;

?>
    <h5>Users</h5>
    <hr />
<?php
?>