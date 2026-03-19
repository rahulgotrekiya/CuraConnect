<?php
/**
 * Shared database query functions to keep code DRY.
 */

if (!function_exists('shortenString')) {
    function shortenString($string, $length)
    {
        return strlen($string) > $length ? substr($string, 0, $length) . '...' : $string;
    }
}

/**
 * Validates and gets user details by email depending on role
 */
if (!function_exists('getUserByEmail')) {
    function getUserByEmail($database, $email, $role) {
        if ($role == 'p') {
            $stmt = $database->prepare("SELECT * FROM patient WHERE pemail=?");
        } else if ($role == 'd') {
            $stmt = $database->prepare("SELECT * FROM doctor WHERE docemail=?");
        } else if ($role == 'a') {
            $stmt = $database->prepare("SELECT * FROM admin WHERE aemail=?");
        } else {
            return null;
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        return ($res->num_rows > 0) ? $res->fetch_assoc() : null;
    }
}

/**
 * Gets dashboard counts for a given role
 */
if (!function_exists('getDashboardCounts')) {
    function getDashboardCounts($database) {
        $patientrow = $database->query("select * from patient;");
        $doctorrow = $database->query("select * from doctor;");
        $today = date('Y-m-d');
        $appointmentrow = $database->query("select * from appointment where appodate>='$today';");
        $schedulerow = $database->query("select * from schedule where scheduledate='$today';");
        
        return [
            'patients' => $patientrow->num_rows,
            'doctors' => $doctorrow->num_rows,
            'appointments' => $appointmentrow->num_rows,
            'sessions' => $schedulerow->num_rows
        ];
    }
}
?>
