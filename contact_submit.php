<?php 
 if(isset($_POST['contact_email'])) {
    // CHANGE THE TWO LINES BELOW
    $email_to = "you@yourdomain.com";
     
    $email_subject = "CTG html form submissions";
     
     
    function died($error) {
        $return['error'] = true;
        $return['msg'] .= 'We are very sorry, but there were error(s) found with the form you submitted.';
        $return['msg'] .= $error;
        $return['msg'] .= 'Please fix these errors and resubmit.';
        echo json_encode($return);
        die();
    }
     
    // validation expected data exists
    if(!isset($_POST['contact_name']) ||
        !isset($_POST['contact_email']) ||
        !isset($_POST['contact_message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
     
    $name = $_POST['contact_name']; // required
    $email_from = $_POST['contact_email']; // required
    $telephone = $_POST['contact_phone']; // not required
    $message = $_POST['contact_message']; // required
     
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$name)) {
    $error_message .= 'The Name you entered does not appear to be valid.<br />';
  }
  
  if(strlen($message) < 2) {
    $error_message .= 'The Message you entered do not appear to be valid.<br />';
  }
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "Form details below.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($message)."\n";
    $email_subject .= clean_string($name); 
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  

$return['error'] = false;
$return['msg'] = 'Thank you for contacting us. We will be in touch with you very soon.';
echo json_encode($return);
?>
