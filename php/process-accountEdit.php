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

echo "hello 4 <br>";

$image = $_FILES['profilePicture'];

echo "hello 5 <br>";

if ($image === null) {
    return ['error', 'Please choose an image file.', null];
    echo "Please choose an image file.1";
}

echo "hello 6 <br>";

// if (($image['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
//     return ['error', 'Please choose an image file.', null];
//     echo "Please choose an image file.2";
// }

echo "hello 7 <br>";

if (($image['size'] ?? 0) > 2097152) {
    return ['error', 'Image size must be 5 MB or less.', null];
    echo "Image size must be 5 MB or less.";
}

echo "hello 8 <br>";

$tmpName = $image['tmp_name'] ?? '';
if ($tmpName === '') {
    return ['error', 'The uploaded file is not valid.', null];
    echo "The uploaded file is not valid.";
}

echo "hello 9 <br>";

$imageInfo = @getimagesize($tmpName);
if ($imageInfo === false || empty($imageInfo['mime'])) {
    return ['error', 'Please upload a valid image file.', null];
    echo "Please upload a valid image file.";
}

echo "hello 10 <br>";

$imageName = trim((string) ($image['name'] ?? ''));
if ($imageName === '') {
    $imageName = 'image';
}

echo "hello 11 <br>";

$allowedMimeTypes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
];

echo "hello 12 <br>";

$mimeType = $imageInfo['mime'];
if (!in_array($mimeType, $allowedMimeTypes, true)) {
    return ['error', 'Only JPG, PNG, GIF, and WebP files are allowed.', null];
    echo "Only JPG, PNG, GIF, and WebP files are allowed.";
}

echo "hello 13 <br>";

$imageData = file_get_contents($tmpName);
if ($imageData === false) {
    return ['error', 'Unable to read the uploaded file.', null];
    echo "Unable to read the uploaded file.";
}

echo "hello 14 <br>";

$stmt = $_SESSION["conn"]->prepare("UPDATE `users` SET `username` = ?, 
                                                        `email` = ?, 
                                                        `pfpName` = ?, 
                                                        `pfpType` = ?, 
                                                        `pfpData` = ?, 
                                                        `color` = ?, 
                                                        `timezone` = ?
                                                    WHERE `user_id` = ?");

echo "hello 15 <br>";

$stmt->bind_param("sssssssi",
                        $_POST["username"],
                        $_POST["email"],
                        $imageName,
                        $mimeType,
                        $imageData,
                        $_POST["color"],
                        $_POST["timezone"],
                        $userID);

echo "hello 16 <br>";

if($stmt->execute()) {
     header("Location: /settings.php");
    
    exit;
} else {
    die("failed to update profile information" . $stmt -> error);
}