<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $password1 = isset($_POST['password1']) ? $_POST['password1'] : null;
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : null;

    if (!empty($username) && !empty($email) && !empty($password1) && !empty($password2)) {
        if ($password1 === $password2) {
            $host = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "ems_wad_project";

            // Create Connection
            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
            } else {
                $SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
                $INSERT = "INSERT INTO register (username, email,phone, password1) VALUES (?, ?, ?, ?)";

                // Prepare Statement
                $stmt = $conn->prepare($SELECT);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                $rnum = $stmt->num_rows;

                // Checking email
                if ($rnum == 0) {
                    $stmt->close();
                    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare($INSERT);
                    $stmt->bind_param("ssss", $username, $email, $phone, $hashed_password);
                    $stmt->execute();
                    echo "Registered Successfully";
                    header("Location: ../pages/login.html");
                    exit();
                } else {
                    echo "This Email is Already Registered";
                }

                $stmt->close();
                $conn->close();
            }
        } else {
            echo "Passwords do not match";
        }
    } else {
        echo "All fields are required";
        die();
    }
} else {
    echo "All fields are required";
    die();
}
