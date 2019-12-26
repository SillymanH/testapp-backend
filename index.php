<?php
    
    require_once 'user.php';
    
    $fullName = "";
    
    $username = "";
    
    $password = "";
    
    $email = "";
    
    $mobileNumber = "";

    echo "reached endpoint\n";

    if(isset($_POST['username'])){

         echo "Posting username\n";
        
        $username = $_POST['username'];
        echo $username+"\n";
        
    }

      
    if(isset($_POST['password'])){
        
        $password = $_POST['password'];
        echo $password+"\n";
        
    }
    
    if(isset($_POST['email'])){
        
        $email = $_POST['email'];
        echo $email+"\n";
        
    }
    
    if(isset($_POST['fullname'])){
           
           $fullName = $_POST['fullname'];
           echo $fullName+"\n";
           
       }
    
    if(isset($_POST['mobileNumber'])){
        
        $mobileNumber = $_POST['mobileNumber'];
        echo $mobileNumber+"\n";
        
    }
    // echo "Username is " + $_POST['username'] +"\n";
    // echo "Creating userObj\n";
    $userObject = new User();
    
    // Registration
    
    echo "Checking the if condition\n";
    if(!empty($fullname) && !empty($username) && !empty($password) && !empty($email) && !empty($mobileNumber)){

        echo "In the if condition\n";
        
        $hashed_password = md5($password);
        
        $json_registration = $userObject->createNewRegisterUser($fullName, $username, $hashed_password, $email, $mobileNumber);
        
        echo json_encode($json_registration);
        
    }
    echo "Skipped the if condition\n";
    
    // Login
    
    if(!empty($username) && !empty($password) && empty($email)){
        
        $hashed_password = md5($password);
        
        $json_array = $userObject->loginUsers($username, $hashed_password);
        
        echo json_encode($json_array);
    }
    // echo "Cannot detect parameters\n";
    ?>
