<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
require($_SERVER['DOCUMENT_ROOT'] . '/php/modMath.php');
dbConnect();

$userID = $_SESSION["user_id"];

echo "hello 1 <br>";

$sql = "SELECT * FROM users WHERE user_id = $userID";
            $result = $_SESSION["conn"]->query($sql);
            $user = $result->fetch_assoc();  

echo "hello 2 <br>";

if (empty($_POST["username"])) {
    die("Username is required");
}

echo "hello 3 <br>";

if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}


    $image = $_FILES['profilePicture'];

if ($image !== "") {
    echo "hi there";
    if ($image === null) {
        return ['error', 'Please choose an image file.', null];
        echo "Please choose an image file.1";
    }


    if (($image['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['error', 'Please choose an image file.', null];
        echo "Please choose an image file.2";
    }


    if (($image['size'] ?? 0) > 2097152) {
        return ['error', 'Image size must be 5 MB or less.', null];
        echo "Image size must be 5 MB or less.";
    }


    $tmpName = $image['tmp_name'] ?? '';
    if ($tmpName === '') {
        return ['error', 'The uploaded file is not valid.', null];
        echo "The uploaded file is not valid.";
    }


    $imageInfo = @getimagesize($tmpName);
    if ($imageInfo === false || empty($imageInfo['mime'])) {
        return ['error', 'Please upload a valid image file.', null];
        echo "Please upload a valid image file.";
    }


    $imageName = trim((string) ($image['name'] ?? ''));
    if ($imageName === '') {
        $imageName = 'image';
    }


    $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];


    $mimeType = $imageInfo['mime'];
    if (!in_array($mimeType, $allowedMimeTypes, true)) {
        return ['error', 'Only JPG, PNG, GIF, and WebP files are allowed.', null];
        echo "Only JPG, PNG, GIF, and WebP files are allowed.";
    }


    $imageData = file_get_contents($tmpName);
    if ($imageData === false) {
        return ['error', 'Unable to read the uploaded file.', null];
        echo "Unable to read the uploaded file.";
    }


    $stmt = $_SESSION["conn"]->prepare("UPDATE `users` SET `username` = ?, 
                                                            `email` = ?, 
                                                            `pfpName` = ?, 
                                                            `pfpType` = ?, 
                                                            `pfpData` = ?, 
                                                            `color` = ?, 
                                                            `timezone` = ?
                                                        WHERE `user_id` = ?");


    $stmt->bind_param("sssssssi",
                            $_POST["username"],
                            $_POST["email"],
                            $imageName,
                            $mimeType,
                            $imageData,
                            $_POST["color"],
                            $_POST["timezone"],
                            $userID);

} else {
    $stmt = $_SESSION["conn"]->prepare("UPDATE `users` SET `username` = ?, 
                                                            `email` = ?, 
                                                            `color` = ?, 
                                                            `timezone` = ?
                                                        WHERE `user_id` = ?");


    $stmt->bind_param("ssssi",
                            $_POST["username"],
                            $_POST["email"],
                            $_POST["color"],
                            $_POST["timezone"],
                            $userID);
}

if($stmt->execute()) {
     header("Location: /settings.php");
    
    exit;
} else {
    die("failed to update profile information" . $stmt -> error);
}