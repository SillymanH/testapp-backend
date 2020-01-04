<?php

include_once 'db-connect.php';

class InteractionsInfo {

    private $db;

    private $db_table_interactions = "user_interactions";
    private $db_table_video = "videos";

    public function __construct(){
        $this->db = new DbConnect();
    }

    public function setInteraction($userId, $videoId, $videoURL, $interaction){

        $userInteractionQuery = "";
        $updateQuery = "";

        switch ($interaction) {
            case "1":

                $userInteractionQuery = "INSERT INTO ".$this->db_table_interactions." (user_id, video_id, video_url, interaction) 
                                         VALUES ('$userId', '$videoId', '$videoURL', '$interaction')";

                $updateQuery = "UPDATE $this->db_table_video
                                SET  video_likes = video_likes + 1
                                WHERE $this->db_table_video.video_id = $videoId";
                break;
            case "2":

                $userInteractionQuery = "DELETE FROM ".$this->db_table_interactions.
                                       " WHERE user_id = $userId 
                                         AND   video_id = $videoId 
                                         AND interaction =  $interaction";

                $updateQuery = "UPDATE $this->db_table_video
                                SET  video_likes = video_likes - 1
                                WHERE $this->db_table_video.video_id = $videoId";
                break;
            case "3":
                echo "Share";
                break;
            case "4":
                echo "Download";
                break;
            case "5":
                echo "Save";
                break;
            default:
                echo $query = "Could not determine interaction!";
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