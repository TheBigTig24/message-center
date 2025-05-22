<?php
    // db credentials
    $servername = "localhost";
    $username = "root";
    $password = "T!grr4248!";
    $dbname = "message_center";

    // Create Connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "Connected successfully";
?>