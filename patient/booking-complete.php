<?php
include("../includes/patient/header.php");
include("../includes/connection.php");
require_once("../includes/mailer.php");

if (!isset($_SESSION["user"])) {
    header('Location: ../login.php');
    exit();
}

$useremail = $_SESSION["user"];
$userrow = $database->query("SELECT * FROM patient WHERE pemail='" . $database->real_escape_string($useremail) . "'");
$userfetch = $userrow->fetch_assoc();

if (!$userfetch) {
    header('Location: ../login.php');
    exit();
}

$userid = $userfetch["pid"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["scheduleid"]) && isset($_POST["apponum"]) &&
        isset($_POST["card_number"]) && isset($_POST["expiry_date"]) && isset($_POST["cvv"])
    ) {
        $scheduleid = $database->real_escape_string($_POST["scheduleid"]);
        $apponum = $database->real_escape_string($_POST["apponum"]);
        $date = $database->real_escape_string($_POST["date"]);
        $transaction_id = 'TXN' . strtoupper(uniqid());

        $sql = "INSERT INTO appointment(pid, apponum, scheduleid, appodate, transaction_id, payment_status) 
                VALUES (?, ?, ?, ?, ?, 'PAID')";

        $stmt = $database->prepare($sql);
        $stmt->bind_param("iisss", $userid, $apponum, $scheduleid, $date, $transaction_id);

        if ($stmt->execute()) {
            $success = true;
            $message = "Your appointment has been successfully booked!";
            $appoid = $database->insert_id;

            $schedule_query = "SELECT doc.docname, sch.scheduledate, sch.scheduletime 
                             FROM schedule sch 
                             JOIN doctor doc ON sch.docid = doc.docid 
                             WHERE sch.scheduleid = ?";

            $stmt_schedule = $database->prepare($schedule_query);
            $stmt_schedule->bind_param("i", $scheduleid);
            $stmt_schedule->execute();
            $schedule_result = $stmt_schedule->get_result();
            $schedule_details = $schedule_result->fetch_assoc();

            $orderDetails = array(
                'email' => $userfetch['pemail'],
                'name' => $userfetch['pname'],
                'number' => $userfetch['ptel'],
                'transaction_id' => $transaction_id,
                'total_products' => "Appointment with Dr. " . $schedule_details['docname'] .
                    " on " . $schedule_details['scheduledate'] .
                    " at " . $schedule_details['scheduletime'],
                'total_price' => 'Contact clinic for fee details'
            );

            $emailSent = false;
            if (sendOrderConfirmation($orderDetails)) {
                $emailSent = true;
            }

            $stmt_schedule->close();
        } else {
            $success = false;
            $message = "Error booking appointment.";
        }

        $stmt->close();
    } else {
        $success = false;
        $message = "Missing required payment information.";
    }
} else {
    header('Location: schedule.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Booking Complete</title>
</head>

<body>
    <div class="container">
        <?php include '../includes/patient/sidebar.php'; ?>
        <div class="dash-body">
            <table border="0" width="100%" style="margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="schedule.php">
                            <button class="login-btn btn-primary-soft btn btn-icon-back"
                                style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                </tr>
            </table>

            <div class="booking-complete-container">
                <?php if ($success): ?>
                    <div class="success-message">
                        <h2>Booking Successful!</h2>
                        <p>Your appointment has been successfully booked!</p>
                        
                        <?php if (!$emailSent): ?>
                            <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; border: 1px solid #f5c6cb; margin-bottom: 20px; font-weight: 500;">
                                Note: The confirmation email could not be sent due to internal server issues, but your appointment has been successfully placed.
                            </div>
                        <?php endif; ?>

                        <div class="booking-details">
                            <p>Appointment Number: <?php echo htmlspecialchars($apponum); ?></p>
                            <p>Transaction ID: <?php echo htmlspecialchars($transaction_id); ?></p>
                            
                            <?php if ($emailSent): ?>
                                <p>A confirmation email has been sent to: <?php echo htmlspecialchars($useremail); ?></p>
                            <?php endif; ?>
                        </div>
                        <a href="appointment.php" class="btn btn-primary">View My Appointments</a>
                    </div>
                <?php else: ?>
                    <div class="error-message">
                        <h2>Booking Error</h2>
                        <p><?php echo htmlspecialchars($message); ?></p>
                        <a href="schedule.php" class="btn btn-primary">Return to Schedule</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <style>
        .booking-complete-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success-message {
            color: #155724;
            background-color: #d4edda;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .booking-details {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</body>

</html>