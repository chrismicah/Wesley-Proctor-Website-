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

  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $name_llc = $_POST['name_llc'];
    $mailing_address = $_POST['mailing_address'];
    $first_last_name = $_POST['full_name'];
    $owner_of_the_llc = $_POST['owner_of_the_llc'];
    $employer_identification_number = $_POST['identification_number'];
    $llc_provide = $_POST['llc_provide'];

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
      $mail->Subject = 'For-profit Business Formation';
      $mail->Body = "<h1 style=''>For-profit Business Formation</h1>
                          <br><br><h4>
                          Email: <u>$email</u> <br> <br>
                          Phone: <u>$phone</u> <br> <br>
                          Name of your LLC: <u>$name_llc</u> <br> <br>
                          Fullname: <u>$first_last_name</u> <br> <br>
                          Purpose of your LLC: <u>$llc_provide</u> <br> <br>
                          Business Mailing address: <u>$mailing_address</u> <br> <br>
                          Owner of the LLC: <u>$owner_of_the_llc</u> <br> <br>
                          Employer Identification Number: <u>$employer_identification_number</u>
                          </h4>";
                          
 
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