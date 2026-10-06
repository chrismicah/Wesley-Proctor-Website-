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
    $nonprofit_organization = htmlspecialchars(is_string($_POST['nonprofit_organization'] ?? null) ? trim($_POST['nonprofit_organization']) : '', ENT_QUOTES, 'UTF-8');
    $mailing_address = htmlspecialchars(is_string($_POST['mailing_address'] ?? null) ? trim($_POST['mailing_address']) : '', ENT_QUOTES, 'UTF-8');
    $first_last_name = htmlspecialchars(is_string($_POST['first_last_name'] ?? null) ? trim($_POST['first_last_name']) : '', ENT_QUOTES, 'UTF-8');
    // Sensitive identifiers are collected separately, not by this inquiry form.
    $brief_mission_statement = htmlspecialchars(is_string($_POST['brief_mission_statement'] ?? null) ? trim($_POST['brief_mission_statement']) : '', ENT_QUOTES, 'UTF-8');

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
      $mail->Subject = 'Nonprofit Formation/Incorporation';
      $mail->Body = "<h1 style=''>Nonprofit Formation/Incorporation</h1>
                          <br><br><h3>Email: <u>$email</u> <br> <br>
                          Phone: <u>$phone</u> <br> <br>
                          Nonprofit organization: <u>$nonprofit_organization</u> <br> <br>
                          Mailing address: <u>$mailing_address</u> <br> <br>
                          First and last name: <u>$first_last_name</u> <br> <br>
                          BRIEF mission statement: <u>$brief_mission_statement</u></h3>";


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
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="Nonprofit formation with Dr. Wesley Proctor."><meta name="theme-color" content="#173f42"><title>Nonprofit formation | Wesley Proctor Enterprise</title><link rel="icon" href="./assets/favicon.ico"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link rel="stylesheet" href="./assets/site.css"><script src="./assets/site.js" defer></script></head><body data-wpe-version="2"><a class="skip" href="#main">Skip to content</a>
<header class="site-header"><div class="wrap header-inner">
<a class="brand" href="./index.html" aria-label="Wesley Proctor Enterprise home"><img class="brand-logo" src="./assets/images/WPE%20Logo%20(1).jpeg" width="62" height="45" alt=""><span class="brand-name">Wesley Proctor<small>Enterprise</small></span></a>
<button class="menu-button" type="button" aria-controls="site-navigation" aria-expanded="false">Menu +</button>
<nav class="site-nav" id="site-navigation" aria-label="Main navigation">
<a href="./about.html">Meet Dr. Proctor</a>
<details class="nav-details"><summary>Our services</summary><div class="nav-dropdown"><a href="./Nonprofit-Formation-Incorporation.php">Nonprofit formation</a><a href="./For-profit-Business-Formation.php">Business formation</a><a href="./Consultation-Coaching.php">Consultation &amp; coaching</a><a href="./Workshops-Trainings.php">Workshops &amp; training</a></div></details>
<details class="nav-details"><summary>Book Dr. Proctor</summary><div class="nav-dropdown"><a href="./speaking-engagement-form.php">Speaking engagements</a><a href="./workshop-seminar-training-form.php">Workshop & seminar booking</a></div></details>
<a href="./payment.html">Make a payment</a><a class="nav-cta" href="./contact.html">Let’s talk <span aria-hidden="true">↗</span></a></nav></div></header><main id="main"><section class="page-hero"><div class="wrap"><div class="breadcrumb"><a href="./index.html">Home</a><span aria-hidden="true">/</span><span>Nonprofit formation</span></div><p class="eyebrow">Nonprofit formation</p><h1>Nonprofit formation</h1><p>Wesley Proctor Enterprise</p></div></section><section class="section"><div class="wrap content-grid"><article class="service-overview"><p class="note" style="padding-bottom: 0;">(WPE) will walk you through the step-by-step process of forming your nonprofit organization.This includes:</p><p class="note">If you are interested in establishing a nonprofit organization, please complete and submit the questionnaire below. Dr. Proctor or a WPE staff member will be in touch with you to schedule a follow-up meeting for next steps.</p><ul class="numberlist">
<li><p>Choosing a business name that is legally available in your state</p> </li>
<li><p>File for an Employer Identification Number (EIN)</p></li>
<li><p>Prepare and file your articles of incorporation with your state's corporate filing office (state fees required)</p></li>
<li><p>Create bylaws that will dictate how the corporation will be operated.</p></li>
<li class="last-li"><p>Apply for any licenses or permits that your corporation will need to operate in your state and local municipality.</p></li>
</ul></article><div class="form-panel"><h2>NONPROFIT QUESTIONNAIRE!</h2><?php echo $output; ?><form action="" class="inquiry-form" method="post">
<div class="field"><label for="text">1. Please provide your email.</label><input autocomplete="email" class="form-control" id="text" maxlength="1000" name="email" required="" type="email"/></div>

<div class="field"><label for="text-2">2. Please provide your phone number.</label><input autocomplete="tel" class="form-control" id="text-2" maxlength="1000" name="phone" required="" type="tel"/></div>

<div class="field"><label for="text-3">3. Please provide the name of your nonprofit organization.</label><input class="form-control" id="text-3" maxlength="1000" name="nonprofit_organization" required="" type="text"/></div>

<div class="field"><label for="text-4">4. Please provide the complete mailing address of your nonprofit organization (this address can be your home address but cannot be a P.O. Box).</label><input class="form-control" id="text-4" maxlength="1000" name="mailing_address" required="" type="text"/></div>

<div class="field"><label for="text-5">5. Please provide the first and last name of the person who will serve as the main contact of the newly formed 501c3? (Please provide me with how their name should appear on all 501c3 documents.)</label><input class="form-control" id="text-5" maxlength="1000" name="first_last_name" required="" type="text"/></div>



<div class="field"><label for="text-7">7. Please provide a BRIEF mission statement for the nonprofit organization. This statement should be no more than (2) sentences about what the organization does. Your mission statement does not have to be perfect but should provide a general overview of what your nonprofit organization is all about. (If you need a sample to refer to, please write "NEED SAMPLE").</label><input class="form-control" id="text-7" maxlength="1000" name="brief_mission_statement" required="" type="text"/></div>

<input class="btn" id="submit" name="submit" type="submit" value="Submit request"/>
</form><p class="form-note">Prefer a conversation? <a href="./contact.html">Email or call our team.</a></p><p class="form-note">Please do not include Social Security numbers in this inquiry. Any sensitive filing details will be arranged separately.</p></div></div></section></main><footer class="site-footer"><div class="wrap"><div class="footer-grid"><div>
<a class="brand" href="./index.html"><img class="brand-logo" src="./assets/images/WPE%20Logo%20(1).jpeg" width="62" height="45" alt=""><span class="brand-name">Wesley Proctor<small>Enterprise</small></span></a><p class="footer-description">Helping people turn their purpose into organizations that make a difference.</p></div>
<div><p class="eyebrow footer-label">Explore</p><div class="footer-links"><a href="./about.html">Meet Dr. Proctor</a><a href="./index.html#services">Our services</a><a href="./speaking-engagement-form.php">Speaking & booking</a><a href="./calendar.html">Calendar</a><a href="./courses-trainings.html">Courses & resources</a><a href="./products.html">Products</a><a href="./payment.html">Make a payment</a></div></div>
<div><p class="eyebrow footer-label">Get in touch</p><div class="footer-links"><a href="mailto:wesleyproctorenterprise@gmail.com">wesleyproctorenterprise@gmail.com</a><a href="tel:4848366444">484-836-6444</a><a href="https://www.instagram.com/drwesleyproctor/" target="_blank" rel="noopener noreferrer">Follow Dr. Proctor on Instagram ↗</a></div></div></div>
<div class="footer-bottom"><span>© 2026 Wesley Proctor Enterprise, LLC</span><span>Business & education development.</span></div></div></footer></body></html>
