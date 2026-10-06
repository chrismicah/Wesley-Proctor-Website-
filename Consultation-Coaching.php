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
    $email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(422);
        $output = '<div class="form-status" role="alert">Please provide a valid email address.</div>';
    } else {
    $name = htmlspecialchars(is_string($_POST['name'] ?? null) ? trim($_POST['name']) : '', ENT_QUOTES, 'UTF-8');
    $business_name = htmlspecialchars(is_string($_POST['business_name'] ?? null) ? trim($_POST['business_name']) : '', ENT_QUOTES, 'UTF-8');
    $phone= htmlspecialchars(is_string($_POST['phone'] ?? null) ? trim($_POST['phone']) : '', ENT_QUOTES, 'UTF-8');
    $session = htmlspecialchars(is_string($_POST['session'] ?? null) ? trim($_POST['session']) : '', ENT_QUOTES, 'UTF-8');
    $coaching_session = htmlspecialchars(is_string($_POST['coaching_session'] ?? null) ? trim($_POST['coaching_session']) : '', ENT_QUOTES, 'UTF-8');
    $our_meeting = htmlspecialchars(is_string($_POST['our_meeting'] ?? null) ? trim($_POST['our_meeting']) : '', ENT_QUOTES, 'UTF-8');

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
      $mail->setFrom('form@wesleyproctorenterprise.com', 'Wesley Proctor Enterprise');
      // Recipient Email ID where you want to receive emails
      $mail->addAddress('form@wesleyproctorenterprise.com');
       $mail->addReplyTo($email);

      $mail->isHTML(true);
      $mail->Subject = 'Consultation/Coaching';
      $mail->Body = "<h1 style=''>Consultation/Coaching</h1>
                          <br><br><h3>
                          Name: <u>$name</u> <br> <br>
                          Business name: <u>$business_name</u> <br> <br>
                          Email: <u>$email</u> <br> <br>
                          Phone: <u>$phone</u> <br> <br>
                          any information that would help you prepare for our meeting: <u>$our_meeting</u><br> <br>
                          Is this a consultation or coaching session: <u>$coaching_session</u> <br> <br>
                          Will your session be 30 minutes or 60 minutes: <u>$session</u> <br> <br>
                          </h3>";


      $mail->send();
           $output = '<div class="form-status" role="status">Thank you. Your form has been successfully submitted.</div>';
     }  catch (Exception $e) {
    http_response_code(503);
    $output = '<div class="form-status" role="alert">Your request could not be sent. Please <a href="./contact.html">email or call our team</a>.</div>';
    error_log('WPE form delivery failed: ' . $mail->ErrorInfo);
}
    }
  }

?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="Consultation &amp; coaching with Dr. Wesley Proctor."><meta name="theme-color" content="#173f42"><title>Consultation &amp; coaching | Wesley Proctor Enterprise</title><link rel="icon" href="./assets/favicon.ico"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link rel="stylesheet" href="./assets/site.css"><script src="./assets/site.js" defer></script></head><body data-wpe-version="2"><a class="skip" href="#main">Skip to content</a>
<header class="site-header"><div class="wrap header-inner">
<a class="brand" href="./index.html" aria-label="Wesley Proctor Enterprise home"><img class="brand-logo" src="./assets/images/WPE%20Logo%20(1).jpeg" width="62" height="45" alt=""><span class="brand-name">Wesley Proctor<small>Enterprise</small></span></a>
<button class="menu-button" type="button" aria-controls="site-navigation" aria-expanded="false">Menu +</button>
<nav class="site-nav" id="site-navigation" aria-label="Main navigation">
<a href="./about.html">Meet Dr. Proctor</a>
<details class="nav-details"><summary>Our services</summary><div class="nav-dropdown"><a href="./Nonprofit-Formation-Incorporation.php">Nonprofit formation</a><a href="./For-profit-Business-Formation.php">Business formation</a><a href="./Consultation-Coaching.php">Consultation &amp; coaching</a><a href="./Workshops-Trainings.php">Workshops &amp; training</a></div></details>
<details class="nav-details"><summary>Book Dr. Proctor</summary><div class="nav-dropdown"><a href="./speaking-engagement-form.php">Speaking engagements</a><a href="./workshop-seminar-training-form.php">Workshop & seminar booking</a></div></details>
<a href="./payment.html">Make a payment</a><a class="nav-cta" href="./contact.html">Let’s talk <span aria-hidden="true">↗</span></a></nav></div></header><main id="main"><section class="page-hero"><div class="wrap"><div class="breadcrumb"><a href="./index.html">Home</a><span aria-hidden="true">/</span><span>Consultation &amp; coaching</span></div><p class="eyebrow">Consultation &amp; coaching</p><h1>Consultation & coaching</h1><p>Wesley Proctor Enterprise</p></div></section><section class="section"><div class="wrap content-grid"><article class="service-overview"><p class="note" style="padding-bottom: 0;">(WPE) provides expert one-on-one and group consultation and coaching sessions for businesses/organizations and individuals. Sessions are 30-60-minutes each, (Monday – Friday). See Dr. Proctor’s calendar to schedule an appointment today! Be sure to describe the professional advice you are seeking, in the meeting description. Fees do apply.</p></article><div class="form-panel"><h2>Consultation/Coaching QUESTIONNAIRE!</h2><?php echo $output; ?><form action="" class="inquiry-form" method="post">
<div class="field"><label for="text">1. Please provide your name.</label><input class="form-control" id="text" maxlength="1000" name="name" required="" type="text"/></div>

<div class="field"><label for="text-2">2. Please provide your business name.</label><input class="form-control" id="text-2" maxlength="1000" name="business_name" type="text"/></div>

<div class="field"><label for="text-3">3. Please provide your email.</label><input autocomplete="email" class="form-control" id="text-3" maxlength="1000" name="email" required="" type="email"/></div>

<div class="field"><label for="text-4">4. Please provide your phone number.</label><input autocomplete="tel" class="form-control" id="text-4" maxlength="1000" name="phone" type="tel"/></div>

<div class="field"><label for="text-5">5. Is this a consultation or coaching session?</label><input class="form-control" id="text-5" maxlength="1000" name="coaching_session" type="text"/></div>

<div class="field"><label for="text-6">6. Please provide any information that would help you prepare for our meeting.</label><input class="form-control" id="text-6" maxlength="1000" name="our_meeting" type="text"/></div>

<label for="text-7">7. Will your session be 30 minutes or 60 minutes?</label>

<fieldset class="field"><legend>Session duration</legend><label class="radio-option" for="30_minutes"><input id="30_minutes" name="session" required="" type="radio" value="30 minutes"/>30 minutes</label><label class="radio-option" for="60_minutes"><input id="60_minutes" name="session" required="" type="radio" value="60 minutes"/>60 minutes</label></fieldset>


<input class="btn" id="submit" name="submit" type="submit" value="Submit request"/>
</form><p class="form-note">Prefer a conversation? <a href="./contact.html">Email or call our team.</a></p></div></div></section></main><footer class="site-footer"><div class="wrap"><div class="footer-grid"><div>
<a class="brand" href="./index.html"><img class="brand-logo" src="./assets/images/WPE%20Logo%20(1).jpeg" width="62" height="45" alt=""><span class="brand-name">Wesley Proctor<small>Enterprise</small></span></a><p class="footer-description">Helping people turn their purpose into organizations that make a difference.</p></div>
<div><p class="eyebrow footer-label">Explore</p><div class="footer-links"><a href="./about.html">Meet Dr. Proctor</a><a href="./index.html#services">Our services</a><a href="./speaking-engagement-form.php">Speaking & booking</a><a href="./calendar.html">Calendar</a><a href="./courses-trainings.html">Courses & resources</a><a href="./products.html">Products</a><a href="./payment.html">Make a payment</a></div></div>
<div><p class="eyebrow footer-label">Get in touch</p><div class="footer-links"><a href="mailto:wesleyproctorenterprise@gmail.com">wesleyproctorenterprise@gmail.com</a><a href="tel:4848366444">484-836-6444</a><a href="https://www.instagram.com/drwesleyproctor/" target="_blank" rel="noopener noreferrer">Follow Dr. Proctor on Instagram ↗</a></div></div></div>
<div class="footer-bottom"><span>© 2026 Wesley Proctor Enterprise, LLC</span><span>Business & education development.</span></div></div></footer></body></html>
