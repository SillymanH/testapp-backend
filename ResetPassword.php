<?php

    include_once 'db-connect.php';

    $conn = new DbConnect();;

    if (isset($_POST["newPassword"]) || isset($_POST["submit_email"])) {

        $hashed_password = md5($_POST["newPassword"]);

        $query = " UPDATE users 
                   SET password = '".$hashed_password."'  
                   WHERE email = '".$_POST["submit_email"]."'";

        $result = mysqli_query($conn->getDb(), $query);

        if($conn->getDb()->affected_rows > 0) {

            $json['success'] = 1;
        }
        else {

            $json['success'] = 0;
            $json['message'] = "Could not reset password!";
        }

        echo json_encode($json);
    }
