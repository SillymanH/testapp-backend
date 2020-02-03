
<?php
    
    include_once 'db-connect.php';
    
    class User{
        
        private $db;

        private $db_table = "users";

        //Table Attributes
        private $username;
        private $password;
        private $output; // Query response

        public function __construct($username, $password){

            $this->username = $username;
            $this->password = $password;
            $this->db = new DbConnect();
        }

        
        public function isLoginExist($username, $password){

            $query = "select id, username, email, fullname, mobileNumber, created_at, updated_at  from ".$this->db_table." where username = '$username' AND password = '$password' Limit 1";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){

                $this->output = $result->fetch_array(MYSQLI_ASSOC);

                mysqli_close($this->db->getDb());
                return true;
            }
            
            mysqli_close($this->db->getDb());
            
            return false;
            
        }
        
        public function isEmailUsernameExist($username, $email){

            $query = "";
            if (!empty($username) && !empty($email)) {

                $query = "select id, email, fullname, mobileNumber, created_at, updated_at from ".$this->db_table." where username = '$username' AND email = '$email'";
            }
            if (empty($username) && !empty($email)) {

                $query = "select id, username, fullname, mobileNumber, created_at, updated_at from ".$this->db_table." where email = '$email'";
            }
            if (empty($username) && empty($email)) {

                return false;
            }
            $result = mysqli_query($this->db->getDb(), $query);

            if(mysqli_num_rows($result) > 0){

                $this->output = $result->fetch_array(MYSQLI_ASSOC);

                mysqli_close($this->db->getDb());
                return true;
            }
            return false;
        }
        
        public function isValidEmail($email){
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }
        
        public function createNewRegisterUser($fullname, $username, $password, $email, $mobileNumber){

//            echo "In createNewRegisterUser\n";
              
            $isExisting = $this->isEmailUsernameExist($username, $email);

//            echo $isExisting ? 'true' : 'false';
            
            if($isExisting){

//                echo "in the if condition\n";
                
                $json['success'] = 0;
                $json['message'] = "Error in registering. Probably the username/email already exists";
            }
            
            else{
                
            $isValid = $this->isValidEmail($email);
                
                if($isValid)
                {
                $query = "insert into ".$this->db_table." (username, password, email, created_at, updated_at, fullname, mobileNumber) values ('$username', '$password', '$email', NOW(), NOW(), '$fullname', '$mobileNumber')";
                
                $inserted = mysqli_query($this->db->getDb(), $query);

//                echo 'Inserted = ' .$inserted;
                
                if($inserted == 1){


                    $json['success'] = 1;
                    $json['message'] = "Registered Successfully";
                    
                }else{
                    
                    $json['success'] = 0;
                    $json['message'] = "Error in registering. Probably the username/email already exists";
                    
                }
                
                mysqli_close($this->db->getDb());
                }
                else{
                    $json['success'] = 0;
                    $json['message'] = "Error in registering. Email Address is not valid";
                }
                
            }
            
            return $json;
            
        }
        
        public function loginUsers($username, $password, $email){
            
            $canUserLogin = false;
            if (empty($username) && empty($password) && !empty($email)) {

                $canUserLogin = $this->isEmailUsernameExist($username, $email);
//                echo $canUserLogin ? 'true' : 'false';
            } else {

                if (!empty($username) && !empty($password) && empty($email)) {

                    $canUserLogin = $this->isLoginExist($username, $password);
                }
            }
            
            if($canUserLogin){
                
                $json['success'] = 1;
                $json['info'] = $this->output;
                
            }else{
                $json['success'] = 0;
                $json['message'] = "Incorrect details";
            }
            return $json;
        }
    }