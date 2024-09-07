<?php if (isset($_GET['s']) && !empty($_GET['s'])) {
    // Set the session ID
    session_id($_GET['s']);
} else {
    $data = json_decode(file_get_contents('php://input'));
    $session_id = isset($data->session_id) ? $data->session_id : "";
    if (!empty($session_id)) {
        session_id($session_id);
    }
}
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>U-Events</title>
    <link rel="stylesheet" href="style1.css" />
</head>

<body>
    <nav>
        <div class="nav_logo">
            <a href="#"><span id="logo">UWU</span> Events</a>
        </div>
        <ul class="nav_links" id="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="homePage.php?s=<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>">Events</a></li>
            <li <?php echo isset($_GET['s']) ? "hidden" : '' ?>><a href="login.html">Sign In</a></li>
            <li <?php echo isset($_GET['s']) ? "" : 'hidden' ?>>
                <a class="nav-link" href="../Controller/logout.php?s=<?php echo $_GET['s'] ?>">Sign out</a>
            </li>
            <li>
                <a href="signup.html"><button class="joinBtn">Join</button></a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <div class="container_left">
            <h1>Your <span id="gateway">Gateway </span>For</h1>
            <br />
            <h1><span id="UWU">UWU</span> Events</h1>
            <p>
                Bringing the UWU Family Together, One Event at a Time: <br />Fostering
                unity, and creating lasting memories through <br />engaging events
            </p>
            <div class="btn">
                <a href="#event"><button>Explore Now</button></a>
            </div>
        </div>
        <div class="heroImg">
            <img src="../iMAGES/Untitled design (45).png" alt="HeroImage" />
        </div>
    </div>
    <div class="card-section" id="event">
            <h1>Explore events</h1>
            <div id="card-container"></div>
        </div>

    <?php
    require './DbConnector.php';

    $dbConnector = new DbConnector();
    $conn = $dbConnector->getConnection();

    try {
        $sql = "SELECT ticket_price,event_title, event_description,img_url FROM event LIMIT 8";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $events = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $events[] = $row;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

    <script>
        const events = <?php echo json_encode($events); ?>;
        const cardContainer = document.getElementById("card-container");

//        const imageMapping = {
//            'Concert': '../Images/cardImg.jpg',
//            'Party': '../Images/cardImg2.jpg',
//            'Education': '../Images/cardImg3.jpg'
//        };

        events.forEach(card => {
            const cardElement = document.createElement("div");
            cardElement.classList.add("card");

//            const imageUrl = card.img_url || 'Images/defaultImg.jpg';
            const imageUrl = `../Controller/Images/${card.img_url}`|| 'Images/defaultImg.jpg';

            const displayPrice = card.ticket_price == 0 ? "Free" : `Rs ${card.ticket_price}`;


            cardElement.innerHTML = `
                <img src="${imageUrl}" alt="${card.event_title}">
                <div class="card-content">
                    <span id="price">${displayPrice}</span>
                   <span id="category">${card.category}</span>
                    <p id="date"></p>
                    <h3>${card.event_title}</h3>
                    <p>${card.event_description}</p>
                    <a href="signup.html" class="btn">Buy Tickets</a>
                </div>
            `;

            cardContainer.appendChild(cardElement);
        });
    </script>
    </body>
</html>
