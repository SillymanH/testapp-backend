<?php

include_once 'db-connect.php';

class ChannelsInfo {

    private $db;

    private $db_table = "channels";


    public function __construct(){

        $this->db = new DbConnect();
    }

    public function getChannelInfo($channelId){

        $query = "SELECT *  FROM ".$this->db_table." 
                  WHERE channel_id = $channelId";

        $result = mysqli_query($this->db->getDb(), $query);

        $output = array();

        if(mysqli_num_rows($result) > 0){

//            foreach ($result as $row) {
//
//                array_push($output, $row);
//            }
            $json['success'] = 1;
            $json['info'] = $result->fetch_assoc();

        }else {

            $output = 'Failed to get channel info';
            $json['success'] = 0;
        }
        mysqli_close($this->db->getDb());
//        $json['info'] = $output;
        return $json;
    }

//    public function getChannelInfo($userId, $channelId){
//
//        $query = "select channel_url, channel_subscribers_number, date_created  from ".$this->db_table." where user_id = $userId AND channel_id = $channelId";
//
//        $result = mysqli_query($this->db->getDb(), $query);
//
//        $output = array();
//
//        if(mysqli_num_rows($result) > 0){
//
//            foreach ($result as $row) {
//
//                  array_push($output, $row);
//            }
//            $json['success'] = 1;
//
//            mysqli_close($this->db->getDb());
//        }else {
//
//            $output = 'Failed to get channel info';
//            $json['success'] = 0;
//        }
//        $json['info'] = $output;
//        return $json;
//    }
}

?>
