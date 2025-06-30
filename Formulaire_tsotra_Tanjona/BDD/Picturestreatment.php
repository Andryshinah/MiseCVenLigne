<?php
function verif_Pict($Pictname, $PictTempName, $PictSize) {
    $target_dir = __DIR__ . "\\Images\\";

    // Check if directory exists, if not create it
    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            die("Failed to create directory.");
        }
    }

    $target_filePict = $target_dir . basename($Pictname);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_filePict, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($PictTempName);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        // echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_filePict)) {
        // echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($PictSize > 50000000) {
        // echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return false;
    } else {
        if (move_uploaded_file($PictTempName, $target_filePict)) {
            echo "The file " . htmlspecialchars(basename($Pictname)) . " has been uploaded.";
            return $target_filePict;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}
?>
