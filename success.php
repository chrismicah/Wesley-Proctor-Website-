<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/PHPMailer.php';
require 'phpMailer/Exception.php';
require 'phpMailer/SMTP.php';
require 'stripe-php-15.7.0-beta.1/init.php';

\Stripe\Stripe::setApiKey('your_stripe_secret_key');

$mail = new PHPMailer(true);

// Assuming the session ID is passed in the URL
$session_id = $_GET['session_id'];

if ($session_id) {
    try {
        $session = \Stripe\Checkout\Session::retrieve($session_id);
        $email = $session->customer_details->email;

        // Send confirmation email
        $mail->setFrom('your-email@example.com', 'Your Name');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your Payment was Successful';
        $mail->Body = 'Thank you for your payment! Please schedule your consultation using the link below.';

        $mail->send();

        echo '<h2>Payment Successful</h2>';
        echo '<p>Thank you for your payment! A confirmation email has been sent to you.</p>';
        echo '<p>Please use the Calendly link below to schedule your session:</p>';
        echo '<div class="calendly-inline-widget" data-url="https://calendly.com/your-calendly-url" style="min-width:320px;height:630px;"></div>';
        echo '<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>';

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo '<h2>Error</h2>';
    echo '<p>No session ID found. Please try again.</p>';
}
?>
