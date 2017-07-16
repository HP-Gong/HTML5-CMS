<?php
if(isset($_POST['btn'])){

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$name = strip_tags($_POST['name']);

$email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$email  = strip_tags($_POST['email']);

$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
$message = trim(htmlspecialchars($_POST['message']));

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
echo 'Please enter a valid email!';
die();
}

function is_valid_email($email){
if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
return true;
} else {
return false;
}
}

$email_to = 'yourmail@gmail.com'; 
$subject = 'Inquiry';  

$headers = 'From: '.$email.'' . "\r\n" .
'Reply-To: '.$email.'' . "\r\n" .
'X-Mailer: PHP/' . phpversion();

$e_message = "Please find below a message submitted by '".stripslashes($name);
$e_message .="' on ".date("d/m/Y")." at ".date("H:i")."\n\n";
$e_message .= "Name: $name\n\n";
$e_message .= "Subject: $subject\n\n";
$e_message .= "Message:\n\n$message \n\n";

$s_mail = mail($email_to, $subject, $e_message, $headers);

if(!$s_mail){
echo "Email can't be send, Error!";
die();
}else{
echo 'Mail Sent';
}

}
?>