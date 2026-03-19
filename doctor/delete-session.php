<?php
    include_once("../includes/auth.php");
    requireLogin('d');


if ($_GET) {
    //import database
    include("../includes/connection.php");
    $id = $_GET["id"];
    //$result001= $database->query("select * from schedule where scheduleid=$id;");
    //$email=($result001->fetch_assoc())["docemail"];
    $sql = $database->query("delete from schedule where scheduleid='$id';");
    //$sql= $database->query("delete from doctor where docemail='$email';");
    //print_r($email);
    header("location: sessions.php");
}
