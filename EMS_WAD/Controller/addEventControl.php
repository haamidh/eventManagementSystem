<?php
if (isset($_GET['s']) && !empty($_GET['s'])) {
  session_id($_GET['s']);
}
session_start();
require './../DbConnector/DbConnector.php';
require './addevent.php';

$dbcon = new DbConnector();
$con = $dbcon->connect();

$organizer_id = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;

$title = $_POST['title'];
$description = $_POST['description'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$venue = $_POST['venue'];
$maxParticipant = $_POST['maxParticipant'];
$ticketPrice = $_POST['ticketPrice'];
$file = $_FILES['image'];
$file_name = $file['name'];
$tempname = $file['tmp_name'];
$file_size = $file['size'];
$file_error = $file['error'];
$file_type = $file['type'];

// Debugging Information
error_log("File Name: $file_name");
error_log("Temp Name: $tempname");
error_log("File Size: $file_size");
error_log("File Error: $file_error");
error_log("File Type: $file_type");

// Define allowed file types and max file size
$allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
$max_file_size = 10 * 1024 * 1024; // 10MB

// Check for upload errors
if ($file_error === UPLOAD_ERR_OK) {
  // Check if the file type is allowed
  if (in_array($file_type, $allowed_types)) {
    // Check if the file size is within the limit
    if ($file_size <= $max_file_size) {
      // Generate a unique name for the file
      $unique_name = uniqid('', true) . "." . pathinfo($file_name, PATHINFO_EXTENSION);
      $folder = 'Images/' . $unique_name;

      // Ensure the directory exists and is writable
      if (!is_dir('Images')) {
        mkdir('Images', 0777, true);
      }

      // Move the file to the designated folder
      if (move_uploaded_file($tempname, $folder)) {
        // Create the new event with the unique file name
        $newEvent = new AddEvent($title, $description, $startDate, $endDate, $startTime, $endTime, $venue, $maxParticipant, $organizer_id, $ticketPrice, $unique_name);
        $s = isset($_GET['s']) ? $_GET['s'] : '';
        if ($newEvent->addEvent($con)) {
          echo '<script>
                          alert("Event Added Successfully");
                          window.location.href="../pages/addEvent.php?s=' . $s . '";
                      </script>';
        } else {
          echo '<script>
                              alert("Failed to add event.");
                              window.location.href="../pages/addEvent.php?s=' . $s . '";
                              </script>';
        }
      } else {
        echo '<script>
                          alert("Failed to upload image.");
                          window.location.href="../pages/addEvent.php?s=' . $s . '";
                          </script>';
      }
    } else {
      echo '<script>
                  alert("File size exceeds 10MB limit.");
                  window.location.href="../pages/addEvent.php?s=' . $s . '";
                  </script>';
    }
  } else {
    echo '<script>
              alert("Invalid file type. Only JPEG, PNG, and GIF are allowed.");
              window.location.href="../pages/addEvent.php?s=' . $s . '";
              </script>';
  }
} else {
  echo '<script>
          alert("File upload error. Error code: ' . $file_error . '");
          window.location.href="../pages/addEvent.php?s=' . $s . '";
          </script>';
}
