<?php

include_once 'db-connect.php';

class InteractionsInfo {

    private $db;

    private $db_table_interactions = "user_interactions";
    private $db_table_video = "videos";

    public function __construct(){
        $this->db = new DbConnect();
    }

    public function setInteraction($userId, $videoId, $videoURL, $interaction, $action){

        $userInteractionQuery = "";
        $updateQuery = "";

        switch ($interaction) {
            // $interaction = 1 means a LIKE interaction
            case "1":
                if ($action == 1) { // $action = 1 means a LIKE action

                    $userInteractionQuery = "INSERT INTO ".$this->db_table_interactions." (user_id, video_id, video_url, interaction) 
                                             VALUES ('$userId', '$videoId', '$videoURL', '$interaction')";

                    $updateQuery = "UPDATE $this->db_table_video
                                    SET  video_likes = video_likes + 1
                                    WHERE $this->db_table_video.video_id = $videoId";
                }
                if ($action == 0) { // $action = 0 means an UNLIKE action (LIKE button unpressed)

                    $userInteractionQuery = "DELETE FROM ".$this->db_table_interactions.
                                            " WHERE user_id = $userId 
                                              AND   video_id = $videoId 
                                              AND interaction =  $interaction";

                    $updateQuery = "UPDATE $this->db_table_video
                                    SET  video_likes = video_likes - 1
                                    WHERE $this->db_table_video.video_id = $videoId";
                }
                break;
            // $interaction = 2 means a DISLIKE interaction
            case "2":

                if ($action == 1) { // $action = 1 means a DISLIKE action

                    $userInteractionQuery = "INSERT INTO ".$this->db_table_interactions." (user_id, video_id, video_url, interaction) 
                                             VALUES ('$userId', '$videoId', '$videoURL', '$interaction')";

                    $updateQuery = "UPDATE $this->db_table_video
                                    SET  video_dislikes = video_dislikes + 1
                                    WHERE $this->db_table_video.video_id = $videoId";
                }
                if ($action == 0) { // $action = 0 means an UN-DISLIKE action (DISLIKE button unpressed)

                    $userInteractionQuery = "DELETE FROM ".$this->db_table_interactions.
                                            " WHERE user_id = $userId 
                                              AND   video_id = $videoId 
                                              AND interaction =  $interaction";

                    $updateQuery = "UPDATE $this->db_table_video
                                    SET  video_dislikes = video_dislikes - 1
                                    WHERE $this->db_table_video.video_id = $videoId";
                }
                break;
            case "3":   // $interaction = 3 means a SHARE interaction
            case "4":   // $interaction = 4 means a DOWNLOAD interaction
            case "5":  // $interaction = 5 means a SAVE interaction

                $userInteractionQuery = "INSERT INTO ".$this->db_table_interactions." (user_id, video_id, video_url, interaction) 
                                         VALUES ('$userId', '$videoId', '$videoURL', '$interaction')";
                break;
            default:
                echo $userInteractionQuery = "Could not determine interaction!";
        }

        $db_connection =  $this->db->getDb();
        $db_connection->query($userInteractionQuery); // Did not use mysqli_query because it always gives true with DELETE even when query fails

        if($db_connection->affected_rows != 0) {

            $updateQueryResult = mysqli_query($db_connection, $updateQuery);

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