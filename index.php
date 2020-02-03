<?php
    
    require_once 'user.php';
    
    $fullName = "";
    
    $username = "";
    
    $password = "";
    
    $email = "";
    
    $mobileNumber = "";

//    echo "reached endpoint\n";

    if(isset($_POST['username'])){

//         echo "Posting username\n";
        
        $username = $_POST['username'];
//        echo $username."\n";
        
    }

      
    if(isset($_POST['password'])){
        
        $password = $_POST['password'];
//        echo $password."\n";
        
    }
    
    if(isset($_POST['email'])){

        $email = $_POST['email'];
//        echo $email."\n";
        
    }
    
    if(isset($_POST['fullname'])){
           
           $fullName = $_POST['fullname'];
//           echo $fullName."\n";
           
       }
    
    if(isset($_POST['mobileNumber'])){
        
        $mobileNumber = $_POST['mobileNumber'];

        
    }

    $userObject = new User($username, $password);

    if(!empty($fullName) && !empty($username) && !empty($password) && !empty($email) && !empty($mobileNumber)){
        
        $hashed_password = md5($password);
        
        $json_registration = $userObject->createNewRegisterUser($fullName, $username, $hashed_password, $email, $mobileNumber);
        
        echo json_encode($json_registration);
        
    }
    
    if(!empty($username) && !empty($password) && empty($email)){
        
        $hashed_password = md5($password);
        
        $json_array = $userObject->loginUsers($username, $hashed_password, "");
        
        echo json_encode($json_array);
    }

if(empty($username) && empty($password) && !empty($email)){

    $json_array = $userObject->loginUsers("", "", $email);

    echo json_encode($json_array);
}