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
    $phone= $_POST['phone'];
    $session = $_POST['session'];
    $coaching_session = $_POST['coaching_session'];
    $our_meeting = $_POST['our_meeting'];

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
      // Gmail Password
      $mail->Password = 'dr.proctor54321';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption

      // Email ID from which you want to send the email
      $mail->setFrom($email);
      // Recipient Email ID where you want to receive emails
      $mail->addAddress('form@wesleyproctorenterprise.com');
       $mail->addReplyTo($email);

      $mail->isHTML(true);
      $mail->Subject = 'Consultation/Coaching';
      $mail->Body = "<h1 style=''>Consultation/Coaching</h1>
                          <br><br><h3>
                          Email: <u>$email</u> <br> <br>
                          Phone: <u>$phone</u> <br> <br>
                          any information that would help you prepare for our meeting: <u>$our_meeting</u><br> <br>
                          Is this a consultation or coaching session: <u>$coaching_session</u> <br> <br>
                          Will your session be 30 minutes or 60 minutes: <u>$session</u> <br> <br>
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <meta content="width=device-width,initial-scale=1" name="viewport">
  <meta content="description" name="description">
  <meta name="google" content="notranslate" />
  <meta content="Mashup templates have been developped by Orson.io team" name="author">

  <!-- Disable tap highlight on IE -->
  <meta name="msapplication-tap-highlight" content="no">
  
  <link href="./assets/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="./assets/favicon.ico" rel="icon">

 

  <title>W.P. Enterprise</title>  

<link href="css/main.a3f694c0.css" rel="stylesheet"></head>

<body>

 <!-- Add your content of header -->
 <?php include_once "includes/header.php";	 ?>

<main>
 <?php echo $output; ?>
 <div class="container">
<!-- three -->
<h4 class="list">Consultation/Coaching</h4>
<p class="note " style="padding-bottom: 0;">(WPE) provides expert one-on-one and group consultation and coaching sessions for businesses/organizations and individuals. Sessions are 30-60-minutes each, (Monday – Friday). See Dr. Proctor’s calendar to schedule an appointment today! Be sure to describe the professional advice you are seeking, in the meeting description. Fees do apply.</p>
 <!-- end  -->
 </div>
 <div class="container">
  <div class="form-box">
    <div class="text">
        <h2>Consultation/Coaching QUESTIONNAIRE!</h2>
        <p>Please provide the following information:</p>
    </div>
    <form action="" method="post">
    <label for="text">1. Please provide your name.</label><br>
    <input type="text" name="name" id="text" required><br><br>
    
    <label for="text-2">2. Please provide your business name.</label><br>
    <input type="text" name="business_name" id="text-2"><br><br>
    
    <label for="text-3">3. Please provide your email.</label><br>
    <input type="email" name="email" id="text-3" required><br><br>
    
    <label for="text-4">4. Please provide your phone number.</label><br>
    <input type="tel" name="phone" id="text-4"><br><br>
    
    <label for="text-5">5. Is this a consultation or coaching session?</label><br>
    <input type="text" name="coaching_session" id="text-5"><br><br>
    
    <label for="text-6">6. Please provide any information that would help you prepare for our meeting.</label><br>
    <input type="text" name="our_meeting" id="text-6"><br><br>
    
    <label for="text-7">7. Will your session be 30 minutes or 60 minutes?</label><br>
    <input type="radio" name="session" id="30_minutes" value="30 minutes">
    <label for="30_minutes">30 minutes</label><br>
    <input type="radio" name="session" id="60_minutes" value="60 minutes">
    <label for="60_minutes">60 minutes</label><br><br>
    
    <input type="submit" name="submit" value="Submit" id="submit">
</form>


    
</div>
</div>
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
  })
</script>
     <script type="text/javascript">
if(window.history.replaceState){
      window.history.replaceState(null, null, window.location.href);
    }
  </script

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID 

<script>
  
</script>

-->

<script type="text/javascript" src="js/main.41beeca9.js"></script></body>

</html>


<form action="send_form_mail.php" method="post">
<input type="hidden" name="form_type" value="session">
