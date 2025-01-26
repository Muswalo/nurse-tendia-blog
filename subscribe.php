<?php

require_once __DIR__ . '/vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Controllers\Controllers;

$controller = new Controllers();

session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

if (empty($name) || empty($email)) {
    http_response_code(400);
    echo json_encode(['message' => 'Name and email are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid email address']);
    exit;
}

try {
    $success = $controller->subscribeWithName($email, $name);

    if ($success) {
        http_response_code(201);
        echo json_encode(['message' => 'Subscribed successfully']);
    } else {
        http_response_code(409);
        echo json_encode(['message' => 'Email already subscribed']);
    }
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode(['message' => 'Internal Server Error']);
}