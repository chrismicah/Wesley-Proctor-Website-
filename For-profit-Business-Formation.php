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
      // Gmail Password
      $mail->Password = 'dr.proctor54321';
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

<?php include_once "includes/footer.php";	 ?>

  <main>
       <?php echo $output; ?>
  <div class="container">
  <h4 class="list">For-profit Business Formation</h4>
  <p class="note " style="padding-bottom: 0;">(WPE) will walk you through the step-by-step process of forming your for-profit organization. This includes:</p>
  <ul class="numberlist">
    <li><p>	Choose a Business Name</p> </li>
    <li><p>	Choose a Business Entity</p></li>
    <li><p>	Get a Copy of Your State’s LLC Article of Organization Form</p></li>
    <li><p>	Prepare the LLC Article of Organization Form</p></li>
    <li class="last-li"><p>	Create an Operating Agreement</p></li>
  </ul>
  <p class="note">If you are interested in establishing a for-profit business, please complete and submit the questionnaire below. Dr. Proctor or a WPE staff member will be in touch with you to schedule a follow-up meeting for next steps.</p>
  </div>
 
  <div class="container">
    <div class="form-box">
      <div class="text">
          <h2>For-profit QUESTIONNAIRE!</h2>
          <p>Please provide the following information:</p>
      </div>
      <form action="" method="post">
           <label for="text">1. Please provide your email.</label><br>
           <input type="email" name="email" id="text" required> <br><br>
           <label for="text-2">2. Please provide your phone number.</label><br>
           <input type="phone" name="phone" id="text-2" required> <br><br> 
           <label for="text-3">3. Please provide the name of your LLC.</label><br>
           <input type="text" name="name_llc" id="text-3">
           <label for="text-4">4. Please provide your full name (First and Last Name). </label><br>
           <input type="text" name="full_name" id="text-4">
           <label for="text-5">5. What is the purpose of your LLC? What kind of service(s) will the LLC provide? </label><br>
           <input type="text" name="llc_provide" id="text-5"> <br><br>
           <label for="text-6">6. Please provide your business mailing address below. This can be your home address, however, we cannot use a P.O. Box as an address.</label><br>
           <input type="text" name="mailing_address" id="text-6"> <br><br>
           <label for="text-7">7. Will you be the only owner of the LLC or is there someone else ? If so, I will need their complete name and mailing address and what percentage of the LLC they will own?  </label><br>
           <input type="text" name="owner_of_the_llc" id="text-7"><br><br>
           <label for="text-8">8. Finally, I will also need to obtain an Employer Identification Number (EIN) from the IRS which you and I will have to obtain together online through the IRS. For this phase of the process, I will need your Social Security Number (SSN). Please list your (SSN) below.  .</label><br>
           <input type="text" name="identification_number" id="text-8"> <br><br>
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
<input type="hidden" name="form_type" value="name_llc">