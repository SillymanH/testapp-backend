<?php
//
//    $email = "";
//
//    if(isset($_POST['email'])) {
//
//        $email = $_POST['email'];
//    }
//
//    if(!empty($email)) {
//
//        session_start();
//
//        try {
//                $otpValue = rand(1000, 9999);//Generate 4 digit OTP
//                $_SESSION['otp']=$otpValue;
//                $message = urlencode("otp number ".$otpValue);
//
//                $to = $email;
//                $subject = "Verification Code";
//                $txt = "Your Verification Code is: ".$otpValue;
//                $headers = "From: otp@techsters.com";
//                mail($to,$subject,$txt,$headers);
//
//                $json['success'] = 1;
//                $json['info'] = "Verification code sent";
//
//        }catch (Exception $ex) {
//
//                $json['success'] = 0;
//                $json['info'] = "Failed to send verification code";
//        }
//        echo json_encode($json);
//    }

include_once 'db-connect.php';

 $table = "otpstore";

        $success = "";
        $error_message = "";
        $conn = new DbConnect();
        if (isset($_POST["submit_email"])) {
            $result = mysqli_query($conn->getDb(), "SELECT * FROM users WHERE email='" . $_POST["submit_email"] . "'");
            $count = mysqli_num_rows($result);
            if ($count == 1) {

                // generate OTP
                $otp = rand(1000, 9999);
                // Send OTP
                require_once("mail_function.php");
                $mail_status = sendOTP($_POST["submit_email"], $otp);

                if ($mail_status == 1) {

                    $query = "INSERT INTO otpstore (otp,is_expired,create_at)
                                VALUES ('".$otp."',0, '". date("Y-m-d H:i:s")."')";

                    $result = mysqli_query($conn->getDb(), $query);
                    $current_id = mysqli_insert_id($conn->getDb());
                    if (!empty($current_id)) {
                        $success = 1;
                    }
                }
            } else {
                $success = 0;
                $error_message = "Email not exists!";
            }
        }
        if (isset($_POST["submit_otp"])) {
            $result = mysqli_query($conn->getDb(), "SELECT * FROM otpstore WHERE otp='" . $_POST["submit_otp"] . "' AND is_expired!=1 AND NOW() <= DATE_ADD(create_at, INTERVAL 24 HOUR)");
            $count = mysqli_num_rows($result);
            if (!empty($count)) {
                $result = mysqli_query($conn->getDb(), "UPDATE otpstore SET is_expired = 1 WHERE otp = '" . $_POST["submit_otp"] . "'");
                $success = 1;
            } else {
                $success = 0;
                $error_message = "Invalid OTP!";
            }
        }

        $json['success'] = $success;
         if (!empty($error_message))
                $json['info'] = $error_message;

        echo json_encode($json);


