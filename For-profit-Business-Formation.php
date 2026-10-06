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
    $email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(422);
        $output = '<div class="form-status" role="alert">Please provide a valid email address.</div>';
    } else {
    $phone = htmlspecialchars(is_string($_POST['phone'] ?? null) ? trim($_POST['phone']) : '', ENT_QUOTES, 'UTF-8');
    $name_llc = htmlspecialchars(is_string($_POST['name_llc'] ?? null) ? trim($_POST['name_llc']) : '', ENT_QUOTES, 'UTF-8');
    $mailing_address = htmlspecialchars(is_string($_POST['mailing_address'] ?? null) ? trim($_POST['mailing_address']) : '', ENT_QUOTES, 'UTF-8');
    $first_last_name = htmlspecialchars(is_string($_POST['full_name'] ?? null) ? trim($_POST['full_name']) : '', ENT_QUOTES, 'UTF-8');
    $owner_of_the_llc = htmlspecialchars(is_string($_POST['owner_of_the_llc'] ?? null) ? trim($_POST['owner_of_the_llc']) : '', ENT_QUOTES, 'UTF-8');
    $employer_identification_number = htmlspecialchars(is_string($_POST['identification_number'] ?? null) ? trim($_POST['identification_number']) : '', ENT_QUOTES, 'UTF-8');
    $llc_provide = htmlspecialchars(is_string($_POST['llc_provide'] ?? null) ? trim($_POST['llc_provide']) : '', ENT_QUOTES, 'UTF-8');

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
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="Business formation with Dr. Wesley Proctor."><meta name="theme-color" content="#173f42"><title>Business formation | Wesley Proctor Enterprise</title><link rel="icon" href="./assets/favicon.ico"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link rel="stylesheet" href="./assets/site.css"><script src="./assets/site.js" defer></script></head><body data-wpe-version="2"><a class="skip" href="#main">Skip to content</a>
<header class="site-header"><div class="wrap header-inner">
<a class="brand" href="./index.html" aria-label="Wesley Proctor Enterprise home"><img class="brand-logo" src="./assets/images/WPE%20Logo%20(1).jpeg" width="62" height="45" alt=""><span class="brand-name">Wesley Proctor<small>Enterprise</small></span></a>
<button class="menu-button" type="button" aria-controls="site-navigation" aria-expanded="false">Menu +</button>
<nav class="site-nav" id="site-navigation" aria-label="Main navigation">
<a href="./about.html">Meet Dr. Proctor</a>
<details class="nav-details"><summary>Our services</summary><div class="nav-dropdown"><a href="./Nonprofit-Formation-Incorporation.php">Nonprofit formation</a><a href="./For-profit-Business-Formation.php">Business formation</a><a href="./Consultation-Coaching.php">Consultation &amp; coaching</a><a href="./Workshops-Trainings.php">Workshops &amp; training</a></div></details>
<details class="nav-details"><summary>Book Dr. Proctor</summary><div class="nav-dropdown"><a href="./speaking-engagement-form.php">Speaking engagements</a><a href="./workshop-seminar-training-form.php">Workshop & seminar booking</a></div></details>
<a href="./payment.html">Make a payment</a><a class="nav-cta" href="./contact.html">Let’s talk <span aria-hidden="true">↗</span></a></nav></div></header><main id="main"><section class="page-hero"><div class="wrap"><div class="breadcrumb"><a href="./index.html">Home</a><span aria-hidden="true">/</span><span>Business formation</span></div><p class="eyebrow">Business formation</p><h1>Business formation</h1><p>Wesley Proctor Enterprise</p></div></section><section class="section"><div class="wrap content-grid"><article class="service-overview"><p class="note" style="padding-bottom: 0;">(WPE) will walk you through the step-by-step process of forming your for-profit organization. This includes:</p><p class="note">If you are interested in establishing a for-profit business, please complete and submit the questionnaire below. Dr. Proctor or a WPE staff member will be in touch with you to schedule a follow-up meeting for next steps.</p><ul class="numberlist">
<li><p>	Choose a Business Name</p> </li>
<li><p>	Choose a Business Entity</p></li>
<li><p>	Get a Copy of Your State’s LLC Article of Organization Form</p></li>
<li><p>	Prepare the LLC Article of Organization Form</p></li>
<li class="last-li"><p>	Create an Operating Agreement</p></li>
</ul></article><div class="form-panel"><h2>For-profit QUESTIONNAIRE!</h2><?php echo $output; ?><form action="" class="inquiry-form" method="post">
<div class="field"><label for="text">1. Please provide your email.</label><input autocomplete="email" class="form-control" id="text" maxlength="1000" name="email" required="" type="email"/></div>

<div class="field"><label for="text-2">2. Please provide your phone number.</label><input autocomplete="tel" class="form-control" id="text-2" maxlength="1000" name="phone" required="" type="tel"/></div>

<div class="field"><label for="text-3">3. Please provide the name of your LLC.</label><input class="form-control" id="text-3" maxlength="1000" name="name_llc" type="text"/></div>

<div class="field"><label for="text-4">4. Please provide your full name (First and Last Name). </label><input class="form-control" id="text-4" maxlength="1000" name="full_name" type="text"/></div>

<div class="field"><label for="text-5">5. What is the purpose of your LLC? What kind of service(s) will the LLC provide? </label><input class="form-control" id="text-5" maxlength="1000" name="llc_provide" type="text"/></div>

<div class="field"><label for="text-6">6. Please provide your business mailing address below. This can be your home address, however, we cannot use a P.O. Box as an address.</label><input class="form-control" id="text-6" maxlength="1000" name="mailing_address" type="text"/></div>

<div class="field"><label for="text-7">7. Will you be the only owner of the LLC or is there someone else ? If so, I will need their complete name and mailing address and what percentage of the LLC they will own?  </label><input class="form-control" id="text-7" maxlength="1000" name="owner_of_the_llc" type="text"/></div>

<div class="field"><label for="text-8">8. Finally, I will also need to obtain an Employer Identification Number (EIN) from the IRS which you and I will have to obtain together online through the IRS. For this phase of the process, I will need your Social Security Number (SSN). Please list your (SSN) below.  .</label><input class="form-control" id="text-8" maxlength="1000" name="identification_number" type="text"/></div>

<input class="btn" id="submit" name="submit" type="submit" value="Submit request"/>
</form><p class="form-note">Prefer a conversation? <a href="./contact.html">Email or call our team.</a></p></div></div></section></main><footer class="site-footer"><div class="wrap"><div class="footer-grid"><div>
<a class="brand" href="./index.html"><img class="brand-logo" src="./assets/images/WPE%20Logo%20(1).jpeg" width="62" height="45" alt=""><span class="brand-name">Wesley Proctor<small>Enterprise</small></span></a><p class="footer-description">Helping people turn their purpose into organizations that make a difference.</p></div>
<div><p class="eyebrow footer-label">Explore</p><div class="footer-links"><a href="./about.html">Meet Dr. Proctor</a><a href="./index.html#services">Our services</a><a href="./speaking-engagement-form.php">Speaking & booking</a><a href="./calendar.html">Calendar</a><a href="./courses-trainings.html">Courses & resources</a><a href="./products.html">Products</a><a href="./payment.html">Make a payment</a></div></div>
<div><p class="eyebrow footer-label">Get in touch</p><div class="footer-links"><a href="mailto:wesleyproctorenterprise@gmail.com">wesleyproctorenterprise@gmail.com</a><a href="tel:4848366444">484-836-6444</a><a href="https://www.instagram.com/drwesleyproctor/" target="_blank" rel="noopener noreferrer">Follow Dr. Proctor on Instagram ↗</a></div></div></div>
<div class="footer-bottom"><span>© 2026 Wesley Proctor Enterprise, LLC</span><span>Business & education development.</span></div></div></footer></body></html>
