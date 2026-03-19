<?php
    include_once("../includes/auth.php");
    requireLogin('a');

if ($_GET) {
    // Import database
    include("../includes/connection.php");
    // Include mailer functions
    include("../includes/mailer.php");

    $id = $_GET["id"];

    // Fetch appointment details before deletion
    $appointment_query = $database->query("SELECT a.appoid, a.apponum, a.appodate, 
                                          p.pid, p.pname, p.pemail, p.ptel, 
                                          s.title, s.scheduletime, 
                                          d.docname, d.specialties 
                                   FROM appointment a
                                   JOIN patient p ON a.pid = p.pid
                                   JOIN schedule s ON a.scheduleid = s.scheduleid
                                   JOIN doctor d ON s.docid = d.docid
                                   WHERE a.appoid='$id'");

    if ($appointment_details = $appointment_query->fetch_assoc()) {
        // Get specialty name
        $specialty_query = $database->query("SELECT sname FROM specialties WHERE id = '{$appointment_details['specialties']}'");
        $specialty = ($specialty_query->fetch_assoc())["sname"];

        // Format appointment details
        $appointment_date = date('F j, Y', strtotime($appointment_details['appodate']));
        $appointment_time = date('g:i A', strtotime($appointment_details['scheduletime']));

        $formatted_appointment = "{$appointment_details['title']} - {$specialty} with Dr. {$appointment_details['docname']}";
        $formatted_datetime = "{$appointment_date} at {$appointment_time}";

        // Generate a transaction ID based on appointment ID
        $transaction_id = "TRX" . sprintf('%06d', $appointment_details['appoid']);

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
            'cancellation_reason' => 'Cancelled by Administrator' // Add reason for admin cancellation
        ];

        // Send cancellation email
        sendCancellationNotification($cancellationDetails);

        // Log the cancellation
        error_log("Appointment ID: $id cancelled by admin. Cancellation email sent to: {$appointment_details['pemail']}");
    }

    header("location: appointment.php");
}
