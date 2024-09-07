<?php
require  './../DbConnector/DbConnector.php';


$dbcon = new DbConnector();
$con = $dbcon->connect();

if (isset($_POST['u_id']) && !empty($_POST['u_id'])) {
  $uevent_id = $_POST['u_id'];

  $query = "DELETE FROM event where event_id=?";

  try {
    $pstmt = $con->prepare($query);

    $pstmt->bindParam(1, $uevent_id);

    if ($pstmt->execute()) {
      echo
      '<script> 
            alert("Event Deleted Successfully");
            window.location.href="../pages/addEvent.php";
            </script>';
    }
  } catch (PDOException $exc) {

    die("Error occured when Deleting event" . $exc->getMessage());
  }
}
