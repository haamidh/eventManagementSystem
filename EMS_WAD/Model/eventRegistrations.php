<?php
session_start(); // Start the session
include '../DbConnector/DbConnector.php';
//$_SESSION['user_id'] = "6";

class EventRegistrations extends DbConnector
{
    private $organizer_id;
    private $con;

    public function __construct()
    {
        // Initialize properties in the constructor
        $this->organizer_id = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;
        $this->con = $this->connect();
    }

    public function getEvents()
    {
        $sql = "SELECT event_id, event_title, response_count FROM event WHERE organizer_id = :organizer_id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':organizer_id', $this->organizer_id, PDO::PARAM_INT);

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
