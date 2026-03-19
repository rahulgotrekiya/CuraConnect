<?php
include_once("../includes/auth.php");
requireLogin('d');

include_once("../includes/connection.php");
include_once("../includes/functions.php");

$pageTitle = (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'Dashboard' : ucfirst(basename($_SERVER['PHP_SELF'], ".php"));

$activePage = strtolower($pageTitle);

$useremail = $_SESSION['user'];

$userrow = $database->query("select * from doctor where docemail='$useremail'");
$userfetch = $userrow->fetch_assoc();

$userid = $userfetch["docid"];
$username = $userfetch["docname"];

date_default_timezone_set('Asia/Kolkata');

$today = date('d-m-Y');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/fav.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/animations.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title><?php echo 'Doctor - ' . (isset($pageTitle) ? $pageTitle : 'Doctor Panel'); ?></title>
</head>