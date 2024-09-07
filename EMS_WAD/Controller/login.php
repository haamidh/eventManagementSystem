<?php
session_start();
header('Access-Control-Allow-Origin: http://localhost/EMS_WAD/Controller/login.php'); // Replace with your client domain
header('Access-Control-Allow-Credentials: true');


// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!empty($email) && !empty($password)) {
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "ems_wad_project";

        // Create connection
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
        } else {
            $SELECT = "SELECT * FROM register WHERE email = ? LIMIT 1";
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password1'])) {
                    $_SESSION['userId'] = $row['userId'];
                    $_SESSION['email'] = $row['email'];
                    // Redirect to homepage     with session ID
                    //echo session_id();
                    //header(`Location: homePageController.php`);
                    header('Location: ../pages/homePage.php?s=' . session_id());
                    exit();
                } else {
                    echo "Invalid email or password.";
                }
            } else {
                echo "Invalid email or password.";
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Both email and password are required.";
    }
} else {
    echo "Invalid request method.";
}
