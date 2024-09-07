<?php
if (isset($_GET['s']) && !empty($_GET['s'])) {
    session_id($_GET['s']);
} else {
    $data = json_decode(file_get_contents('php://input'));
    $session_id = isset($data->session_id) ? $data->session_id : "";
    if (!empty($session_id)) {
        session_id($session_id);
    }
    //else {
    //     header('Location: ../pages/login.html');
    // }
}
session_start();

$userId = $_SESSION['userId'] ?? null;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../Model/homePageDbh.php';



class HomePageController
{
    public function handleRequest()
    {
        $method = $_SERVER["REQUEST_METHOD"];

        switch ($method) {
            case "GET":
                $this->handleGetRequest();
                break;
            case "POST":
                $this->handlePostRequest();
                break;
            default:
                echo json_encode("invalid request type...!!!");
        }
    }

    public function handleGetRequest()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : "";
        $event = isset($_GET['event']) ? $_GET['event'] : "";
        $event_id = isset($_GET['event_id']) ? $_GET['event_id'] : "";
        $eventId = isset($_GET['eventId']) ? $_GET['eventId'] : "";

        if (!empty($event_id)) {
            $obj = new HomePageDbh();
            $data = $obj->getEventDetails($event_id);
        } else if (!empty($eventId)) {
            $obj = new HomePageDbh();
            $data = $obj->getEventDetail($eventId);
        } else if (empty($event)) {
            $obj = new HomePageDbh();
            $data = $obj->getEvents($search);
        } else if ($event == "myEvents") {
            $obj = new HomePageDbh();
            $data = $obj->getMyEvents();
        } else if ($event == "paidEvents") {
            $obj = new HomePageDbh();
            $data = $obj->getMyPaidEvents();
        } else {
            $obj = new HomePageDbh();
            $data = $obj->getSavedEvents();
        }

        echo json_encode($data);
    }

    public function handlePostRequest()
    {
        $data = json_decode(file_get_contents('php://input'));
        $event_id = isset($data->event_id) ? $data->event_id : "";
        $status = isset($data->status) ? $data->status : "";

        $obj = new HomePageDbh();

        if ($status == "save") {
            $data = $obj->saveEventInDb($event_id);
        } else if ($status == "buyTicket") {
            $data = $obj->savePurchesEventInDb($event_id);
        } else {
            $data = $obj->removeEventFromDb($event_id);
        }


        echo json_encode($data);
    }
}

$homePage = new HomePageController();
$homePage->handleRequest();
