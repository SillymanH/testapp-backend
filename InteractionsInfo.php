<?php

include_once 'db-connect.php';

class InteractionsInfo {

    private $db;
    private $db_table_interactions = "user_interactions";
    private $db_table_video = "videos";
    private $interactionQuery;
    private $updateQuery;

    //Videos table attributes
//    private $videoLikes = "video_likes";
//    private $videoDislikes = "video_dislikes";
//    private $videoShares = "video_shares";
//    private $videoDownloads = "video_downloads";
//    private $videoSave = "video_saves";

    //user_interactions table attributes
//    private $userIdAttribute = "user_id";
//    private $videoIdAttribute = "video_id";
//    private $videoURLAttribute = "video_url";
//    private $interactionTypeAttribute = "interaction";


    public function __construct(){
        $this->db = new DbConnect();
    }

    private function setUserInteraction($userId, $videoId, $videoURL, $interactionType, $action) {

        if ($action == "SET_INTERACTION") { // SET_INTERACTION means a LIKE action

            $this->interactionQuery = "INSERT INTO ".$this->db_table_interactions." (user_id, video_id, video_url, interaction) 
                                        VALUES ('$userId', '$videoId', '$videoURL', '$interactionType')";
        }

        if ($action == "UNSET_INTERACTION") { // UNSET_INTERACTION means an UNLIKE action (LIKE button unpressed)

            $this->interactionQuery = "DELETE FROM " . $this->db_table_interactions .
                                     " WHERE user_id = $userId 
                                       AND   video_id = $videoId 
                                       AND video_url =  $interactionType";
        }
    }

    private function updateVideoStatistics($videoId, $interaction, $action) {

        if ($action == "SET_INTERACTION") { // SET_INTERACTION means a LIKE action
            $this->updateQuery = "UPDATE $this->db_table_video
                                  SET  $interaction = $interaction + 1
                                  WHERE $this->db_table_video.video_id = $videoId";
        }

        if ($action == "UNSET_INTERACTION") { // UNSET_INTERACTION means an UNLIKE action (LIKE button unpressed)

            $this->updateQuery = "UPDATE $this->db_table_video
                                  SET  $interaction = $interaction - 1
                                  WHERE $this->db_table_video.video_id = $videoId";
        }
    }

    public function doAction($userId, $videoId, $videoURL, $interactionType, $action){

        switch ($interactionType) {
            // $interaction = 1 means a LIKE interaction
            case "1":

                $this->setUserInteraction($userId, $videoId, $videoURL, $interactionType, $action);
                $this->updateVideoStatistics($videoId, "video_likes", $action);
                    break;
            // $interaction = 2 means a DISLIKE interaction
            case "2":

                $this->setUserInteraction($userId, $videoId, $videoURL, $interactionType, $action);
                $this->updateVideoStatistics($videoId, "video_dislikes", $action);
                    break;
            case "3":   // $interaction = 3 means a SHARE interaction

                //TODO: Implement share functionality
                break;
            case "4":   // $interaction = 4 means a DOWNLOAD interaction

                //TODO: Implement download functionality
                break;
            case "5":  // $interaction = 5 means a SAVE interaction

                //TODO: Implement save functionality
                break;
            default:
                echo $this->interactionQuery = "Could not determine interaction!";
        }

        $db_connection =  $this->db->getDb();
        $db_connection->query($this->interactionQuery); // Did not use mysqli_query because it always gives true with DELETE even when query fails

        if($db_connection->affected_rows > 0) {

            $updateQueryResult = mysqli_query($db_connection, $this->updateQuery);

            if ($updateQueryResult){

                $json['success'] = 1;
                $json['message'] = "Successfully registered interaction";

            } else {

                $json['success'] = 0;
                $json['message'] = "Could not update interaction";
            }

        } else {

            $json['success'] = 0;
            $json['message'] = "Could not set interaction";
        }
        $db_connection->close();
        return $json;
    }
}