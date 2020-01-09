<?php

require_once 'VideoInfo.php';

    $youtubeVideoId = "";

    if (isset($_POST['youtubeVideoId'])) {

        $youtubeVideoId = $_POST['youtubeVideoId'];
    }

    $videoInfoObj = new VideoInfo($youtubeVideoId);

    if (!empty($youtubeVideoId)) {

        $json_response = $videoInfoObj->getVideoInfoByYoutubeId($youtubeVideoId);
        echo json_encode($json_response);
    }
