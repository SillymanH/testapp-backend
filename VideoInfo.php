<?php

include_once 'db-connect.php';

class VideoInfo
{

    private $db;
    private $db_table = "videos";

    // Properties
    private $videoId;
    private $channelId;
    private $videoLikes;
    private $videoDislikes;
    private $videoShares;
    private $videoDownloads;
    private $videoSaves;
    private $videoTitle;
    private $youtubeVideoId;

    private $output = array(); //Query response


    public function __construct() {
        $this->db = new DbConnect();
    }

    // Setters
    public function setVideoId($videoId) {

        $this->videoId = $videoId;
    }

    public function setChannelId($channelId) {

        $this->channelId = $channelId;
    }

    public function setVideoLikes($videoLikes) {

        $this->videoLikes = $videoLikes;
    }

    public function setVideoDislikes($videoDislikes) {

        $this->videoDislikes = $videoDislikes;
    }

    public function setVideoShares($videoShares) {

        $this->videoShares = $videoShares;
    }

    public function setVideoDownloads($videoDownloads) {

        $this->videoDownloads = $videoDownloads;
    }

    public function setVideoSaves($videoSaves) {

        $this->videoSaves = $videoSaves;
    }

    public function setVideoTitle($videoTitle) {

        $this->videoTitle = $videoTitle;
    }

    public function setYoutubeId($youtubeId) {

        $this->youtubeVideoId = $youtubeId;
    }

    //Getters
    public function getVideoId() {

        return $this->videoId;
    }

    public function getChannelId() {

        return $this->channelId;
    }

    public function getVideoLikes() {

        return $this->videoLikes;
    }

    public function getVideoDislikes() {

        return $this->videoDislikes;
    }

    public function getVideoShares() {

        return $this->videoShares;
    }

    public function getVideoDownloads() {

        return $this->videoDownloads;
    }

    public function getVideoSaves() {

        return $this->videoSaves;
    }

    public function getVideoTitle() {

        return $this->videoTitle;
    }

    public function getYouTubeId() {

        return $this->youtubeVideoId;
    }

    public function getVideoInfoByYoutubeId($youtubeVideoId) {

        $query = "SELECT video_id, channel_id, video_likes, video_dislikes, video_shares, video_downloads, video_saves, video_title 
                  FROM ".$this->db_table." 
                  WHERE youtube_video_id = '$youtubeVideoId'";

        $result = mysqli_query($this->db->getDb(), $query);

        if(mysqli_num_rows($result) > 0) {

            $this->output = $result->fetch_array(MYSQLI_ASSOC);

            $json['success'] = 1;
            $json['info'] = $this->output;
        } else {

            $json['success'] = 0;
            $json['info'] = "Unable to get video details!";
        }

        mysqli_close($this->db->getDb());
        return $json;
    }

    public function getSuggestedVideos($numberOfVideos) {

        $query = $this->db->getDb()->prepare("SELECT *
                  FROM ".$this->db_table." 
                  Limit $numberOfVideos");

        $query->execute();
        $result = $query->get_result(); // mysqli_query($this->db->getDb(), $query);

        if(mysqli_num_rows($result) > 0) {

            foreach ($result as $row) {
                array_push($this->output, $row);
            }

            $json['success'] = 1;
            $json['info'] = $this->output;

        } else {

            $json['success'] = 0;
            $json['info'] = "Unable to shuffle videos!";
        }

        mysqli_close($this->db->getDb());
        return $json;
    }

}