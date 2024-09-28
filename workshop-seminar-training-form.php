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

<link href="css/main.a3f694c0.css" rel="stylesheet">
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

<?php include_once "includes/header.php";	 ?>


  <main class="form-bg">
      <?php echo $output; ?>
    
      <div class="container">
          <div class="form-box">
          <div class="text">
              <h2>Book Dr. Proctor for a Workshop/ Seminar Training!</h2>
              <p>Please provide the following information:</p>
          </div>
          <form action="" method="post">
    <label for="name">1. Please provide your name.</label><br>
    <input type="text" name="name" id="name" required><br><br>

    <label for="org_name">2. Please provide the name of your organization.</label><br>
    <input type="text" name="org_name" id="org_name" required><br><br>

    <label for="email">3. Please provide your email.</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <label for="date">4. Date of Event?</label><br>
    <input type="date" name="date" id="date"><br><br>

    <label for="speak">5. How long would you like for Dr. Proctor to speak?</label><br>
    <select name="speak" id="speak">
        <option value="30 minutes">30 minutes</option>
        <option value="1 hour">1 hour</option>
        <option value="1.5 hours">1.5 hours</option>
        <option value="2 hours">2 hours</option>
    </select><br><br>

    <label for="topic">6. What topic would you like Dr. Proctor to speak on?</label><br>
    <input type="text" name="topic" id="topic"><br><br>

    <label for="attending">7. How many people will be attending?</label><br>
    <input type="text" name="attending" id="attending"><br><br>

    <label for="cost">8. Does it cost a fee to attend this event?</label><br>
    <input type="radio" name="cost" id="yes" value="Yes" checked><label for="yes">Yes</label><br>
    <input type="radio" name="cost" id="no" value="No"><label for="no">No</label><br><br>

    <label for="information">9. Is there any other information you wish to provide?</label><br>
    <input type="text" name="information" id="information"><br><br>

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

<script type="text/javascript" src="js/main.41beeca9.js"></script></body>

</html>

<form action="send_form_mail.php" method="post">
<input type="hidden" name="form_type" value="speak">