<?php
    
    include_once 'config.php';
    
    class DbConnect extends \PDO
    {
        
        private $connect;
        
        public function __construct(){
            
            $this->connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            //$this->connect = new \Delight\Db\PdoDsn('mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset=utf8mb4', DB_USER, DB_PASSWORD);


            if (mysqli_connect_errno($this->connect)){
                echo "Unable to connect to MySQL Database: " . mysqli_connect_error();
            }
        }
        
        public function getDb(){
            return $this->connect;
        }
    }
    ?>