<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Constants\Constants;

session_start();

// Set the response content type to JSON
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
    exit;
}

// Check if the user is logged in
if (!isset($_SESSION['is_loged_in']) || $_SESSION['is_loged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized']);
    exit;
}

// Retrieve POST data and files
$title        = trim($_POST['title'] ?? '');
$description  = trim($_POST['description'] ?? '');
$featured     = $_POST['featured'] ?? 0;
$duration     = $_POST['duration'] ?? 0;
$videoFile    = $_FILES['videoFile'] ?? null;
$thumbnailFile = $_FILES['thumbnail'] ?? null;

// Directories for uploads
$uploadDir    = __DIR__ . '/../uploads/videos/';
$thumbnailDir = __DIR__ . '/../uploads/thumbnails/';

try {
    // Validate required fields
    if (empty($title) || empty($description)) {
        http_response_code(400);
        echo json_encode(['message' => 'Missing required fields: title or description']);
        exit;
    }

    if (!$videoFile || $videoFile['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['message' => 'Missing or invalid video file']);
        exit;
    }

    if (!$thumbnailFile || $thumbnailFile['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['message' => 'Missing or invalid thumbnail file']);
        exit;
    }

    // Create upload directories if they don't exist
    foreach ([$uploadDir, $thumbnailDir] as $dir) {
        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }
    }

    // Validate video file type
    $videoFileType = strtolower(pathinfo($videoFile['name'], PATHINFO_EXTENSION));
    $allowedTypes = ['mp4', 'mov', 'avi'];

    if (!in_array($videoFileType, $allowedTypes, true)) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid video type. Allowed types: mp4, mov, avi']);
        exit;
    }

    // Generate a unique ID for the filenames
    $uniqueId = uniqid();

    // Set the filenames and paths for video and thumbnail
    $videoFileName     = $uniqueId . '.' . $videoFileType;
    $videoPath         = $uploadDir . $videoFileName;
    $thumbnailFileName = $uniqueId . '.jpg';
    $thumbnailPath     = $thumbnailDir . $thumbnailFileName;

    // Move the uploaded video file to the destination
    if (!move_uploaded_file($videoFile['tmp_name'], $videoPath)) {
        throw new RuntimeException('Failed to move uploaded video file');
    }

    // Move the uploaded thumbnail file to the destination
    if (!move_uploaded_file($thumbnailFile['tmp_name'], $thumbnailPath)) {
        throw new RuntimeException('Failed to move uploaded thumbnail file');
    }

    // Prepare the video data for the database entry
    $videoData = [
        'title'       => $title,
        'description' => $description,
        'duration'    => (int) round($duration),
        'thumbnail'   => Constants::SITE_URL . '/uploads/thumbnails/' . $thumbnailFileName,
        'video_file'  => Constants::SITE_URL . '/uploads/videos/' . $videoFileName,
        'featured'    => $featured ? 1 : 0,
    ];

    // Create the video entry using your controller
    $controller = new Controllers();
    $id = $controller->createVideo(
        $videoData['title'],
        $videoData['thumbnail'],
        $videoData['description'],
        $videoData['duration'],
        $videoData['video_file'],
        $videoData['featured']
    );

    http_response_code(201);
    echo json_encode([
        'message' => 'Video story created successfully',
        'data' => [
            'id'              => $id,
            'video_path'      => $videoData['video_file'],
            'thumbnail_path'  => $videoData['thumbnail'],
            'duration'        => $videoData['duration']
        ]
    ]);
} catch (Exception $e) {
    error_log("Video upload error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['message' => 'Failed to process video upload: ' . $e->getMessage()]);
}
