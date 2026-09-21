<?php
session_start();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = isset($data['email']) ? trim($data['email']) : '';

if ($email === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Email is required.']);
    exit;
}

$_SESSION['loggedin'] = true;
$_SESSION['email'] = $email;

echo json_encode(['status' => 'ok']);
