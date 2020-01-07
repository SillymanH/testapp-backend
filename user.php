
<?php
    
    include_once 'db-connect.php';
    
    class User{
        
        private $db;

        private $db_table = "users";

        //Table Attributes
//        private $userId;
        private $username;
        private $password;
//        private $email;
//        private $fullname;
//        private $mobileNumber;
        private $output; // Query response

        public function __construct($username, $password){

            $this->username = $username;
            $this->password = $password;
            $this->db = new DbConnect();
        }

        
        public function isLoginExist($username, $password){

//            echo "Checking isloginexist";
            
//            $query = "select * from ".$this->db_table." where username = '$username' AND password = '$password' Limit 1";

            $query = "select id, email, fullname, mobileNumber  from ".$this->db_table." where username = '$username' AND password = '$password' Limit 1";
            
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

//            echo "In the isEmailUsernameExist\n";
            
            $query = "select * from ".$this->db_table." where username = '$username' AND email = '$email'";
            
            $result = mysqli_query($this->db->getDb(), $query);

//            echo 'rows= '.mysqli_num_rows($result);
            
            if(mysqli_num_rows($result) > 0){
                
                mysqli_close($this->db->getDb());
                
                return true;
                
            }
            echo "Returning false\n";
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

                    $userIdQuery = "select id from ".$this->db_table." where username = '$username' AND email = '$email'";

                    $result = mysqli_query($this->db->getDb(), $userIdQuery);

                    $this->output = $result->fetch_array(MYSQLI_ASSOC);

                    $json['success'] = 1;
                    $json['info'] = $this->output;
                    
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
        
        public function loginUsers($username, $password){
            
            $json = array();
            
            $canUserLogin = $this->isLoginExist($username, $password);

//            echo $canUserLogin ? "true" : "false";
//            echo "Inside the loginUsers";
            
            if($canUserLogin){
                
                $json['success'] = 1;
                $json['message'] = $this->output;
                
            }else{
                $json['success'] = 0;
                $json['message'] = "Incorrect details";
            }
            return $json;
        }
    }
    ?>