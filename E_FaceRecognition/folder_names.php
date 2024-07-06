<?php
session_start();
$dir = '../FaceRecognition/labels/';
$userId = $_SESSION['id']; // Assuming the session id contains the user's id
$folders = array_filter(glob($dir . '/*'), 'is_dir');
$folderNames = array_map('basename', $folders);
$userFolder = $userId; // set user folder name to session id by default

// Check if the folder with the user id exists
if (in_array($userId, $folderNames)) {
  $userFolder = $userId;
} else {
  echo "User folder not found!";
  exit();
}

echo json_encode([$userFolder]); // Return only the user's folder name as an array
?>
