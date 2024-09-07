<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if (isset($_GET['eventId']) && !empty($_GET['eventId'])) {
    $eventId = $_GET['eventId'];
} else {
    header('Location: ../pages/login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="eventSummaryPage.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Summary</title>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            async function loadEventDetails() {
                try {
                    const response = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php?eventId=<?php echo $eventId ?>`);
                    const data = await response.json();
                    console.log(data[0].img_url);
                    document.getElementById("description").innerHTML = data[0].event_description || "No description available";
                    document.getElementById("startDay").innerHTML = data[0].start_date || "N/A";
                    document.getElementById("startTime").innerHTML = data[0].start_time || "N/A";
                    document.getElementById("EndDay").innerHTML = data[0].end_date || "N/A";
                    document.getElementById("endTime").innerHTML = data[0].end_time || "N/A";
                    document.getElementById("venue").innerHTML = data[0].venue || "N/A";
                    document.getElementById("ticket").innerHTML = data[0].ticket_price || "N/A";

                    const imgElement = document.querySelector('img');
                    imgElement.src = data[0].img_url ? `../Controller/Images/${data[0].img_url}` : 'https://via.placeholder.com/150';
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            }
            loadEventDetails();
        });
    </script>
</head>

<body>
    <div class="row" id="header-container">
        <div class="col-3">
            <h1><span style="color: #7D0DC3;">UWU</span> Events</h1>
        </div>
        <div class="col-3">
            <input type="text" class="form-control mt-3" name="search" id="searchBar" onkeyup="handleSearch()" placeholder="Search">
        </div>
        <div class="nav-bar col-6">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homePage.php?s=<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>" onclick="loadData()">Home</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-7 col-sm-12 mb-4">
                <img src="https://via.placeholder.com/150" class="img-fluid" alt="event post" />
            </div>
            <div class="col-lg-5 col-sm-12">
                <p id="description">
                    Loading...
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Start Date</th>
                                <td id="startDay">Loading...</td>
                                <th>Start Time</th>
                                <td id="startTime">Loading...</td>
                            </tr>
                            <tr>
                                <th>End Date</th>
                                <td id="EndDay">Loading...</td>
                                <th>End Time</th>
                                <td id="endTime">Loading...</td>
                            </tr>
                            <tr>
                                <th>Venue</th>
                                <td colspan="3" id="venue">Loading...</td>
                            </tr>
                            <tr>
                                <th>Ticket Price</th>
                                <td colspan="3" id="ticket">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>