<?php
if (isset($_GET['s']) && !empty($_GET['s'])) {
    session_id($_GET['s']);
}
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="homePage.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Manager</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container-fluid">
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
                                <li class="nav-item">
                                    <a class="nav-link" onclick="loadMyEvents()">My Events</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" onclick="loadPaidEvents()">Paid Events</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" onclick="loadMySavedEvents()">Saved Events</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://127.0.0.1/EMS_WAD/pages/addEvent.php?s=<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>">Manage Events</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../Controller/logout.php?s=<?php echo $_GET['s'] ?>">Sign out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div id="body-container" class="container">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadData();

            // Handle search input
            document.getElementById('searchBar').addEventListener('keyup', function() {
                let query = this.value;
                handleSearch(query);
            });
        });

        function loadData() {
            const url = `../Model/fetchEvents.php?s=${encodeURIComponent('<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>')}`;

            fetch(url)
                .then(response => response.text())
                .then(responseText => {
                    document.getElementById('body-container').innerHTML = responseText;
                })
                .catch(error => console.error('Error:', error));
        }

        function handleSearch(query) {
            const url = `../Model/fetchEvents.php?s=${encodeURIComponent('<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>')}&search=${encodeURIComponent(query)}`;

            fetch(url)
                .then(response => response.text())
                .then(responseText => {
                    document.getElementById('body-container').innerHTML = responseText;
                })
                .catch(error => console.error('Error:', error));
        }

        function loadEventRegistrations(eventId) {
            const url = `../Model/fetchEventRegistrations.php?s=${encodeURIComponent('<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>')}&event_id=${encodeURIComponent(eventId)}`;

            fetch(url)
                .then(response => response.text())
                .then(responseText => {
                    document.getElementById('body-container').innerHTML = responseText;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>