<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Controllers\Controllers;

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

$postId = $_POST['postId'] ?? null;
$isFeatured = $_POST['isFeatured'] ?? null;

if ($postId === null || $isFeatured === null) {
    http_response_code(400);
    echo json_encode(['message' => 'Bad Request: postId and isFeatured are required']);
    exit;
}

try {
    $controller->setBlogPostFeatured($postId, $isFeatured);
    http_response_code(200);
    echo json_encode(['message' => 'Blog post featured status updated successfully']);
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode(['message' => "Internal Server Error"]);
}
