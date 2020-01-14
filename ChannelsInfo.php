<?php

include_once 'db-connect.php';

class ChannelsInfo {

    private $db;

    private $db_table = "channels";

    //Channel Properties
    private $userId;
    private $channelId;
    private $videoId;
    private $channelURL;
    private $subscribersNumber;
    private $dateCreated;

    //Channel Table Attributes
//    private $channelIdAttribute = "channel_id";
//    private $userIdAttribute = "user_id";
//    private $channelURLAttribute = "channel_url";
//    private $subscribersNumberAttribute = "channel_subscribers_number";
//    private $dateCreatedAttribute = "date_created";
    //TODO: Add a new attribute $videoIdAttribute

    public function __construct($userId, $channelId, $videoId, $channelURL, $subscribersNumber, $dateCreated){

        $this->userId = $userId;
        $this->channelId = $channelId;
        $this->videoId = $videoId;
        $this->channelURL = $channelURL;
        $this->subscribersNumber = $subscribersNumber;
        $this->dateCreated = $dateCreated;
        $this->db = new DbConnect();
    }

    public function getChannelInfo($channelId){

        $query = "select *  from ".$this->db_table." where channel_id = $channelId";

        $result = mysqli_query($this->db->getDb(), $query);

        $output = array();

        if(mysqli_num_rows($result) > 0){

            foreach ($result as $row) {

                array_push($output, $row);
            }
            $json['success'] = 1;

            mysqli_close($this->db->getDb());

        }else {

            $output = 'Failed to get channel info';
            $json['success'] = 0;
        }
        $json['info'] = $output;
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
