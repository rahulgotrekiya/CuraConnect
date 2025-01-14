<?php
if (!isset($_SESSION["user"]) || empty($_SESSION["user"]) || $_SESSION["usertype"] != 'a') {
    header("location: ../login.php");
    exit();
}
