<?php

require_once 'VideoInfo.php';

    $youtubeVideoId = "";
    $numberOfVideos = ""; //number of videos to get from DB

    if (isset($_POST['youtubeVideoId'])) {

        $youtubeVideoId = $_POST['youtubeVideoId'];
    }

    if (isset($_POST['numberOfVideos'])) {

        $numberOfVideos = $_POST['numberOfVideos'];
    }

    $videoInfoObj = new VideoInfo();

    if (!empty($youtubeVideoId) && empty($numberOfVideos)) {

        $videoInfoObj->setYoutubeId($youtubeVideoId);
        $json_response = $videoInfoObj->getVideoInfoByYoutubeId($youtubeVideoId);
    }

    if (empty($youtubeVideoId) && !empty($numberOfVideos)) {

        $json_response = $videoInfoObj->getSuggestedVideos($numberOfVideos);
    }

    echo json_encode($json_response);
