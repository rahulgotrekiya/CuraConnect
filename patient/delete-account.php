<?php
    include_once("../includes/auth.php");
    requireLogin('p');
    $useremail = $_SESSION["user"];


//import database
include("../includes/connection.php");
$userrow = $database->query("select * from patient where pemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];


if ($_GET) {
    $id = $_GET["id"];
    $result001 = $database->query("select * from patient where pid=$id;");
    $email = ($result001->fetch_assoc())["pemail"];
    $sql = $database->query("delete from users where email='$email';");
    $sql = $database->query("delete from patient where pemail='$email';");
    //print_r($email);
    header("location: ../logout.php");
}
