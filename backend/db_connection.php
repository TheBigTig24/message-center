<?php
    require_once __DIR__ . '../vendor/autoload.php'; //path to your autoload.php

    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // db credentials
    $servername = "localhost";
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = "message_center";

    $dsn = "mysql:host=" . $servername . ";dbname=" . $dbname;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $connection = new PDO($dsn, $username, $password, $options);
        // echo "Connected successfully";

        // connection is a PDO object
        return $connection;

    } catch (Exception $e) {
        error_log("Connection failed: " . $e->getMessage());

        http_response_code(500); // Internal Server Error
        echo json_encode([
            'status' => 'error',
            'message' => 'Database connection failed.'
        ]);
        exit;
    }
?>