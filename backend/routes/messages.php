<?php
    $pdo = require_once 'db_connection.php';

    // Check if the request method is OPTIONS
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("HTTP/1.1 200 OK");
        exit;
    }

    $method = $_SERVER['REQUEST_METHOD'];
    $userId = $GLOBALS['extracted_user_id'] ?? null; // passed by router.php

    switch ($method) {
        case 'GET':
            break;

        case 'POST':
            break;

        default:
            sendErrorResponse('error', 'Method not allowed.', 405); // Method Not Allowed
            break;
    }

    function sendSuccessResponse($message, $data) {
        http_response_code(200); // OK
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    function sendErrorResponse($status, $message, $code) {
        http_response_code($code);
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
        exit();
    }
    
?>