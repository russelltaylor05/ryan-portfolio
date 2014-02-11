<?php

include dirname(dirname(__FILE__)).'/mail.php';
error_reporting (E_ALL ^ E_NOTICE);
$post = (!empty($_POST)) ? true : false;

if($post) {
  include 'email_validation.php';
  
  $name = stripslashes($_POST['name']);
  $email = trim($_POST['email']);
  $subject = stripslashes($_POST['subject']);
  $message = stripslashes($_POST['message']);  
  $message .= "\n Email: {$email}";

  $error = '';
  
  if(!$name) {
    $error .= 'Please enter your name.<br />';
  }    
  if(!$email) {
    $error .= 'Please enter an e-mail address.<br />';
  }
  if($email && !ValidateEmail($email)) {
    $error .= 'Please enter a valid e-mail address.<br />';
  }  
  if(!$message || strlen($message) < 10){ 
    $error .= "Please enter your message. It should have at least 10 characters.<br />";
  }
  
  if(!$error)
  {
    $mail = mail(CONTACT_FORM, $subject, $message, "Reply-To: ".$email."\r\n" ."X-Mailer: PHP/" . phpversion());
    //"From: ".$name." <russelltaylor05@gmail.com>\r\n"  
    if($mail) {
      echo 'OK';
    }
  } else {
    echo '<div class="notification_error">'.$error.'</div>';
  }
}
?>