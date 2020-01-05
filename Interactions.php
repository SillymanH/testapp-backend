<?php

    require_once 'InteractionsInfo.php';

    $userId = "";

    $videoId = "";

    $videoURL = "";

    $interaction = "";

    $action = "";

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

    if (isset($_POST['action'])){

        $action = $_POST['action'];
    }
    echo $action;

    $interactionObj = new InteractionsInfo();

    if(!empty($userId) && !empty($videoId) && !empty($videoURL) && !empty($interaction) && !empty($action)){
        echo "inside the if";

        $json_response_array = $interactionObj->doAction($userId, $videoId, $videoURL, $interaction, $action);
        echo json_encode($json_response_array);
    }
?>