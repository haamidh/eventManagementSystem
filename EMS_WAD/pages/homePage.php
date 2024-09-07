<?php
if (isset($_GET['s']) && !empty($_GET['s'])) {
    session_id($_GET['s']);
} else {
    $data = json_decode(file_get_contents('php://input'));
    $session_id = isset($data->session_id) ? $data->session_id : "";
    if (!empty($session_id)) {
        session_id($session_id);
    } else {
        header('Location: ../pages/login.html');
    }
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
                                <li class="nav-item" <?php echo empty($_GET['s']) ? 'hidden' : ''; ?>>
                                    <a class="nav-link" onclick="loadMyEvents()">My Events</a>
                                </li>
                                <li class="nav-item" <?php echo empty($_GET['s']) ? 'hidden' : ''; ?>>
                                    <a class="nav-link" onclick="loadPaidEvents()">Paid Events</a>
                                </li>
                                <li class="nav-item" <?php echo empty($_GET['s']) ? 'hidden' : ''; ?>>
                                    <a class="nav-link" onclick="loadMySavedEvents()">Saved Events</a>
                                </li>
                                <li class="nav-item" <?php echo empty($_GET['s']) ? 'hidden' : ''; ?>>
                                    <a class="nav-link" href="http://127.0.0.1/EMS_WAD/pages/addEvent.php?s=<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>">Manage Events</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../Controller/logout.php?s=<?php echo $_GET['s'] ?>"><?php echo empty($_GET['s']) ? 'Sign In' : 'Sign Out'; ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div id="body-container" class="container">
            <!-- Cards will be rendered here -->
        </div>
    </div>

    <script>
        let myArray = [];
        let myArray1 = [];
        let myArray2 = [];
        let cid = 0;

        const sessionId = "<?php echo $_GET['s'] ?>";

        async function loadData(search = "") {
            try {
                const response = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php?search=${search}&s=${sessionId}`);
                const data = await response.json();
                console.log(data);
                myArray = data;
                await loadSaveBtn();
                renderCards(true, 'home');
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        async function eventDetails(event_id) {
            try {
                const response = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php?event_id=${event_id}&s=${sessionId}`);
                const data = await response.json();
                console.log(data);
                myArray2 = data;
                loadEventDetailsModal();
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        async function loadMyEvents() {
            try {
                const response = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php?event=myEvents&s=${sessionId}`);
                const data = await response.json();
                console.log(data);
                myArray = data;
                await loadSaveBtn();
                renderCards(false, 'myEvents');
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        async function loadPaidEvents() {
            try {
                const response = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php?event=paidEvents&s=${sessionId}`);
                const data = await response.json();
                console.log(data);
                myArray = data;
                await loadSaveBtn();
                renderCards(true, 'paidEvents');
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        async function loadMySavedEvents() {
            try {
                const response = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php?event=savedEvents&s=${sessionId}`);
                const data = await response.json();
                console.log(data);
                myArray = data;
                await loadSaveBtn();
                renderCards(true, 'savedEvents');
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        async function loadSaveBtn() {
            try {
                const response = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php?event=savedEvents&s=${sessionId}`);
                const data = await response.json();
                myArray1 = data;
            } catch (error) {
                console.error('Error fetching saved events:', error);
            }
        }

        function setSaveBtn(targetEventId) {
            return myArray1.some(event => event.event_id === targetEventId);
        }

        function handleSearch() {
            const searchBar = document.getElementById('searchBar');
            let value = searchBar.value;
            console.log(value);
            loadData(value);
        }

        async function saveEvent(event_id) {
            try {
                const res = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        event_id: event_id,
                        session_id: sessionId,
                        status: "save"
                    }),
                });
                console.log(res);
                await loadSaveBtn();
                renderCards();
            } catch (error) {
                console.log(error);
            }
        }

        async function unSaveEvent(event_id) {
            try {
                const res = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        event_id: event_id,
                        session_id: sessionId,
                        status: "delete"
                    }),
                });
                console.log(res);
                await loadSaveBtn();
                renderCards();
            } catch (error) {
                console.log(error);
            }
        }

        function buy(val) {
            cid = val;
        }

        async function buyTicket() {
            console.log(cid);
            try {
                const res = await fetch(`http://localhost/EMS_WAD/Controller/homePageController.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        event_id: cid,
                        session_id: sessionId,
                        status: "buyTicket"
                    }),
                });
                console.log(res);
                await loadSaveBtn();
                renderCards();
            } catch (error) {
                console.log(error);
            }
        }

        function renderCards(setAvailable, page) {
            const container = document.getElementById('body-container');
            container.innerHTML = '';

            const row = document.createElement('div');
            row.className = 'card-box row col-12';

            myArray.forEach(item => {
                const col = document.createElement('div');
                col.className = 'col-lg-3 col-md-4 col-sm-10 mb-4';

                const card = document.createElement('div');
                card.className = 'card col-12';

                const btnPannel = document.createElement('div');
                btnPannel.className = 'btnPannel col-12';

                const moreDetails = document.createElement('img');
                moreDetails.src = '../icons/more-info.svg';
                moreDetails.className = 'btnPannel-btn';
                moreDetails.setAttribute('data-bs-toggle', 'modal');
                moreDetails.setAttribute('data-bs-target', '#exampleModal');
                moreDetails.onclick = () => eventDetails(item.event_id);
                moreDetails.alt = 'More Info';

                const saveEventImg = document.createElement('img');
                saveEventImg.src = setSaveBtn(item.event_id) ? '../icons/save.svg' : '../icons/unSave.svg';
                saveEventImg.className = 'btnPannel-btn';
                saveEventImg.alt = 'Save Event';
                saveEventImg.onclick = () => setSaveBtn(item.event_id) ? unSaveEvent(item.event_id) : saveEvent(item.event_id);

                const img = document.createElement('img');
                img.src = item.img_url !== '' ? '../Controller/Images/' + item.img_url : 'https://via.placeholder.com/150';
                img.className = 'card-img-top';
                img.alt = 'Event Image';

                const cardBody = document.createElement('div');
                cardBody.className = 'card-body';

                const cardTitle = document.createElement('h5');
                cardTitle.className = 'card-title d-flex justify-content-center';
                cardTitle.innerText = item.event_title;

                const cardDescription = document.createElement('div');
                cardDescription.className = 'event-description-container';

                const cardText = document.createElement('p');
                cardText.className = 'event-description';
                cardText.innerText = 'Description: ' + item.event_description;

                const cardLink2 = document.createElement('a');
                cardLink2.href = '#';
                cardLink2.className = 'btn btn-outline-primary col-12 mt-1';
                //cardLink2.innerText = (page !== 'home' ? 'View Details' : 'Buy Tickets');
                cardLink2.innerText = 'Buy Tickets';
                cardLink2.setAttribute('data-bs-toggle', 'modal');
                cardLink2.setAttribute('data-bs-target', '#exampleModal1');
                cardLink2.onclick = () => buy(item.event_id)
                cardLink2.hidden = page === 'paidEvents' || page === 'myEvents';

                const cardLink3 = document.createElement('a');
                cardLink3.href = 'http://127.0.0.1/EMS_WAD/pages/eventSummaryPage.php?s=<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>&eventId=' + item.event_id;
                cardLink3.className = 'btn btn-outline-primary col-12 mt-1';
                //cardLink2.innerText = (page !== 'home' ? 'View Details' : 'Buy Tickets');
                cardLink3.innerText = 'View Details';
                // cardLink3.setAttribute('data-bs-toggle', 'modal');
                // cardLink3.setAttribute('data-bs-target', '#exampleModal1');
                cardLink3.onclick = () => buy(item.event_id)
                cardLink3.hidden = page !== 'paidEvents';

                cardBody.appendChild(img);
                cardBody.appendChild(cardDescription);
                cardDescription.appendChild(cardText);
                cardBody.appendChild(cardLink2);
                cardBody.appendChild(cardLink3);
                card.appendChild(btnPannel);
                btnPannel.appendChild(moreDetails);
                btnPannel.appendChild(saveEventImg);
                card.appendChild(cardTitle);
                card.appendChild(cardBody);
                col.appendChild(card);
                row.appendChild(col);


            });

            container.appendChild(row);
        }

        function loadEventDetailsModal() {
            document.getElementById('event_title').innerHTML = myArray2[0]['event_title'];
            document.getElementById('event_description').innerHTML = myArray2[0]['event_description'];
            document.getElementById('start_date').innerHTML = myArray2[0]['start_date'];
            document.getElementById('start_time').innerHTML = myArray2[0]['start_time'];
            document.getElementById('end_date').innerHTML = myArray2[0]['end_date'];
            document.getElementById('end_time').innerHTML = myArray2[0]['end_time'];
            document.getElementById('venue').innerHTML = myArray2[0]['venue'];
            document.getElementById('ticket_price').innerHTML = myArray2[0]['ticket_price'];
        }

        loadData();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="event_title">event_title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="event_description"></h4>
                    <h6>Start Date:- <span id="start_date"></span> At <span id="start_time"></span></h6>
                    <h6>End Date:- <span id="end_date"></span> At <span id="end_time"></span></h6>
                    <h6>Venue:- <span id="venue"></span> </h6>
                    <h6>Ticket Price:- <span id="ticket_price"></span> LKR</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> Buy Ticket </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <h2> Do you want to buy a ticket ? </h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close </button>

                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="buyTicket()"> Buy </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>