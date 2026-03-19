<?php
    include_once("../includes/auth.php");
    requireLogin('a');


if ($_POST) {
    //import database
    include("../includes/connection.php");
    $title = $_POST["title"];
    $docid = $_POST["docid"];
    $nop = $_POST["nop"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $sql = "insert into schedule (docid,title,scheduledate,scheduletime,nop) values ($docid,'$title','$date','$time',$nop);";
    $result = $database->query($sql);
    header("location: schedule.php?action=session-added&title=$title");
}
