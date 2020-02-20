<?php

    $otpEntered = "";

    if(isset($_POST['otp'])) {

        $otpEntered = $_POST['otp'];
    }

    if (!empty($otpEntered)) {

        session_start();

        $otpValue = $_SESSION['otp'];
        if (!strcmp($otpValue, $otpEntered)) {

            $json['success'] = 1;
            $json['info'] = "OTP Verified";
        }else {
            $json['success'] = 0;
            $json['info'] = "Invalid OTP";
        }
        echo json_encode($json);
    }
