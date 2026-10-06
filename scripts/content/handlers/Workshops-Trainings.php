<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader


require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

  // Include autoload.php file
 
  // Create object of PHPMailer class
  $mail = new PHPMailer(true);

  $output = '';
  $val = '';

  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $date = $_POST['date'];
    $speak = $_POST['speak'];
    $topic = $_POST['topic'];
    $attending = $_POST['attending'];
    $information = $_POST['information'];
    $radioVal = $_POST["cost"];


    try {
        $mail->SMTPDebug = 0;
        $mail->IsSMTP();
        $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];
        $mail->Host = "localhost";
        $mail->Debugoutput = 'html';
        $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_STARTTLS';
        $mail->SMTPAuth = false;
        $mail->Port = 25; 
 
      // Gmail ID which you want to use as SMTP server
      $mail->Username = 'form@wesleyproctorenterprise.com';


      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption

      // Email ID from which you want to send the email
      $mail->setFrom($email);
      // Recipient Email ID where you want to receive emails
      $mail->addAddress('form@wesleyproctorenterprise.com');
       $mail->addReplyTo($email);

      $mail->isHTML(true);
      $mail->Subject = 'Workshops/Trainings';
      $mail->Body = "<h1 style=''>Workshops/Trainings</h1>
                          <br><br><h3>
                          Email: <u>$email</u> <br> <br>
                          Date: <u>$date</u> <br> <br>
                          How long would you like for Dr. Proctor to speak: <u>$speak</u><br> <br>
                          What topic would you like Dr. Proctor to speak on: <u>$topic</u> <br> <br>
                          How many people will be attending: <u>$attending</u> <br> <br>
                          Does it cost a fee to attend this event: <u>$radioVal</u> <br> <br>
                          Is there any other information you wish to provide: <u>$information</u> <br> <br>
                          </h3>";
                          
 
      $mail->send();
           $output = '<div id="popup">
      <img src="./assets/images/right-arrow.png" >
      <img src="./assets/images/close.png" class="close-btn">
      <h2>Thank you</h2>
      <p>Form has been successfully submitted.</p>
    </div>
    <script>
    var popup = document.querySelector("#popup").classList.add("active");
    const close_btn = document.querySelector(".close-btn");
    close_btn.addEventListener("click", () => {
    var popup = document.querySelector("#popup");
    popup.classList.remove("active");
})
    </script>
    ';
     }  catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
  }

?>