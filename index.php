<?php
    
    require_once 'user.php';
    
    $username = "";
    
    $password = "";
    
    $email = "";
    
    if(isset($_POST['username'])){

        // echo "Post username";
        
        $username = $_POST['username'];

        // echo $username;
        
    }
    
    if(isset($_POST['password'])){
        
        $password = $_POST['password'];
        
    }
    
    if(isset($_POST['email'])){
        
        $email = $_POST['email'];
        
    }
    // echo "Username is " + $_POST['username'] +"\n";
    // echo "Creating userObj\n";
    $userObject = new User();
    
    // Registration
    
    if(!empty($username) && !empty($password) && !empty($email)){
        
        $hashed_password = md5($password);
        
        $json_registration = $userObject->createNewRegisterUser($username, $hashed_password, $email);
        
        echo json_encode($json_registration);
        
    }
    
    // Login
    
    if(!empty($username) && !empty($password) && empty($email)){
        
        $hashed_password = md5($password);
        
        $json_array = $userObject->loginUsers($username, $hashed_password);
        
        echo json_encode($json_array);
    }
    // echo "Cannot detect parameters\n";
    ?>