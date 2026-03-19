<?php
    include_once("../includes/auth.php");
    requireLogin('d');

if ($_GET) {
    // Import database
    include("../includes/connection.php");
    // Include mailer functions
    include("../includes/mailer.php");

    $id = $_GET["id"];
    $reason = isset($_GET["reason"]) ? $_GET["reason"] : "Unavailable doctor";

    // Get the current doctor's email
    $doctor_email = $_SESSION["user"];

    // Fetch appointment details before deletion
    $appointment_query = $database->query("SELECT a.appoid, a.apponum, a.appodate, 
                                          p.pid, p.pname, p.pemail, p.ptel, 
                                          s.title, s.scheduletime, 
                                          d.docname, d.specialties 
                                   FROM appointment a
                                   JOIN patient p ON a.pid = p.pid
                                   JOIN schedule s ON a.scheduleid = s.scheduleid
                                   JOIN doctor d ON d.docid = s.docid
                                   WHERE a.appoid='$id' AND d.docemail='$doctor_email'");

    if ($appointment_details = $appointment_query->fetch_assoc()) {
        // Security check - ensure the doctor can only cancel their own appointments
        // Get specialty name
        $specialty_query = $database->query("SELECT sname FROM specialties WHERE id = '{$appointment_details['specialties']}'");
        $specialty = ($specialty_query->fetch_assoc())["sname"];

        // Format appointment details
        $appointment_date = date('F j, Y', strtotime($appointment_details['appodate']));
        $appointment_time = date('g:i A', strtotime($appointment_details['scheduletime']));
        $transaction_id = "TRX" . sprintf('%06d', $appointment_details['appoid']);

        $formatted_appointment = "{$appointment_details['title']} - {$specialty} with Dr. {$appointment_details['docname']}";
        $formatted_datetime = "{$appointment_date} at {$appointment_time}";

        // Cancellation reason (from doctor)
        $cancellation_reason = "Cancelled by Dr. {$appointment_details['docname']}: $reason";

        // Delete the appointment
        $sql = $database->query("DELETE FROM appointment WHERE appoid='$id';");

        // Prepare cancellation details
        $cancellationDetails = [
            'email' => $appointment_details['pemail'],
            'name' => $appointment_details['pname'],
            'number' => $appointment_details['ptel'],
            'appointment_details' => $formatted_appointment . " on " . $formatted_datetime,
            'transaction_id' => $transaction_id,
            'refund_amount' => 200, // Your standard booking fee amount
            'refund_id' => 'REF' . time(), // Generate a simple refund reference ID
            'cancellation_reason' => $cancellation_reason
        ];

        // Send cancellation email
        sendCancellationNotification($cancellationDetails);

        // Log the cancellation
        error_log("Appointment ID: $id cancelled by doctor {$appointment_details['docname']}. Reason: $reason. Cancellation email sent to: {$appointment_details['pemail']}");

        // Success message
        $_SESSION["cancel_success"] = "Appointment cancelled successfully and patient has been notified.";
    } else {
        // Error message
        $_SESSION["cancel_error"] = "You can only cancel your own appointments.";
    }

    header("location: appointments.php");
}
