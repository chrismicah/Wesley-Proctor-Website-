<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer library files
require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

// Create object of PHPMailer class
$mail = new PHPMailer(true);

$output = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Common setup
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];
        $mail->Host = "localhost";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = false;
        $mail->Port = 25;

        // Set "From" address (you can set a default if necessary)
        $email = $_POST['email'];
        $mail->setFrom($email);
        $mail->addAddress('spearschristopher2002@gmail.com'); // All emails go here for testing
        $mail->addReplyTo($email);
        $mail->isHTML(true);

        // Determine which form was submitted
        if (isset($_POST['nonprofit_organization'])) {
            // Nonprofit Formation/Incorporation Form
            $mail->Subject = 'Nonprofit Formation/Incorporation';
            $mail->Body = "<h1>Nonprofit Formation/Incorporation</h1>
                            <p>Email: <u>{$email}</u></p>
                            <p>Phone: <u>{$_POST['phone']}</u></p>
                            <p>Nonprofit organization: <u>{$_POST['nonprofit_organization']}</u></p>
                            <p>Mailing address: <u>{$_POST['mailing_address']}</u></p>
                            <p>First and last name: <u>{$_POST['first_last_name']}</u></p>
                            <p>Social Security Number (SSN): <u>{$_POST['social_security_number']}</u></p>
                            <p>BRIEF mission statement: <u>{$_POST['brief_mission_statement']}</u></p>";

        } elseif (isset($_POST['name_llc'])) {
            // For-profit Business Formation Form
            $mail->Subject = 'For-profit Business Formation';
            $mail->Body = "<h1>For-profit Business Formation</h1>
                            <p>Email: <u>{$email}</u></p>
                            <p>Phone: <u>{$_POST['phone']}</u></p>
                            <p>Name of your LLC: <u>{$_POST['name_llc']}</u></p>
                            <p>Full name: <u>{$_POST['full_name']}</u></p>
                            <p>Purpose of your LLC: <u>{$_POST['llc_provide']}</u></p>
                            <p>Business Mailing address: <u>{$_POST['mailing_address']}</u></p>
                            <p>Owner of the LLC: <u>{$_POST['owner_of_the_llc']}</u></p>
                            <p>Employer Identification Number: <u>{$_POST['identification_number']}</u></p>";

        } elseif (isset($_POST['session'])) {
            // Consultation/Coaching Form
            $mail->Subject = 'Consultation/Coaching';
            $mail->Body = "<h1>Consultation/Coaching</h1>
                            <p>Email: <u>{$email}</u></p>
                            <p>Phone: <u>{$_POST['phone']}</u></p>
                            <p>Meeting Information: <u>{$_POST['our_meeting']}</u></p>
                            <p>Session Type: <u>{$_POST['coaching_session']}</u></p>
                            <p>Session Duration: <u>{$_POST['session']}</u></p>";

        } elseif (isset($_POST['speak'])) {
            // Speaking Engagement Form
            $mail->Subject = 'Speaking Engagement';
            $mail->Body = "<h1>Speaking Engagement</h1>
                            <p>Email: <u>{$email}</u></p>
                            <p>Date: <u>{$_POST['date']}</u></p>
                            <p>Speaking Duration: <u>{$_POST['speak']}</u></p>
                            <p>Topic: <u>{$_POST['topic']}</u></p>
                            <p>Number of Attendees: <u>{$_POST['attending']}</u></p>
                            <p>Fee: <u>{$_POST['cost']}</u></p>
                            <p>Additional Information: <u>{$_POST['information']}</u></p>";

        } elseif (isset($_POST['topic'])) {
            // Workshops/Trainings Form
            $mail->Subject = 'Workshops/Trainings';
            $mail->Body = "<h1>Workshops/Trainings</h1>
                            <p>Email: <u>{$email}</u></p>
                            <p>Date: <u>{$_POST['date']}</u></p>
                            <p>Speaking Duration: <u>{$_POST['speak']}</u></p>
                            <p>Topic: <u>{$_POST['topic']}</u></p>
                            <p>Number of Attendees: <u>{$_POST['attending']}</u></p>
                            <p>Fee: <u>{$_POST['cost']}</u></p>
                            <p>Additional Information: <u>{$_POST['information']}</u></p>";
        }

        // Send the email
        $mail->send();
        $output = '<div id="popup">
                    <h2>Thank you</h2>
                    <p>Form has been successfully submitted.</p>
                  </div>
                  <script>
                  var popup = document.querySelector("#popup").classList.add("active");
                  const close_btn = document.querySelector(".close-btn");
                  close_btn.addEventListener("click", () => {
                      var popup = document.querySelector("#popup");
                      popup.classList.remove("active");
                  });
                  </script>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <meta content="width=device-width,initial-scale=1" name="viewport">
  <meta content="description" name="description">
  <meta name="google" content="notranslate" />
  <meta content="Mashup templates have been developed by Orson.io team" name="author">

  <!-- Disable tap highlight on IE -->
  <meta name="msapplication-tap-highlight" content="no">
  
  <link href="./assets/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="./assets/favicon.ico" rel="icon">

  <title>W.P. Enterprise</title>  
  <link href="css/main.a3f694c0.css" rel="stylesheet">
</head>

<body>
  <!-- Add your content of header -->
  <?php include_once "includes/header.php";	 ?>

  
  <main>
    <?php echo $output; ?>
  </main>

  <?php include_once "includes/footer.php";	 ?>


  <script>
    document.addEventListener("DOMContentLoaded", function (event) {
      navActivePage();
    });
    const menu = document.querySelector('.dropdown-link');
    const dp_menu = document.querySelector('.dropdown-menu-1');
    menu.addEventListener('mouseenter', (e) => {
      dp_menu.classList.toggle('active');
    });
  </script>
  
  <script type="text/javascript">
    if(window.history.replaceState){
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  <script type="text/javascript" src="js/main.41beeca9.js"></script>
</body>

</html>
