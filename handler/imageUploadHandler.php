<?php
$target_dir = "img/";

$target_file = $target_dir . basename($_FILES["carPhoto"]["name"]);

$uploadOk = 1;

$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["carPhoto"]["tmp_name"]);

    //check the image is the fake image or not
    if ($check!==false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if ($_FILES["ItemPhoto"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png"
    && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "The file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["carPhoto"]["tmp_name"],'../'.$target_file)) {
            echo "The file " . basename($_FILES["carPhoto"]["name"]) . " has been uploaded.";
            echo "<br>";
            echo $_FILES["carPhoto"]["tmp_name"];
            echo "<br>";
            echo $target_file; //the image file path :)
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>