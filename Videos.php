<?php

require_once 'VideoInfo.php';

    $youtubeVideoId = "";
    $numberOfVideos = ""; //number of videos to get from DB
    $channelId = "";

    if (isset($_POST['youtubeVideoId'])) {

        $youtubeVideoId = $_POST['youtubeVideoId'];
    }

    if (isset($_POST['numberOfVideos'])) {

        $numberOfVideos = $_POST['numberOfVideos'];
    }

    if (isset($_POST['channel_id'])) {

        $channelId = $_POST['channel_id'];
    }

    $videoInfoObj = new VideoInfo();

    if (!empty($youtubeVideoId) && empty($channelId) && empty($numberOfVideos)) {

        $videoInfoObj->setYoutubeId($youtubeVideoId);
        $json_response = $videoInfoObj->getVideoInfoByYoutubeId($youtubeVideoId);
    }

    if (empty($youtubeVideoId) && empty($channelId) && !empty($numberOfVideos)) {

        $json_response = $videoInfoObj->getSuggestedVideos($numberOfVideos);
    }

    if (!empty($channelId) && empty($youtubeVideoId) && empty($numberOfVideos)) {

        $json_response = $videoInfoObj->getChannelVideos($channelId);
    }

    echo json_encode($json_response);
