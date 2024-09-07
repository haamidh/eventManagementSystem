<?php
session_start();
require  './../DbConnector/DbConnector.php';


$dbcon = new DbConnector();
$con = $dbcon->connect();


if (isset($_POST['u_id']) && !empty($_POST['u_id'])) {

  $utitle = $_POST['utitle'];
  $udescription = $_POST['udescription'];
  $ustartDate = $_POST['ustartDate'];
  $uendDate = $_POST['uendDate'];
  $ustartTime = $_POST['ustartTime'];
  $uendTime = $_POST['uendTime'];
  $uvenue = $_POST['uvenue'];
  $umaxParticipant = $_POST['umaxParticipant'];
  $uticketPrice = $_POST['uticketPrice'];
  $uevent_id = $_POST['u_id'];


  $query = "UPDATE event 
SET event_title = ?, 
    event_description = ?, 
    start_date = ?, 
    end_date = ?, 
    start_time = ?, 
    end_time =?, 
    venue = ?, 
    max_count = ?, 
    ticket_price = ? 
WHERE event_id = ?
";

  try {
    $pstmt = $con->prepare($query);
    $pstmt->bindParam(1, $utitle);
    $pstmt->bindParam(2, $udescription);
    $pstmt->bindParam(3, $ustartDate);
    $pstmt->bindParam(4, $uendDate);
    $pstmt->bindParam(5, $ustartTime);
    $pstmt->bindParam(6, $uendTime);
    $pstmt->bindParam(7, $uvenue);
    $pstmt->bindParam(8, $umaxParticipant);
    $pstmt->bindParam(9, $uticketPrice);
    $pstmt->bindParam(10, $uevent_id);

    if ($pstmt->execute()) {
      echo
      '<script> 
          alert("Event updated Successfully");
          window.location.href="../pages/addEvent.php";
          </script>';
    }
  } catch (PDOException $exc) {

    die("Error occured when updating event" . $exc->getMessage());
  }
}
