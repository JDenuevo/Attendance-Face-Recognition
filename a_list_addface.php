<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

if (isset($_POST['add_face'])) {
  $file = addslashes(file_get_contents($_FILES["file"]["tmp_name"]));
  $errors = array();
  $errors1 = array();
  $targetDir = "./FaceRecognition/labels/"; // specify the directory to create the folder in
  $folderName = $_POST['employee_id']; // get the folder name from the form
  $targetPath = $targetDir . $folderName . '/'; // create the target path with the folder name

  if (!is_dir($targetPath)) { // check if the folder already exists
    mkdir($targetPath); // create the folder if it doesn't exist
  } else {
    $filename = basename($_FILES["file"]["name"]);
    $existing_file = $targetPath . $filename;
    if (file_exists($existing_file) && basename($_FILES["file"]["name"]) == "1.png" || file_exists($existing_file) && basename($_FILES["file"]["name"]) == "1.jpeg" || file_exists($existing_file) && basename($_FILES["file"]["name"]) !== "1.jpg") {
      // Delete existing file with the same name
      unlink($existing_file);
    }else{
    if (basename($_FILES["file"]["name"]) !== "1.png" && basename($_FILES["file"]["name"]) !== "1.jpeg" && basename($_FILES["file"]["name"]) !== "1.jpg") {
      //add a sweet_alert in a_list
      $errors[] = "Invalid file name. Only 1.png or 1.jpeg and 1.jpg are allowed.";
      $errorString = implode(',', $errors);
      $url = 'a_list?errors=' . urlencode($errorString);
      echo "<script>window.location.href='$url';</script>";
      exit();
    }
   }
  }

  if (!empty($_FILES['file']['name'])) { // check if file was uploaded
    $targetFile = $targetPath . basename($_FILES["file"]["name"]); // get the target file path
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file name is valid
    if (basename($_FILES["file"]["name"]) !== "1.png" && basename($_FILES["file"]["name"]) !== "1.jpeg" && basename($_FILES["file"]["name"]) !== "1.jpg") {
      //add a sweet_alert in a_list
      $errors[] = "Invalid file name. Only 1.png or 1.jpeg and 1.jpg are allowed.";
      $errorString = implode(',', $errors);
      $url = 'a_list?errors=' . urlencode($errorString);
      echo "<script>window.location.href='$url';</script>";
      exit();
    }

    // Check if image file is a actual image or fake image
    if (isset($_POST["add_face"])) {
      $check = getimagesize($_FILES["file"]["tmp_name"]);
      if ($check !== false) {
        $uploadOk = 1;
      } else {
        $errors[] = "File is not an image.";
        $uploadOk = 0;
      }
    }

// Limit file size
$max_file_size = 30720; // 30KB in bytes
if ($_FILES["file"]["size"] > $max_file_size) {
  //add a sweet_alert in a_list
  $errors[] = "Sorry, your file must be less than 30KB.";

}
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      //add a sweet_alert in a_list
      $errors[] = "Sorry, only JPG, JPEG, & PNG files are allowed.";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      //add a sweet_alert in a_list
      $errors[] = "Sorry, your file was not uploaded. Please insert an Image file.";
      if (!empty($errors)) {
        // Redirect back to the a_list page with the error messages
        $errorString = implode(',', $errors);
        $url = 'a_list?errors=' . urlencode($errorString);
        echo "<script>window.location.href='$url';</script>";
        exit();
    }
    } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        $errors1[] = "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
      } else {
        //add a sweet_alert in a_list
        $errors[] = "Sorry, there was an error uploading your file.";
        exit();
      }
    }
  }
      if (!empty($errors)) {
        // Redirect back to the a_list page with the error messages
        $errorString = implode(',', $errors);
        $url = 'a_list?errors=' . urlencode($errorString);
        echo "<script>window.location.href='$url';</script>";
        exit();
    } else if (!empty($errors1)) {
        // Redirect back to the a_list page with the error messages
        $errorString1 = implode(',', $errors1);
        $url = 'a_list?errors1=' . urlencode($errorString1);
        echo "<script>window.location.href='$url';</script>";
        exit();
    } else {
        // no errors, something went wrong
        $errors[] = "Something went wrong. Please try again later.";
        $errorString = implode(',', $errors);
        $url = 'a_list?errors=' . urlencode($errorString);
        echo "<script>window.location.href='$url';</script>";
        exit();
    }
}

?>
