<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!function_exists('sendOrderConfirmation')) {
    function sendOrderConfirmation($orderDetails)
    {
        try {
            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $_ENV['MAIL_PORT'];

            // Log connection attempt
            // error_log("Attempting SMTP connection to {$mail->Host}");

            // Recipients
            $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
            $mail->addAddress($orderDetails['email'], $orderDetails['name']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Appointment Confirmation - CuraConnect';

            // Create email body with style replicating the booking-complete-container
            $body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Appointment Confirmation</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
                
                body {
                    font-family: 'Inter', Arial, sans-serif;
                    line-height: 1.6;
                    margin: 0;
                    padding: 0;
                    background-color: #f5f5f5;
                }
                
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                }
                
                .booking-complete-container {
                    max-width: 600px;
                    margin: 20px auto;
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
                
                .booking-details {
                    margin: 20px 0;
                    padding: 15px;
                    background: #f8f9fa;
                    border-radius: 4px;
                    text-align: left;
                }
                
                .booking-details p {
                    margin: 8px 0;
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
                
                .header {
                    background: #007bff;
                    color: #ffffff;
                    padding: 20px;
                    text-align: center;
                    border-top-left-radius: 8px;
                    border-top-right-radius: 8px;
                }
                
                .header h2 {
                    margin: 0;
                    font-size: 24px;
                }
                
                .footer {
                    text-align: center;
                    padding: 20px;
                    background-color: #f8f9fa;
                    color: #6c757d;
                    font-size: 14px;
                    border-bottom-left-radius: 8px;
                    border-bottom-right-radius: 8px;
                }
                
                .footer p {
                    margin: 5px 0;
                }
                
                @media only screen and (max-width: 600px) {
                    .booking-complete-container {
                        margin: 10px;
                        padding: 20px;
                    }
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='booking-complete-container'>
                    <div class='header'>
                        <h2>Appointment Confirmation</h2>
                    </div>
                    
                    <div class='success-message'>
                        <h2>Booking Successful!</h2>
                        <p>Your appointment has been successfully scheduled.</p>
                    </div>
                    
                    <div class='booking-details'>
                        <p><strong>Patient Name:</strong> {$orderDetails['name']}</p>
                        <p><strong>Contact Number:</strong> {$orderDetails['number']}</p>
                        <p><strong>Appointment:</strong> {$orderDetails['total_products']}</p>
                        <p><strong>Transaction ID:</strong> {$orderDetails['transaction_id']}</p>
                        " . ($orderDetails['total_price'] ? "<p><strong>Fee:</strong> ₹ 200/-</p>" : "") . "
                    </div>
                    
                    <div>
                        <p>Thank you for choosing CuraConnect for your healthcare needs.</p>
                        <ahref='#' class='btn-primary'>View Your Appointments</a>
                    </div>
                    
                    <div class='footer'>
                        <p>If you have any questions, please don't hesitate to contact our support team.</p>
                        <p>© " . date('Y') . " CuraConnect. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </body>
        </html>";

            $mail->Body = $body;
            $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n\n"], $body));

            // Log email details
            error_log("Attempting to send email to: " . $orderDetails['email']);
            error_log("Email content prepared with transaction ID: " . $orderDetails['transaction_id']);

            $result = $mail->send();
            error_log("Email sent successfully");
            return true;
        } catch (Exception $e) {
            error_log("Mail Error: " . $e->getMessage());
            error_log("Mailer Error: " . isset($mail) ? $mail->ErrorInfo : 'Mail object not created');
            return false;
        }
    }
}

// For cancellation  
if (!function_exists('sendCancellationNotification')) {
    function sendCancellationNotification($cancellationDetails)
    {
        try {
            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $_ENV['MAIL_PORT'];

            // Log connection attempt
            error_log("Attempting SMTP connection to {$mail->Host} for cancellation notification");

            // Recipients
            $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
            $mail->addAddress($cancellationDetails['email'], $cancellationDetails['name']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Appointment Cancellation - CuraConnect';

            // Create email body with style similar to booking confirmation
            $body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Appointment Cancellation</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
                
                body {
                    font-family: 'Inter', Arial, sans-serif;
                    line-height: 1.6;
                    margin: 0;
                    padding: 0;
                    background-color: #f5f5f5;
                }
                
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                }
                
                .booking-complete-container {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 30px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }
                
                .cancellation-message {
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
                    text-align: left;
                }
                
                .booking-details p {
                    margin: 8px 0;
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
                
                .header {
                    background: #dc3545;
                    color: #ffffff;
                    padding: 20px;
                    text-align: center;
                    border-top-left-radius: 8px;
                    border-top-right-radius: 8px;
                }
                
                .header h2 {
                    margin: 0;
                    font-size: 24px;
                }
                
                .footer {
                    text-align: center;
                    padding: 20px;
                    background-color: #f8f9fa;
                    color: #6c757d;
                    font-size: 14px;
                    border-bottom-left-radius: 8px;
                    border-bottom-right-radius: 8px;
                }
                
                .footer p {
                    margin: 5px 0;
                }
                
                .refund-info {
                    background-color: #e2f3e7;
                    padding: 15px;
                    border-radius: 4px;
                    margin: 20px 0;
                }
                
                .cancellation-reason {
                    background-color: #fff3cd;
                    padding: 15px;
                    border-radius: 4px;
                    margin: 20px 0;
                    border-left: 4px solid #ffc107;
                }
                
                @media only screen and (max-width: 600px) {
                    .booking-complete-container {
                        margin: 10px;
                        padding: 20px;
                    }
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='booking-complete-container'>
                    <div class='header'>
                        <h2>Appointment Cancellation</h2>
                    </div>
                    
                    <div class='cancellation-message'>
                        <h2>Appointment Cancelled</h2>
                        <p>Your appointment has been cancelled.</p>
                    </div>";

            // Add cancellation reason if provided
            if (isset($cancellationDetails['cancellation_reason']) && !empty($cancellationDetails['cancellation_reason'])) {
                $body .= "
                    <div class='cancellation-reason'>
                        <h3>Cancellation Reason</h3>
                        <p>{$cancellationDetails['cancellation_reason']}</p>
                    </div>";
            }

            $body .= "
                    <div class='booking-details'>
                        <p><strong>Patient Name:</strong> {$cancellationDetails['name']}</p>
                        <p><strong>Contact Number:</strong> {$cancellationDetails['number']}</p>
                        <p><strong>Cancelled Appointment:</strong> {$cancellationDetails['appointment_details']}</p>
                        <p><strong>Transaction ID:</strong> {$cancellationDetails['transaction_id']}</p>
                        <p><strong>Cancellation Date:</strong> " . date('F j, Y, g:i a') . "</p>
                    </div>";

            // Add refund information if applicable
            if (isset($cancellationDetails['refund_amount']) && $cancellationDetails['refund_amount'] > 0) {
                $body .= "
                    <div class='refund-info'>
                        <h3>Refund Information</h3>
                        <p>Your refund of ₹{$cancellationDetails['refund_amount']} has been initiated.</p>
                        <p>Please allow 5-7 business days for the refund to reflect in your account.</p>
                        " . (isset($cancellationDetails['refund_id']) ? "<p><strong>Refund Reference ID:</strong> {$cancellationDetails['refund_id']}</p>" : "") . "
                    </div>";
            }

            $body .= "
                    <div>
                        <p>We're sorry for any inconvenience. If you'd like to reschedule, please visit our website.</p>
                        <a href='#' class='btn-primary'>Book New Appointment</a>
                    </div>
                    
                    <div class='footer'>
                        <p>If you have any questions, please don't hesitate to contact our support team.</p>
                        <p>© " . date('Y') . " CuraConnect. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </body>
        </html>";

            $mail->Body = $body;
            $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n\n"], $body));

            // Log email details
            error_log("Attempting to send cancellation email to: " . $cancellationDetails['email']);
            error_log("Cancellation email content prepared with transaction ID: " . $cancellationDetails['transaction_id']);

            $result = $mail->send();
            error_log("Cancellation email sent successfully");
            return true;
        } catch (Exception $e) {
            error_log("Cancellation Mail Error: " . $e->getMessage());
            error_log("Mailer Error: " . isset($mail) ? $mail->ErrorInfo : 'Mail object not created');
            return false;
        }
    }
}
