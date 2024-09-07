<?php
// Check if a session ID is provided via the query string
if (isset($_GET['s']) && !empty($_GET['s'])) {
    session_id($_GET['s']);
} else {
    // Check if a session ID is provided in the request body
    $data = json_decode(file_get_contents('php://input'));
    $session_id = isset($data->session_id) ? $data->session_id : "";

    if (!empty($session_id)) {
        session_id($session_id);
    } else {
        // Redirect to login page if no valid session ID is provided
        header('Location: http://127.0.0.1/EMS_WAD/pages/login.html');
        exit();
    }
}

// Start the session with the provided session ID
session_start();

// Invalidate the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session data on the server

// Redirect to the index page or another appropriate page
header('Location: http://127.0.0.1/EMS_WAD/pages/index.php');
exit();
