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

<link href="./main.a3f694c0.css" rel="stylesheet"></head>

<body>

 <!-- Add your content of header -->
 <header>
    <nav class="navbar  navbar-fixed-top navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle uarr collapsed" data-toggle="collapse" data-target="#navbar-collapse-uarr">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./index.html" title="">
            <img src="./assets/images/WPE Logo _new - Copy.jpeg" class="navbar-logo-img" alt="">
          </a>
        </div>
  
        <div class="collapse navbar-collapse" id="navbar-collapse-uarr">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./index.html" title="" class="active">Home</a></li>          
            <li><a href="./about.html" title=""> About Dr. Proctor</a></li>
            <li class="dropdown">
              <a class="dropbtn">Services</a>
              <div class="dropdown-content">
                <a href="./Nonprofit-Formation-Incorporation.php">Nonprofit Formation/Incorporation</a>
                <a href="./For-profit-Business-Formation.php">For-profit Business Formation</a>
                <a href="./Consultation-Coaching.php">Consultation/Coaching</a>
                <a href="./Workshops-Trainings.php">Workshops/Trainings</a>
              </div>
            </li>
            <li class="dropdown">
              <a class="dropbtn">Book Dr. Proctor </a>
              <div class="dropdown-content">
                  <a href="./speaking-engagement-form.php">Speaking Engagement</a>
                  <a href="./workshop-seminar-training-form.php">Workshop/Seminar Training</a>
                </div>
            </li>
            <li><a href="./payment.html">Payment</a></li>
            <li class="dropdown">
                <a class="dropbtn">Courses/Training </a>
                <div class="dropdown-content">
                    <a href="./make-keynote-address.html">Make Keynote Address</a>
                    <a href="./conference.html">Conference</a>
                    <a href="./guest-speaker-appearance.html">Guest Speaker Appearance</a>
                </div>
              </li>
             <li><a href="./products.html">Products</a></li
          </ul>
        </div>
      </div>
    </nav>
  </header>
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
         <label for="text">1. Please provide your email.</label><br>
           <input type="email" name="email" id="text" required> <br><br>
           <label for="text-2">2. Please provide your phone number.</label><br>
           <input type="phone" name="phone" id="text-2"> <br><br> 
         <label for="text-3">3. Please provide any information that would help you prepare for our meeting. </label><br>
         <input type="text" name="our_meeting" id="text-3">         
         <label for="text-4">4. Is this a consultation or coaching session?</label><br>
         <input type="text" name="coaching_session" id="text-4"> <br><br>
         <label for="text-5">5. Will your session be 30 minutes or 60 minutes?</label><br>
         <input type="text" name="session" id="text-5"> <br><br>
         <input type="submit" name="submit" value="Submit" id="submit">
    </form>
    
</div>
</div>
</main>
<footer>
    <div class="section-container footer-container">
        <div class="container">
            <div class="row">
                    <div class="col-md-4">
                        <h4>Follow Us!</h4>
                        <p><b id="docs-internal-guid-62ef645a-7fff-2554-0f63-2fddd702e798"><a href="https://www.instagram.com/drwesleyproctor/?igshid=NDRkN2NkYzU%3D"><img style="height: 50px; width: 50px; " src="./logo-ig-png-32473.png"></a></b></p>

                    </div>

                    <div class="col-md-4">
                        <h4>Contact Us</h4>
                        <p>
                        <p>Phone:<a style="color: blue;" href="tel:4848366444">484-836-6444</a></p>

                         <p>Email:<a style="color: blue;" href="mailto:wesleyproctorenterprise@gmail.com">wesleyproctorenterprise@gmail.com</a></p>

                        </p>
                    </div>

                    <div class="col-md-4">
                        <h4>Subscribe to newsletter</h4>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control footer-input-text">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-newsletter ">OK</button>
                                </div>
                            </div>
                        </div>


                    </div>
            </div>
        </div>
    </div>
</footer>

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

<script type="text/javascript" src="./main.41beeca9.js"></script></body>

</html>


<form action="send_form_mail.php" method="post">
<input type="hidden" name="form_type" value="session">
