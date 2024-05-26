<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
  //Server settings
  $mail->SMTPDebug = 0;                      //Enable verbose debug output
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = 'grocerease0@gmail.com';                     //SMTP username
  $mail->Password   = 'xdwd ykkd bgzp pcss';                               //SMTP password
  $mail->SMTPSecure = 'tls';

  $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  $mail->setFrom('grocerease0@gmail.com', '');

  $mail->addAddress($email);   //Add a recipient

  $mail->addReplyTo("grocerease0@gmail.com", "GrocerEase");

  $emailUSer = "Select USERNAME from USERS WHERE EMAIL=$email";
  $stidEmail = (oci_parse($conn, $emailUSer));
  oci_execute($stidEmail, OCI_DEFAULT);
  while (($rowname = oci_fetch_object($stidEmail))) {
    $username = $rowname->USERNAME;
  }
  //Content
  $mail->isHTML(true);
  $mail->Subject = 'Verify your account';

  $mail->Body = "
   <h3 style='text-align: center; font-size: 20px;'>Thank you <b style='text-transform: uppercase;'>$username for registering with us! </b><br> Here is your One-Time Password (OTP) for verification:</h3>
  
   <h1 style='font: bold 100% sans-serif; padding:10px; width:100%; text-align: center; text-transform: uppercase;background-color:#7FA8D4; color:white; font-size: 18px;'>$vcode</h1>
        <p style='text-align: center;'><b>Please use this OTP to complete your registration.<b></p>     
        ";


  if ($mail->send()) {
    echo "Email sent";
  }
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
