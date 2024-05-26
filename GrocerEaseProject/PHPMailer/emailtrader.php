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

  $mail->setFrom('grocerease0@gmail.com', 'GrocerEase');

  $mail->addAddress($Temail);   //Add a recipient

  $mail->addReplyTo("grocerease0@gmail.com", "GrocerEase");
  //Content
  $mail->isHTML(true);
  $mail->Subject = 'Trader Account';

  $mail->Body = "
   <h1 style='font: bold 100% sans-serif; padding:10px; width:50%; text-align: center; text-transform: uppercase;background-color:#7FA8D4;margin-right:auto;margin-left:auto; color:white; font-size: 18px;'>Trader Register Verification</h1> 
   
   <h3 style='text-align: center; font-size: 20px;'>Thank you <b style='text-transform: uppercase;'>$Tname</b> For Registration<br>Admin will look into it</h3>
  
        ";


  if ($mail->send()) {
    echo "Email sent";
  }
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
