<?php

    require_once 'ChannelsInfo.php';

//    $userId = "";

    $channelId = "";

//    if(isset($_GET['user_id'])){
//
//        $userId = $_GET['user_id'];
//    }

    if(isset($_GET['channel_id'])){

        $channelId = $_GET['channel_id'];
    }

    $channelObject = new channelsInfo();

    if(!empty($channelId)){

        $json_response_array = $channelObject->getChannelInfo($channelId);
        echo json_encode($json_response_array);
    }