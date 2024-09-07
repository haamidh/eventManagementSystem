<?php
include '../DbConnector/DbConnector.php';

class EventRegistrations extends DbConnector
{
    private $con;

    public function __construct()
    {
        $this->con = $this->connect();
    }

    public function getEventRegistrations($event_id)
    {
        // $sql = "SELECT * FROM event_registrations WHERE event_id = :event_id";
        $sql = "SELECT A.*, B.userId as organizer_id, B.username, B.phone FROM user_purchase_event A, register B  WHERE A.event_id = :event_id and A.user_id = B.userId";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);

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

$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : 0;
$eventRegistrations = new EventRegistrations();
$registrations = $eventRegistrations->getEventRegistrations($event_id);

if ($registrations !== false) {
    echo "<h2>Registrations for Event ID: $event_id</h2>";
    echo '<div class="container">'; // Use a container for better spacing

    foreach ($registrations as $registration) {
        echo "
        <div class='row mb-4'> <!-- Add margin-bottom for spacing between cards -->
            <div class='col-md-6 mx-auto'> <!-- Center the card and limit width -->
                <div class='card'>
                    <div class='card-body'>
                        <p class='card-text'>Name :</p>
                        <h5 class='card-title'>{$registration['username']}</h5>
                        <p class='card-text'>Phone Number :</p>
                        <h5 class='card-title'>{$registration['phone']}</h5>
                        <p class='card-text'>Ticket Number :</p>
                        <h5 class='card-title'>{$registration['purchase_id']}</h5>
                    </div>
                </div>
            </div>
        </div>
        ";
    }

    echo '</div>'; // Close container
} else {
    echo "<p>An error occurred while fetching registrations.</p>";
}
