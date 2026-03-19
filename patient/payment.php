<?php
include("../includes/patient/header.php");
include("../includes/connection.php");

// Ensure we have booking data
if (!isset($_POST['scheduleid']) || !isset($_POST['apponum'])) {
    header('Location: schedule.php');
    exit();
}

$scheduleid = $_POST['scheduleid'];
$apponum = $_POST['apponum'];
$bookingDate = $_POST['date'] ?? date('Y-m-d');
$channeling_fee = 200.00;

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['card_number'])) {
    $card_number = $_POST['card_number'] ?? '';
    $expiry_date = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    // Basic validation
    if (
        strlen(str_replace(' ', '', $card_number)) === 16 &&
        preg_match('/^\d{2}\/\d{2}$/', $expiry_date) &&
        strlen($cvv) === 3
    ) {

        // Generate transaction ID
        $transaction_id = 'TXN' . strtoupper(uniqid());

        // Record payment
        $sql = "INSERT INTO payments (transaction_id, scheduleid, amount, payment_date) 
                VALUES (?, ?, ?, NOW())";
        $stmt = $database->prepare($sql);
        $stmt->execute([$transaction_id, $scheduleid, $channeling_fee]);

        // Redirect to booking completion
        header("Location: booking-complete.php?scheduleid=$scheduleid&apponum=$apponum&transaction_id=$transaction_id");
        exit();
    } else {
        $error_message = "Invalid payment details. Please check and try again.";
    }
}
?>

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
            <div style="padding: 20px;">
                <div class="payment-container">
                    <h2>Payment Details</h2>
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                    <?php endif; ?>

                    <div class="payment-summary">
                        <p>Appointment Number: <?= htmlspecialchars($apponum) ?></p>
                        <p>Channeling Fee: ₹ <?= number_format($channeling_fee, 2) ?></p>
                    </div>

                    <form action="booking-complete.php" method="POST" id="payment-form">
                        <input type="hidden" name="scheduleid" value="<?= htmlspecialchars($scheduleid) ?>">
                        <input type="hidden" name="apponum" value="<?= htmlspecialchars($apponum) ?>">
                        <input type="hidden" name="date" value="<?= htmlspecialchars($bookingDate) ?>">

                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" id="card_number" name="card_number" required class="form-control"
                                placeholder="1234 5678 9012 3456">
                            <div class="error-message" id="card-error"></div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Expiry Date</label>
                                <input type="text" id="expiry_date" name="expiry_date" required class="form-control"
                                    placeholder="MM/YY">
                                <div class="error-message" id="expiry-error" style="display: none;"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>CVV</label>
                                <input type="password" name="cvv" required maxlength="3" class="form-control"
                                    placeholder="123">
                                <div class="error-message" id="cvv-error"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary btn" style="width:100%;padding:10px;">
                            Pay Now (₹ <?= number_format($channeling_fee, 2) ?>)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            transition: all 0.3s ease;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            min-height: 20px;
        }

        .form-control.error {
            border-color: #dc3545;
        }

        .form-control.error:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .form-control.valid {
            border-color: #28a745;
        }

        .form-control.valid:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .payment-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .payment-summary {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>

    <script>
        // Format card number with spaces
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || '';
            e.target.value = formattedValue.substring(0, 19);
        });

        // Format expiry date
        document.getElementById('expiry_date').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }

            e.target.value = value.substring(0, 5);
            // Hide error message when user starts typing
            const errorElement = document.getElementById('expiry-error');
            errorElement.style.display = 'none';
            e.target.classList.remove('error');
        });

        // Validate expiry date
        document.getElementById('expiry_date').addEventListener('blur', function(e) {
            const value = e.target.value;
            const errorElement = document.getElementById('expiry-error');

            if (!value) return;

            const [month, year] = value.split('/').map(num => parseInt(num, 10));
            const currentDate = new Date();
            const currentYear = parseInt(currentDate.getFullYear().toString().slice(-2));
            const currentMonth = currentDate.getMonth() + 1;

            if (!month || !year || month < 1 || month > 12) {
                errorElement.textContent = 'Please enter a valid month (01-12)';
                errorElement.style.display = 'block';
                e.target.classList.add('error');
                e.target.classList.remove('valid');
                return;
            }

            if (year < currentYear || (year === currentYear && month < currentMonth)) {
                errorElement.textContent = 'Card has expired. Please use a valid card.';
                errorElement.style.display = 'block';
                e.target.classList.add('error');
                e.target.classList.remove('valid');
                return;
            }

            // If validation passes
            errorElement.style.display = 'none';
            e.target.classList.remove('error');
            e.target.classList.add('valid');
        });

        // Add validation for card number
        document.getElementById('card_number').addEventListener('blur', function(e) {
            const value = e.target.value.replace(/\s+/g, '');
            const errorElement = document.getElementById('card-error');

            if (value.length !== 16) {
                errorElement.textContent = 'Please enter a valid 16-digit card number';
                e.target.classList.add('error');
                e.target.classList.remove('valid');
            } else {
                errorElement.textContent = '';
                e.target.classList.remove('error');
                e.target.classList.add('valid');
            }
        });

        // Form submission validation
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            const cardNumber = document.getElementById('card_number');
            const expiryDate = document.getElementById('expiry_date');
            const errorElements = document.querySelectorAll('.error-message');
            const hasErrors = Array.from(errorElements).some(el => el.textContent !== '');

            if (hasErrors) {
                e.preventDefault();
            } else {
                // Show processing state
                const btn = e.target.querySelector('button[type="submit"]');
                btn.innerHTML = 'Processing Payment... Please wait <i class="fa fa-spinner fa-spin"></i>';
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.7';
            }
        });
    </script>