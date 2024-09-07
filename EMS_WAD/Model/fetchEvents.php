<?php
if (isset($_GET['s']) && !empty($_GET['s'])) {
    session_id($_GET['s']);
}
session_start();
include '../DbConnector/DbConnector.php';

class EventRegistrations extends DbConnector
{
    private $organizer_id;
    private $con;

    public function __construct()
    {
        $this->organizer_id = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;
        $this->con = $this->connect();
    }

    public function getEvents($search = '')
    {
        $sql = "
    SELECT 
        A.event_id, 
        A.event_title, 
        IFNULL(B.response_count, 0) AS response_count 
    FROM 
        event A
    LEFT JOIN (
        SELECT 
            event_id, 
            COUNT(purchase_id) AS response_count 
        FROM 
            user_purchase_event 
        GROUP BY 
            event_id
    ) B ON A.event_id = B.event_id 
    WHERE 
        A.organizer_id = :organizer_id
";


        if (!empty($search)) {
            $sql .= " AND event_title LIKE :search";
        }

        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':organizer_id', $this->organizer_id, PDO::PARAM_INT);

        if (!empty($search)) {
            $searchParam = '%' . $search . '%';
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$eventRegistrations = new EventRegistrations();
$events = $eventRegistrations->getEvents($search);

if ($events !== false) {
    echo "<div class='row'>";
    foreach ($events as $event) {
        echo "
            <div class='col-md-6 mb-4'>
                <div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$event['event_title']}</h5>
                        <p class='card-text'>Response Count: {$event['response_count']}</p>
                        <a href='#' class='btn btn-primary' onclick='loadEventRegistrations({$event['event_id']})'>View Registrations</a>
                    </div>
                </div>
            </div>
        ";
    }
    echo "</div>";
} else {
    echo "<p>An error occurred while fetching events.</p>";
}
