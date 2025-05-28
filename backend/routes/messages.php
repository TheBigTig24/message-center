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
            $response = postMessage($pdo, json_decode(file_get_contents('php://input')));
            if (isset($response['status']) && $response['status'] === 'error') {
                sendErrorResponse($response['status'], $response['message'], $response['code'] ?? 500);
            } else {
                sendSuccessResponse('Message created successfully.', $response);
            }
            break;

        default:
            sendErrorResponse('error', 'Method not allowed.', 405); // Method Not Allowed
            break;
    }

    function getMessagesBySenderId($pdo, $senderId) {
        if (empty($senderId)) {
            return [
                'status' => 'error',
                'message' => 'Sender ID is required.',
                'code' => '400' // Bad Request
            ];
        }

        if (!is_numeric($senderId) || $senderId <= 0) {
            return [
                'status' => 'error',
                'message' => 'Invalid Sender ID.',
                'code' => '400' // Bad Request
            ];
        }

        try {
            $stmt = $pdo->prepare("SELECT * FROM mcmessages WHERE sender_id = :sender_id");
            $stmt->bindParam(':sender_id', $senderId, PDO::PARAM_INT);
            $stmt->execute();
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($messages) {
                return $messages;
            } else {
                return [
                    'status' => 'error',
                    'message' => 'No messages found for this sender.',
                    'code' => '404' // Not Found
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error fetching messages: ' . $e->getMessage(),
                'code' => '500' // Internal Server Error
            ];
        }
    }

    function getMessagesByReceiverId($pdo, $receiverId) {
        if (empty($receiverId)) {
            return [
                'status' => 'error',
                'message' => 'Receiver ID is required.',
                'code' => '400' // Bad Request
            ];
        }

        if (!is_numeric($receiverId) || $receiverId <= 0) {
            return [
                'status' => 'error',
                'message' => 'Invalid Receiver ID.',
                'code' => '400' // Bad Request
            ];
        }

        try {
            $stmt = $pdo->prepare("SELECT * FROM mcmessages WHERE receiver_id = :receiver_id");
            $stmt->bindParam(':receiver_id', $receiverId, PDO::PARAM_INT);
            $stmt->execute();
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($messages) {
                return $messages;
            } else {
                return [
                    'status' => 'error',
                    'message' => 'No messages found for this receiver.',
                    'code' => '404' // Not Found
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error fetching messages: ' . $e->getMessage(),
                'code' => '500' // Internal Server Error
            ];
        }
    }

    function postMessage($pdo, $messageData) {
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'status' => 'error',
                'message' => 'Invalid JSON data.',
                'code' => '400' // Bad Request
            ];
        }

        $subject = $messageData->subject ?? null;
        $body = $messageData->body ?? null;
        $senderId = $messageData->senderId ?? null;
        $receiverId = $messageData->receiverId ?? null;

        if (empty($subject) || empty($body) || empty($senderId) || empty($receiverId)) {
            return [
                'status' => 'error',
                'message' => 'All fields are required.',
                'code' => '400' // Bad Request
            ];
        }

        // Insert message into db
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (subject, body, sender_id, receiver_id)
                                  VALUES (:subject, :body, :sender_id, :receiver_id)");
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':body', $body);
            $stmt->bindParam(':sender_id', $senderId);
            $stmt->bindParam(':receiver_id', $receiverId);
            $stmt->execute();

            $messageId = $pdo->lastInsertId();
            return [
                'status' => 'success',
                'message' => 'Message created successfully.',
                'data' => [
                    'id' => $messageId,
                    'subject' => $subject,
                    'body' => $body,
                    'senderId' => $senderId,
                    'receiverId' => $receiverId
                ]
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error creating message: ' . $e->getMessage(),
                'code' => '500' // Internal Server Error
            ];
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