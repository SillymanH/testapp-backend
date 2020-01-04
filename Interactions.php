<?php

    require_once 'InteractionsInfo.php';

    $userId = "";

    $videoId = "";

    $videoURL = "";

    $interaction = "";

    if(isset($_POST['userId'])){

        $userId = $_POST['userId'];
    }

    if (isset($_POST['videoId'])){

        $videoId = $_POST['videoId'];
    }

    if (isset($_POST['videoURL'])){

        $videoURL = $_POST['videoURL'];
    }

    if (isset($_POST['interaction'])){

        $interaction = $_POST['interaction'];
    }

    $interactionObj = new InteractionsInfo();

    if(!empty($userId) && !empty($videoId) && !empty($videoURL) && !empty($interaction)){

        $json_response_array = $interactionObj->setInteraction($userId, $videoId, $videoURL, $interaction);
        echo json_encode($json_response_array);
    }
?>