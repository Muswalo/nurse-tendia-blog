<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Constants\Constants;

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
$title = $_POST['title'];
$description = $_POST['description'];
$date = $_POST['date'];
$location = $_POST['location'];
$featured = $_POST['featured'];
$image = $_FILES['image'] ?? NULL;

$uploadDir = __DIR__ . '/../uploads/';
$targetWidth = 1200;
$targetHeight = 630;

try {
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowedTypes)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid image type. Allowed types: jpg, jpeg, png, gif']);
            exit;
        }

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $uploadDir));
        }

        $originalImage = null;
        if ($imageFileType === 'jpg' || $imageFileType === 'jpeg') {
            $originalImage = imagecreatefromjpeg($image['tmp_name']);
        } elseif ($imageFileType === 'png') {
            $originalImage = imagecreatefrompng($image['tmp_name']);
        } elseif ($imageFileType === 'gif') {
            $originalImage = imagecreatefromgif($image['tmp_name']);
        }        if (!$originalImage) {
            http_response_code(500);
            echo json_encode(['message' => 'Error creating image from upload']);
            exit;
        }

        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);
        $originalAspectRatio = $originalWidth / $originalHeight;
        $targetAspectRatio = $targetWidth / $targetHeight;

        $srcX = 0;
        $srcY = 0;
        $srcWidth = $originalWidth;
        $srcHeight = $originalHeight;

        if ($originalAspectRatio > $targetAspectRatio) {
            $srcWidth = $originalHeight * $targetAspectRatio;
            $srcX = ($originalWidth - $srcWidth) / 2;
        } else {
            $srcHeight = $originalWidth / $targetAspectRatio;
            $srcY = ($originalHeight - $srcHeight) / 2;
        }


        $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

        imagecopyresampled($resizedImage, $originalImage, 0, 0, $srcX, $srcY, $targetWidth, $targetHeight, $srcWidth, $srcHeight);
        $newImageName = uniqid() . '.' . $imageFileType;
        $imagePath = $uploadDir . $newImageName;

        if ($imageFileType === 'jpg' || $imageFileType === 'jpeg') {
            imagejpeg($resizedImage, $imagePath, 90);
        } elseif ($imageFileType === 'png') {
            imagepng($resizedImage, $imagePath);
        } elseif ($imageFileType === 'gif') {
            imagegif($resizedImage, $imagePath);
        }



        imagedestroy($originalImage);
        imagedestroy($resizedImage);

        $controller->updateEvent($id, $title, $description, $date, $location, $featured, Constants::SITE_URL . "/uploads/" . $newImageName);

        http_response_code(201);
        echo json_encode(['message' => 'Event Updated successfully', 'image_path' => $newImageName]);
        exit;
    } else {

        $controller->updateEvent($id, $title, $description, $date, $location, $featured, null);
        http_response_code(201);
        echo json_encode(['message' => 'Event Updated successfully', 'image_path' => null]);
        exit;
    }
} catch (\Throwable $th) {
    http_response_code(500);
    var_dump($th->getMessage());
    echo json_encode(['message' => "Internal Server Error"]);
}

