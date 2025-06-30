<?php
function verif_CV_file($CVfilename, $CVfiletmpname, $CVfilesize) {
    $target_dir = __DIR__ . "\\UploadCV\\";

    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            die("can't create this dir");
        }
    }

    $target_file = $target_dir . basename($CVfilename);
    $uploadOk = 1;
    $CVFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  
    if ($CVfilesize > 50000000) {
        // echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

   
    if ($CVFileType != "pdf" && $CVFileType != "doc" && $CVFileType != "docx") {
        // echo "Sorry, only docx, pdf, and doc formats are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        // echo "Sorry, your file was not uploaded.";
        return false;
    } else {
        if (move_uploaded_file($CVfiletmpname, $target_file)) {
            echo "The file " . htmlspecialchars(basename($CVfilename)) . " has been uploaded.";
            return $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}
?>
