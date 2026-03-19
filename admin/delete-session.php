<?php
    include_once("../includes/auth.php");
    requireLogin('a');


if ($_GET) {
    //import database
    include("../includes/connection.php");
    $id = $_GET["id"];
    $sql = $database->query("delete from schedule where scheduleid='$id';");
    header("location: schedule.php");
}
