<?php
session_start();

if (!isset($_SESSION["user"]) || empty($_SESSION["user"]) || $_SESSION["usertype"] != 'p') {
    header("location: ../login.php");
    exit();
}

include("../includes/connection.php");

$pageTitle = (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'Dashboard' : ucfirst(basename($_SERVER['PHP_SELF'], ".php"));

$activePage = strtolower($pageTitle);

$useremail = $_SESSION['user'];

function shortenString($string, $length)
{
    return strlen($string) > $length ? substr($string, 0, $length) . '...' : $string;
}

$sqlmain = 'select * from patient where pemail=?';
$stmt = $database->prepare($sqlmain);
$stmt->bind_param('s', $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();

$userid = $userfetch['pid'];
$username = $userfetch['pname'];

date_default_timezone_set('Asia/Kolkata');

$today = date('Y-m-d');
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
    <title><?php echo 'Patient - ' . (isset($pageTitle) ? $pageTitle : 'Patient Panel'); ?></title>
</head>