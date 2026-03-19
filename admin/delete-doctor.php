<?php
    include_once("../includes/auth.php");
    requireLogin('a');


if ($_GET) {
    //import database
    include("../includes/connection.php");
    $id = $_GET["id"];
    $result001 = $database->query("select * from doctor where docid=$id;");
    $email = ($result001->fetch_assoc())["docemail"];
    $sql = $database->query("delete from users where email='$email';");
    $sql = $database->query("delete from doctor where docemail='$email';");
    //print_r($email);
    header("location: doctors.php");
}
