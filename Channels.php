<?php

    require_once 'ChannelsInfo.php';

    $userId = "";

    $channelId = "";

    if(isset($_GET['id'])){

        $userId = $_GET['id'];

    }

//    echo $userId . "\n";

    if(isset($_GET['channel_id'])){

        $channelId = $_GET['channel_id'];

    }

//    echo $channelId . "\n";

    $channelObject = new channelsInfo();

//    echo empty($user_id) ? 'true' : 'false' . "\n";
//    echo empty($channelId) ? 'true' : 'false' . "\n";

if(!empty($userId) && !empty($channelId)){

//        echo "Going to ChannelInfo class\n";

        $json_response_array = $channelObject->getChannelInfo($userId, $channelId);
        echo json_encode($json_response_array);

    }

//    echo "Out of the if\n";

?>