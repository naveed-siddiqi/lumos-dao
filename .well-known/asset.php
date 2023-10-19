<?php
    /* THIS FILE DEALS WITH ASSET FUNCTIONS */
    
    //uploading of asset image
    if ($_SERVER["REQUEST_METHOD"] === "POST" && $_GET['type'] == "upload") {
        if (isset($_FILES["file"])) {
            $file = $_FILES["file"];
            $uploadDirectory = 'images/'; // Define your upload directory
    
            // Check if the file is an image
            $imageType = exif_imagetype($file["tmp_name"]);
            $allowedTypes = [
                IMAGETYPE_JPEG,
                IMAGETYPE_PNG,
                IMAGETYPE_GIF,
            ];
    
            if (!in_array($imageType, $allowedTypes)) {
                echo "Invalid image file format. Please upload a JPEG, PNG, or GIF image.";
            } else {
                if (move_uploaded_file($file["tmp_name"], $uploadDirectory . $_GET["name"])) {
                    echo "1";
                } else {
                    echo "0";
                }
            }
        } else {
            echo "0";
        }
    }  
    
    //uploading of asset image
    if ($_GET['type'] == "toml") {
        $filename="./stellar.toml";
        // Read the contents of the file
        $currentData = file_get_contents($filename);
        
        // Check if the dataToAppend is already in the file
        if (strpos($currentData, $_GET['asset']) === false) {
            // If dataToAppend is not found in the file, append it
            file_put_contents($filename, $_GET['asset'], FILE_APPEND);
        }  
        echo 1;
    } 
?>
