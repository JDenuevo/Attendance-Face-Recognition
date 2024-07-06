<?php
session_start();
include 'dbconn.php';

if (isset($_POST['add_policy'])) {
  $p_title = trim($_POST['p_title']);
  $p_description = trim($_POST['p_description']);
  $errors1 = array();

  // Check if the title already exists in the database
  $query_check = "SELECT * FROM bergs_policies WHERE policy_name = '$p_title'";
  $query_check_run = mysqli_query($conn, $query_check);
  $num_rows = mysqli_num_rows($query_check_run);

  if ($num_rows > 0) {
    // If the title already exists, display an error message or take some other action
    echo "<script>alert('Policy already exists!')</script>";
    echo "<script>window.location.href = 'a_policies';</script>";
  } else {
    // If the title does not exist, insert the new policy into the database
    $query_insert = "INSERT INTO bergs_policies SET
      `policy_name`='$p_title',
      `policy_descriptions`= '$p_description'";
    $query_insert_run = mysqli_query($conn, $query_insert);

    if ($query_insert_run) {
      $errors1[] = "Policy was successfully added.";
      // echo "<script>alert('Policy successfully added!')</script>";
      // echo "<script>window.location.href = 'a_policies';</script>";
      // exit; // Add this line to stop further PHP execution
    } if (!empty($errors1)) {
      // Redirect back to the login page with the error messages
      $errorString1 = implode(',', $errors1);
      header('Location: a_policies?errors1=' . urlencode($errorString1));
      exit();
  }

    // Close database connection and redirect user
    $conn->close();
  }
}
?>
