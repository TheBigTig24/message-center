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
            if (isset($_GET['userId'])) {

                $userId = $_GET['userId'];
                $response = getUserById($pdo, $userId);
                if (isset($response['status']) && $response['status'] === 'error') {
                    sendErrorResponse($response['status'], $response['message'], $response['code'] ?? 500);
                } else {
                    sendSuccessResponse('User fetched successfully.', $response);
                }

            } else {

                $response = getAllUsers($pdo);
                if (isset($response['status']) && $response['status'] === 'error') {
                    sendErrorResponse($response['status'], $response['message'], 500);
                } else {
                    sendSuccessResponse('Users fetched successfully.', $response);
                }

            }
            break;

        case 'POST':
            $response = postUser($pdo, json_decode(file_get_contents('php://input')));
            if (isset($response['status']) && $response['status'] === 'error') {
                sendErrorResponse($response['status'], $response['message'], $response['code'] ?? 500);
            } else {
                sendSuccessResponse('User created successfully.', $response);
            }
            break;

        case 'PUT':
            // Handle PUT request
            break;

        case 'DELETE':
            // Handle DELETE request
            break;

        default:
            sendErrorResponse('error', 'Method not allowed.', 405); // Method Not Allowed
            break;
    }

    function getAllUsers($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM mcusers");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching users: " .$e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Error fetching users.',
                'code' => '500' // Internal Server Error
            ];
        }
    }

    function getUserById($pdo, $userId) {
        if (empty($userId)) {
            return [
                'status' => 'error',
                'message' => 'User ID is required.',
                'code' => '400' // Bad Request
            ];
        }

        // ensure userId is an integer
        if (!is_numeric($userId) || $userId <= 0) {
            return [
                'status' => 'error',
                'message' => 'User ID must be an integer greater than 0.',
                'code' => '400' // Bad Request
            ];
        }
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM mcusers WHERE user_id = :userId");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                return $user;
            } else {
                return [
                    'status' => 'error',
                    'message' => 'User not found.',
                    'code' => '404' // Not Found
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Internal server error  while fetching user.',
                'code' => '500' // Internal Server Error
            ];
        }
    }

    function postUser($pdo, $userData) {

        // Validate the user data existence
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'status' => 'error',
                'message' => 'Invalid JSON data.',
                'code' => '400' // Bad Request
            ];
        }
        
        // Extract user data
        $username = $userData->username ?? null;
        $password = $userData->password ?? null;
        $email = $userData->email ?? null;

        // Validate required fields
        if (empty($username) || empty($password) || empty($email)) {
            return [
                'status' => 'error',
                'message' => 'Username, password, and email are required.',
                'code' => '400' // Bad Request
            ];
        }

        // Hash the password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Check if the username already exists
        try {
            $stmt = $pdo->prepare("SELECT * FROM mcusers WHERE username = :username OR email = :email");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($users) > 0) {
                return [
                    'status' => 'error',
                    'message' => 'Username or email already exists.',
                    'code' => '409' // Conflict
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error checking username.',
                'code' => '500' // Internal Server Error
            ];
        }

        // Insert the new user into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO mcusers (username, email, password_hash) 
            VALUES (:username, :email, :password_hash)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $password_hash);
            $stmt->execute();
            
            $userId = $pdo->lastInsertId();
            return $userId;
        } catch (PDOException $e) {
            return ([
                'status' => 'error',
                'message' => 'Error inserting user.',
                'code' => '500' // Internal Server Error
            ]);
        }
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