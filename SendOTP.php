<?php

    $email = "";

    if(isset($_POST['email'])) {

        $email = $_POST['email'];
    }

    if(!empty($email)) {

        session_start();

        try {
                $otpValue = rand(1000, 9999);//Generate 4 digit OTP
                $_SESSION['otp']=$otpValue;
                $message = urlencode("otp number.".$otpValue);

                $to = $email;
                $subject = "Verification Code";
                $txt = "Your Verification Code is: ".$otpValue;
                $headers = "From: otp@techsters.com";
                mail($to,$subject,$txt,$headers);

                $json['success'] = 1;
                $json['info'] = "Verification code sent";

        }catch (Exception $ex) {

                $json['success'] = 0;
                $json['info'] = "Failed to send verification code";
        }
        echo json_encode($json);
    }

