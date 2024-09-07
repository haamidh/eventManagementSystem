<?php
if (isset($_GET['s']) && !empty($_GET['s'])) {
  session_id($_GET['s']);
}
session_start();
//$_SESSION['userId'] = 10;
require './../DbConnector/DbConnector.php';
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;

$dbcon = new DbConnector();
$conn = $dbcon->connect();
$query = "SELECT * FROM event WHERE organizer_id=?";

//$stmt->prepare($query);

$stmt = $conn->prepare($query);
$stmt->bindParam(1, $userId);
$stmt->execute();
$rs = $stmt->fetchAll(PDO::FETCH_OBJ);


?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ADD EVENT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      background-color: #FEF7FF;
      color: #211925;
    }

    .form-container {
      background-color: #FFFFFF;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border: 1px solid #e0e0e0;
    }

    .form-title {
      text-align: center;
      margin-bottom: 20px;
      color: #7D0DC3;
    }

    .event-summary-title {
      text-align: center;
      margin-top: 40px;
      margin-bottom: 20px;
      color: #7D0DC3;
    }

    .event-card {
      margin-bottom: 20px;
      border: 1px solid #e0e0e0;
    }

    .event-card .card-body {
      padding: 15px;
      background-color: #A287B0;
      color: #FEF7FF;
    }

    .btn-primary {
      background-color: #7D0DC3;
      border-color: #7D0DC3;
    }

    .btn-primary:hover {
      background-color: #5C0A9A;
      border-color: #5C0A9A;
    }

    .btn-danger {
      background-color: #C3070D;
      border-color: #C3070D;
    }

    .btn-danger:hover {
      background-color: #A00609;
      border-color: #A00609;
    }

    .card-title {
      color: #FEF7FF;
    }

    .text-muted {
      color: #E0D3E7 !important;
    }
  </style>
  <button onclick="redirectToPage(1)" class="btn btn-primary">Home</button>
  <button onclick="redirectToPage(2)" class="btn btn-primary">Event Registration Details</button>
</head>

<body>
  <script>
    function redirectToPage(val) {
      if (val == 1) {
        window.location.href = 'homePage.php?s=<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      } else {
        window.location.href = 'eventRegistrations.php?s=<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      }
    }
  </script>
  <div class="container">
    <form class="row g-3 form-container" method="POST" action="../Controller/addEventControl.php?s=<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>" enctype="multipart/form-data">
      <h1 class="form-title">ADD EVENT</h1>
      <div class="col-md-6">

        <label for="inputEmail4" class="form-label">Event Title</label>
        <input type="text" class="form-control" id="inputEmail4" name="title" required>
      </div>
      <div class="col-md-6">
        <label for="inputPassword4" class="form-label">Event Description</label>
        <input type="text" class="form-control" id="inputPassword4" name="description" required>
      </div>
      <div class="col-md-3">
        <label for="startDate" class="form-label">Start Date</label>
        <input type="date" class="form-control" id="startDate" name="startDate" required>
      </div>
      <div class="col-md-3">
        <label for="endDate" class="form-label">End Date</label>
        <input type="date" class="form-control" id="endDate" name="endDate" required>
      </div>
      <div class="col-md-3">
        <label for="startTime" class="form-label">Start Time</label>
        <input type="time" class="form-control" id="startTime" name="startTime" required>
      </div>
      <div class="col-md-3">
        <label for="endTime" class="form-label">End Time</label>
        <input type="time" class="form-control" id="endTime" name="endTime" required>
      </div>
      <div class="col-md-6">
        <label for="venue" class="form-label">Venue</label>
        <input type="text" class="form-control" id="venue" name="venue" required>
      </div>
      <div class="col-md-3">
        <label for="maxParticipant" class="form-label">Maximum Participants</label>
        <input type="number" class="form-control" id="maxParticipant" name="maxParticipant" required>
      </div>
      <div class="col-md-3">
        <label for="ticketPrice" class="form-label">Ticket Price</label>
        <input type="number" class="form-control" id="ticketPrice" name="ticketPrice" required>
      </div>
      <div class="col-md-6">
        <label for="img" class="form-label">Image</label>
        <input type="file" class="form-control" id="img" name="image">
         <select> 
               <option>option1</option>
               <option>option1</option>
               <option>option1</option>
               <option>option1</option>
               <option>option1</option>
               <option>option1</option>
               <option>option1</option>
           </select>
      </div>
      <div class="col-12 d-flex justify-content-center">
        <button type="submit" class="btn btn-primary" style="font-weight: bold">Add Event</button>
      </div>
       <div class="col-12 d-flex justify-content-center">
          
      </div>
    </form>

    <!-- event summary start -->

    <h1 class="event-summary-title">Event Summary</h1>
    <div class="row">
      <?php foreach ($rs as $row) : ?>

        <!--card details-->
        <div class="col-md-6">
          <div class="card event-card">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($row->event_title); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars($row->event_description); ?></p>
              <p class="card-text">
                <small class="text-muted">
                  Start: <?php echo htmlspecialchars($row->start_date); ?> at <?php echo htmlspecialchars($row->start_time); ?><br>
                  End: <?php echo htmlspecialchars($row->end_date); ?> at <?php echo htmlspecialchars($row->end_time); ?>
                </small>
              </p>
              <p class="card-text">
                <small class="text-muted">
                  Venue: <?php echo htmlspecialchars($row->venue); ?><br>
                  Participants: <?php echo htmlspecialchars($row->max_count); ?><br>
                  Response Count: <?php echo htmlspecialchars($row->response_count); ?><br>
                  Ticket Price: $<?php echo htmlspecialchars($row->ticket_price); ?>
                </small>
              </p>
              <div class="d-flex justify-content-between">


                <!--edit modal-->

                <div class="modal" tabindex="-1" id="modal-<?php echo $row->event_id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" style="color:black;">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" style="color:black;">
                        <p>Edit Event</p>
                        <!--update form-->

                        <div class="container">
                          <form class="row g-3 form-container" method="POST" action="../Controller/update.php">

                            <input type="hidden" name="u_id" value="<?php echo $row->event_id; ?>">

                            <div class="col-md-10">
                              <label for="inputEmail4" class="form-label">Event Title</label>
                              <input type="text" class="form-control" id="inputEmail4" name="utitle" value="<?php echo htmlspecialchars($row->event_title) ?>" required>
                            </div>
                            <div class="col-md-10">
                              <label for="inputPassword4" class="form-label">Event Description</label>
                              <input type="text" class="form-control" id="inputPassword4" name="udescription" value="<?php echo htmlspecialchars($row->event_description) ?>" required>
                            </div>
                            <div class="col-md-6">
                              <label for="startDate" class="form-label">Start Date</label>
                              <input type="date" class="form-control" id="startDate" name="ustartDate" value="<?php echo htmlspecialchars($row->start_date) ?>" required>
                            </div>
                            <div class="col-md-6">
                              <label for="endDate" class="form-label">End Date</label>
                              <input type="date" class="form-control" id="endDate" name="uendDate" required value="<?php echo htmlspecialchars($row->end_date) ?>">
                            </div>
                            <div class="col-md-6">
                              <label for="startTime" class="form-label">Start Time</label>
                              <input type="time" class="form-control" id="startTime" name="ustartTime" required value="<?php echo htmlspecialchars($row->start_time) ?>">
                            </div>
                            <div class="col-md-6">
                              <label for="endTime" class="form-label">End Time</label>
                              <input type="time" class="form-control" id="endTime" name="uendTime" required value="<?php echo htmlspecialchars($row->end_time) ?>">
                            </div>
                            <div class="col-md-6">
                              <label for="venue" class="form-label">Venue</label>
                              <input type="text" class="form-control" id="venue" name="uvenue" required value="<?php echo htmlspecialchars($row->venue) ?>">
                            </div>
                            <div class="col-md-6">
                              <label for="maxParticipant" class="form-label">Maximum Participants</label>
                              <input type="number" class="form-control" id="maxParticipant" name="umaxParticipant" required value="<?php echo htmlspecialchars($row->max_count) ?>">
                            </div>
                            <div class="col-md-6">
                              <label for="ticketPrice" class="form-label">Ticket Price</label>
                              <input type="number" class="form-control" id="ticketPrice" name="uticketPrice" required value="<?php echo htmlspecialchars($row->ticket_price) ?>">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                        </div>


                      </div>

                    </div>
                  </div>
                </div>


                <!--update button-->


                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modal-<?php echo $row->event_id; ?>">Update</button>




                <!--delete button-->

                <form method="POST" action="../Controller/deleteEvent.php" onsubmit="return confirm('Are you sure you want to delete this store?');">
                  <input type="hidden" name="u_id" value="<?php echo htmlspecialchars($row->event_id); ?>">
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>