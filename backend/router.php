<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    $basic_url = '/';
    $route_pattern = '/^\/routes\/[a-zA-Z0-9_]+/';
    if (preg_match($route_pattern, $request_uri, $matches)) {
        $basic_url = $matches[0];
    }

    switch ($basic_url) {
        case '/':
            $response_data = [
                'status' => 'success',
                'message' => 'Server is running.'
            ];
            echo json_encode($response_data);
            break;

        case '/routes/users':
            require_once 'routes/users.php';
            break;

        case '/routes/messages':
            require_once 'routes/messages.php';
            break;

        default:
            http_response_code(404);
            $response_data = [
                'status' => 'error',
                'message' => 'Route not found.'
            ];
    }
?>