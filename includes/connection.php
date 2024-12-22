<?php
$db_server = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'curaconnect';


$database = new mysqli($db_server, $db_user, $db_pass, $db_name);
if ($database->connect_error) {
    die("Connection failed:  " . $database->connect_error);
}
