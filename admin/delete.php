<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Utils\Utils;

$controller = new Controllers();

session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
    exit;
}

if (!isset($_SESSION['is_loged_in']) || $_SESSION['is_loged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized']);
    exit;
}

$id = $_POST['id'];

try {
    $controller->deleteBlogPost($id);
    http_response_code(200);
    echo json_encode(['message' => 'Post deleted successfully']);
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode(['message' => 'Internal Server Error']);
}
