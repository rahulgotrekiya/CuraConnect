<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Ensures the current session matches the required role.
 * Redirects to login if not authenticated or role mismatch.
 * 
 * @param string $requiredRole 'p' for patient, 'd' for doctor, 'a' for admin
 */
function requireLogin($requiredRole) {
    if (!isset($_SESSION["user"]) || empty($_SESSION["user"]) || $_SESSION["usertype"] != $requiredRole) {
        header("location: ../login.php");
        exit();
    }
}
?>
