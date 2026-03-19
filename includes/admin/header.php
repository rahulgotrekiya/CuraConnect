<?php
include_once("../includes/auth.php");
requireLogin('a');

include_once("../includes/connection.php");
include_once("../includes/functions.php");

$pageTitle = (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'Dashboard' : ucfirst(basename($_SERVER['PHP_SELF'], ".php"));

$activePage = strtolower($pageTitle);

$useremail = $_SESSION['user'];

$sqlmain = 'select * from patient where pemail=?';
$stmt = $database->prepare($sqlmain);
$stmt->bind_param('s', $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();
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
    <title><?php echo 'Admin - ' . (isset($pageTitle) ? $pageTitle : 'Admin Panel'); ?></title>
</head>