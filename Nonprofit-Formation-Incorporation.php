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
    $nonprofit_organization = $_POST['nonprofit_organization'];
    $mailing_address = $_POST['mailing_address'];
    $first_last_name = $_POST['first_last_name'];
    $social_security_number = $_POST['social_security_number'];
    $brief_mission_statement = $_POST['brief_mission_statement'];

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
      $mail->Subject = 'Nonprofit Formation/Incorporation';
      $mail->Body = "<h1 style=''>Nonprofit Formation/Incorporation</h1>
                          <br><br><h3>Email: <u>$email</u> <br> <br>
                          Phone: <u>$phone</u> <br> <br>
                          Nonprofit organization: <u>$nonprofit_organization</u> <br> <br>
                          Mailing address: <u>$mailing_address</u> <br> <br>
                          First and last name: <u>$first_last_name</u> <br> <br>
                          Social Security Number (SSN): <u>$social_security_number</u> <br> <br>
                          BRIEF mission statement: <u>$brief_mission_statement</u></h3>";
                          
 
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

<link href="./main.a3f694c0.css" rel="stylesheet">
</head>
<style>

</style>
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
            <li><a href="./courses-trainings.html" title="">Courses/Training</a></li>
              </li>
              <li><a href="./products.html">Products</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main id="main">
 <?php echo $output; ?>
  <div class="container">
  <h1 class="list">Nonprofit Formation/Incorporation </h1>
   <p class="note " style="padding-bottom: 0;">(WPE) will walk you through the step-by-step process of forming your nonprofit organization.This includes:</p>
  <ul class="numberlist">
    <li><p>Choosing a business name that is legally available in your state</p> </li>
    <li><p>File for an Employer Identification Number (EIN)</p></li>
    <li><p>Prepare and file your articles of incorporation with your state's corporate filing office (state fees required)</p></li>
    <li><p>Create bylaws that will dictate how the corporation will be operated.</p></li>
    <li class="last-li"><p>Apply for any licenses or permits that your corporation will need to operate in your state and local municipality.</p></li>
  </ul>
  <p class="note">If you are interested in establishing a nonprofit organization, please complete and submit the questionnaire below. Dr. Proctor or a WPE staff member will be in touch with you to schedule a follow-up meeting for next steps.</p>
  </div>
 
  <div class="container">
    <div class="form-box">
      <div class="text">
          <h2>NONPROFIT QUESTIONNAIRE!</h2>
          <p>Please provide the following information:</p>
      </div>
      <form action="" method="post">
           <label for="text">1. Please provide your email.</label><br>
           <input type="email" name="email" id="text" required> <br><br>
           <label for="text-2">2. Please provide your phone number.</label><br>
           <input type="phone" name="phone" id="text-2" required> <br><br> 
           <label for="text-3">3. Please provide the name of your nonprofit organization.</label><br>
           <input type="text" name="nonprofit_organization" id="text-3" required> <br><br>
           <label for="text-4">4. Please provide the complete mailing address of your nonprofit organization (this address can be your home address but cannot be a P.O. Box).</label><br>
           <input type="text" name="mailing_address" id="text-4" required> <br><br>
           <label for="text-5">5. Please provide the first and last name of the person who will serve as the main contact of the newly formed 501c3? (Please provide me with how their name should appear on all 501c3 documents.)</label><br>
           <input type="text" name="first_last_name" id="text-5" required> <br><br>
           <label for="text-6">6. Please provide the Social Security Number (SSN) of the person listed above in #3. Your (SSN) should match how your first and last name appears on your individual tax returns. We will need your (SSN) number once and only once to obtain your Employer Identification Number (EIN) from the IRS which we will obtain through the IRS business portal. We will not keep your (SSN) number or store it anywhere!</label><br>
           <input type="text" name="social_security_number" id="text-6" required><br><br>
           <label for="text-7">7. Please provide a BRIEF mission statement for the nonprofit organization. This statement should be no more than (2) sentences about what the organization does. Your mission statement does not have to be perfect but should provide a general overview of what your nonprofit organization is all about. (If you need a sample to refer to, please write "NEED SAMPLE").</label><br>
           <input type="text" name="brief_mission_statement" id="text-7" required> <br><br>
           <input type="submit" name="submit" value="submit" id="submit">
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
                        <p>Phone:<a style="color: blue;" href="tel:4848366444">484-836-6444</a></p>

                        <p>Email:<a style="color: blue;" href="mailto:wesleyproctorenterprise@gmail.com">wesleyproctorenterprise@gmail.com</a></p>
                        <p>
                           
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
  const eamil = document.getElementById('text-01');
  const regexp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if (!eamil.value.match(regexp)) {
// on error, we get into the condition
    // this.classList.add('error');
    console.log('error')
}
</script>

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

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID 

<script>
  (function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date(); a = s.createElement(o),
      m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
  })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
  ga('create', 'UA-XXXXX-X', 'auto');
  ga('send', 'pageview');
</script>

-->
     <script type="text/javascript">
if(window.history.replaceState){
      window.history.replaceState(null, null, window.location.href);
    }
  </script>

<script type="text/javascript" src="./main.41beeca9.js"></script></body>

</html>
<form action="send_form_mail.php" method="post">
<input type="hidden" name="form_type" value="nonprofit_organization">
