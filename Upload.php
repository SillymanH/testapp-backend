<?php

    $photoType = "";
    $channelId = "";
    $target_dir = "";

    if (isset($_POST["channelId"])){

        $channelId = $_POST["channelId"];
    }

    if (isset($_POST["photoType"])){

        $photoType = $_POST["photoType"];
    }

    if ($photoType == "coverPhoto"){

        $target_dir = "uploads/channels/$channelId/photos/cover_photos";
    }else {

        if ($photoType == "profilePhoto") {

            $target_dir = "uploads/channels/$channelId/photos/profile_photos";
        }else {
            echo json_encode([
                "Message" => "Photo type does not exist",
                "Status" => "Error",
//           "userId" => $_REQUEST["userId"]
            ]);
            return;
        }
    }

    if(!file_exists($target_dir)) {

        mkdir($target_dir, 0777, true);
    }

    $target_dir = $target_dir . "/" . basename($_FILES["file"]["name"]);

    echo $target_dir;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir)) {

        echo json_encode([
            "Message" => "The image ". basename( $_FILES["file"]["name"]). " has been uploaded.",
            "Status" => "OK",
//            "userId" => $_REQUEST["userId"]
        ]);
    } else {

        echo json_encode([
            "Message" => "Sorry, there was an error uploading your file.",
            "Status" => "Error",
//            "userId" => $_REQUEST["userId"]
        ]);

    }