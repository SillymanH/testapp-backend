<?php

include_once 'db-connect.php';

class InteractionsInfo {

    private $db;
    private $db_table_interactions = "user_interactions";
    private $db_table_video = "videos";
    private $interactionQuery;
    private $updateQuery;

    //Videos table attributes
    private $videoLikes = "video_likes";
    private $videoDislikes = "video_dislikes";
    private $videoShares = "video_shares";
    private $videoDownloads = "video_downloads";
    private $videoSave = "video_saves";

    //user_interactions table attributes
    private $userIdAttribute = "user_id";
    private $videoIdAttribute = "video_id";
    private $videoURLAttribute = "video_url";
    private $interactionTypeAttribute = "interaction";


    public function __construct(){
        $this->db = new DbConnect();
    }

    private function setInteraction($userId, $videoId, $videoURL, $interactionType, $userIdAttribute, $videoIdAttribute, $videoURLAttribute, $interactionTypeAttribute, $interaction) {

        $this->interactionQuery = "INSERT INTO ".$this->db_table_interactions." ($userIdAttribute, $videoIdAttribute, $videoURLAttribute, $interactionTypeAttribute) 
                                   VALUES ('$userId', '$videoId', '$videoURL', '$interactionType')";

        echo $this->interactionQuery;

        $this->updateQuery = "UPDATE $this->db_table_video
                              SET  $interaction = $interaction + 1
                              WHERE $this->db_table_video.$videoIdAttribute = $videoId";
        echo  $this->updateQuery ."\n";
    }

    private function unsetInteraction($userId, $videoId, $interactionType, $userIdAttribute, $videoIdAttribute, $interactionTypeAttribute, $interaction) {

            $this->interactionQuery = "DELETE FROM ".$this->db_table_interactions.
                                     " WHERE $userIdAttribute = $userId 
                                       AND   $videoIdAttribute = $videoId 
                                       AND $interactionTypeAttribute =  $interactionType";

            $this->updateQuery = "UPDATE $this->db_table_video
                                  SET  $interaction = $interaction - 1
                                  WHERE $this->db_table_video.$videoIdAttribute = $videoId";
            echo  $this->updateQuery ."\n";
    }

    public function doAction($userId, $videoId, $videoURL, $interaction, $action){

        switch ($interaction) {
            // $interaction = 1 means a LIKE interaction
            case "1":

                if ($action == "SET_INTERACTION") { // $action = 1 means a LIKE action
                    $this->setInteraction($userId, $videoId, $videoURL, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->videoURLAttribute, $this->interactionTypeAttribute, $this->videoLikes);
                }
                if ($action == 0) { // $action = 0 means an UNLIKE action (LIKE button unpressed)
                    $this->unsetInteraction($userId, $videoId, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->interactionTypeAttribute, $this->videoLikes);
                }
                break;
            // $interaction = 2 means a DISLIKE interaction
            case "2":
                echo "in case 2";

                if ($action == "SET_INTERACTION") { // $action = 1 means a LIKE action
                    $this->setInteraction($userId, $videoId, $videoURL, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->videoURLAttribute, $this->interactionTypeAttribute, $this->videoDislikes);
                }
                if ($action == "UNSET_INTERACTION") { // $action = 0 means an UNLIKE action (LIKE button unpressed)
                    echo "in the 0 action";
                    $this->unsetInteraction($userId, $videoId, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->interactionTypeAttribute, $this->videoDislikes);
                }
                break;
            case "3":   // $interaction = 3 means a SHARE interaction

                if ($action == "SET_INTERACTION") { // $action = 1 means a LIKE action
                    $this->setInteraction($userId, $videoId, $videoURL, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->videoURLAttribute, $this->interactionTypeAttribute, $this->videoShares);
                }
                if ($action == "UNSET_INTERACTION") { // $action = 0 means an UNLIKE action (LIKE button unpressed)
                    $this->unsetInteraction($userId, $videoId, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->interactionTypeAttribute, $this->videoShares);
                }
                break;
            case "4":   // $interaction = 4 means a DOWNLOAD interaction

                if ($action == "SET_INTERACTION") { // $action = 1 means a LIKE action
                    $this->setInteraction($userId, $videoId, $videoURL, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->videoURLAttribute, $this->interactionAttribute, $this->videoDownloads);
                }
                if ($action == "UNSET_INTERACTION") { // $action = 0 means an UNLIKE action (LIKE button unpressed)
                    $this->unsetInteraction($userId, $videoId, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->interactionAttribute, $this->videoDownloads);
                }
                break;
            case "5":  // $interaction = 5 means a SAVE interaction

                if ($action == "SET_INTERACTION") { // $action = 1 means a LIKE action
                    $this->setInteraction($userId, $videoId, $videoURL, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->videoURLAttribute, $this->interactionAttribute, $this->videoSave);
                }
                if ($action == "UNSET_INTERACTION") { // $action = 0 means an UNLIKE action (LIKE button unpressed)
                    $this->unsetInteraction($userId, $videoId, $interaction, $this->userIdAttribute, $this->videoIdAttribute,
                        $this->interactionAttribute, $this->videoSave);
                }
                break;
            default:
                echo $this->interactionQuery = "Could not determine interaction!";
        }

        $db_connection =  $this->db->getDb();
        $db_connection->query($this->interactionQuery); // Did not use mysqli_query because it always gives true with DELETE even when query fails
        echo $db_connection->affected_rows ."\n";

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