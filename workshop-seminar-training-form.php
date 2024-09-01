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
      // Gmail Password
      $mail->Password = 'dr.proctor54321';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption

      // Email ID from which you want to send the email
      $mail->setFrom($email);
      // Recipient Email ID where you want to receive emails
      $mail->addAddress('form@wesleyproctorenterprise.com');
       $mail->addReplyTo($email);

      $mail->isHTML(true);
      $mail->Subject = 'Workshop/ Seminar Training!';
      $mail->Body = "<h1 style=''>Workshop/ Seminar Training!</h1>
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
<style>
    #submit{
    width:150px ;
    background:#edeaf0;
    margin:10px 0 20px -30px;
    font-weight:bold;
}
</style>
</head>

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
            <li><a href="./calendar.html" title="">Calendar</a></li>
            <li><a href="./courses-trainings.html" title="">Courses/Training</a></li>
                </div>
              </li>
            <li><a href="./products.html">Products</a></li>  
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class="form-bg">
      <?php echo $output; ?>
    
      <div class="container">
          <div class="form-box">
          <div class="text">
              <h2>Book Dr. Proctor for a Workshop/ Seminar Training!</h2>
              <p>Please provide the following information:</p>
          </div>
          <form action="" method="post">
              <label for="text">1. Please provide your email.</label><br>
           <input type="email" name="email" id="text" required> <br><br>
               <label for="date">2. Date of Event?</label><br>
               <input type="date" name="date" id="date"><br><br>
               <label for="text-1">3. How long would you like for Dr. Proctor to speak?</label><br>
               <input type="text" name="speak" id="text-1"> <br><br>
               <label
                for="text-2">4.What topic would you like Dr. Proctor to speak on?</label><br>
               <input type="text" name="topic" id="text-2"> <br><br>
               <label for="text-3">5.How many people will be attending?</label><br>
               <input type="text" name="attending" id="text-3"><br><br>
               <label for="text-5">6. Does it cost a fee to attend this event?</label><br>
               <input type="radio" name="cost" id="yes" value="Yes" checked><label for="yes">Yes</label><br>
               <input type="radio" name="cost" id="no" value="No"><label for="no">No</label><br><br>
               <label for="text-6">7. Is there any other information you wish to provide?</label><br>
               <input type="text" name="information" id="text-6"> <br><br>
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
                        <h4>Contact Us!</h4>
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

</script>
<script type="text/javascript">
if(window.history.replaceState){
      window.history.replaceState(null, null, window.location.href);
    }
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

<script type="text/javascript" src="./main.41beeca9.js"></script></body>

</html>

<form action="send_form_mail.php" method="post">
<input type="hidden" name="form_type" value="speak">