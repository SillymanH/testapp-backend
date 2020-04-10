<?php

use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function sendOTP($email,$otp) {


    $message_body = "Your one time password is:<br/><br/>" . $otp;
    $mail = new PHPMailer();
   // $mail->SMTPDebug = 4;
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = 'tls'; // tls or ssl
    $mail->Port     = "587";
    $mail->Username = "";
    $mail->Password = "";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Host     = "smtp.gmail.com";
    $mail->Mailer   = "smtp";
    $mail->SetFrom("", "Techsters");
    $mail->AddAddress($email);
    $mail->IsHTML(true);
    $mail->Subject = "OTP to Login";
    $mail->MsgHTML($message_body);
    $result = $mail->Send();
    return $result;
}
?>