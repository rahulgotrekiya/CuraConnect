<?php
// Initialize dotenv if not already loaded (e.g. from mailer.php)
if (!isset($_ENV['DB_HOST'])) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->safeLoad();
}

$db_server = $_ENV['DB_HOST'];
$db_user = $_ENV['DB_USERNAME'];
$db_pass = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '';
$db_name = $_ENV['DB_DATABASE'];


$database = new mysqli($db_server, $db_user, $db_pass, $db_name);
if ($database->connect_error) {
    die("Connection failed:  " . $database->connect_error);
}