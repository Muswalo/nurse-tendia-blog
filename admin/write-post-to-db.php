<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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

$title = $_POST['title'];
$author = $_POST['author'];
$content = $_POST['content'];
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
        }


        if (!$originalImage) {
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

        $id = $controller->createBlogPost($title, $content, $author, $_SESSION['user_id'], $featured, Constants::SITE_URL . "\n/uploads\n/" . $newImageName);

        http_response_code(201);
        echo json_encode(['message' => 'Post created successfully', 'image_path' => $newImageName]);
    } else {
        $id = $controller->createBlogPost($title, $content, $author, $_SESSION['user_id'], $featured);
        http_response_code(201);
        echo json_encode(['message' => 'Post created successfully', 'image_path' => null]);
    }

    $emails = $controller->getAllSubscribedNamesAndEmails();
    $mail = new PHPMailer(true);


    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_SERVER['H_EMAIL'];
    $mail->Password   = $_SERVER['H_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->setFrom('me@nursetendai.com', 'Nurse Tendia');
    $mail->Helo = 'nursetendai.com';

    // Email content
    $subject = "New Article Published: $title";
    foreach ($emails as $subscriber) {
        $name = $subscriber['name'];
        $email = $subscriber['email'];

        $truncatedContent = strlen($content) > 200 ? substr($content, 0, 200) . '...' : $content;
        $body = generateNewsletterEmail(
            $name,
            $email,
            $title,
            $truncatedContent,
            Constants::SITE_URL . "/view?id={$id}",
            Constants::SITE_URL . "\n/uploads\n/" . $newImageName,
        );

        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->send();
        $mail->clearAddresses();
    }

    exit();
} catch (Exception $e) {
    error_log("Bulk email error: {$mail->ErrorInfo}");
    echo json_encode(['message' => 'Failed to send emails']);
}


/**
 * Generates the HTML email for the newsletter.
 */
function generateNewsletterEmail($name, $email, $title, $content, $articleUrl, $imageUrl = null)
{
    return "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>$title</title>
            <style>
                body {
                    font-family: 'Roboto', Arial, sans-serif;
                    background-color: #f9fafb;
                    margin: 0;
                    padding: 0;
                    color: #333;
                }
                .container {
                    max-width: 600px;
                    margin: 40px auto;
                    background: #ffffff;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    border: 1px solid #e0e0e0;
                }
                .header {
                    background-color: #4F46E5;
                    color: #ffffff;
                    text-align: center;
                    padding: 30px;
                }
                .header h1 {
                    font-size: 24px;
                    margin: 0;
                    font-weight: 700;
                }
                .content {
                    padding: 20px 30px;
                }
                .content p {
                    margin: 15px 0;
                    font-size: 16px;
                    line-height: 1.6;
                    color: #555;
                }
                .content img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 12px;
                    margin-bottom: 20px;
                }
                .cta-button {
                    display: inline-block;
                    margin: 20px 0;
                    padding: 12px 24px;
                    background-color: #4F46E5;
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 8px;
                    font-size: 16px;
                    font-weight: 600;
                    text-align: center;
                }
                .cta-button:hover {
                    background-color: #3730A3;
                }
                .footer {
                    text-align: center;
                    padding: 20px;
                    font-size: 14px;
                    background: #f3f4f6;
                    color: #777;
                }
                .footer a {
                    color: #4F46E5;
                    text-decoration: none;
                    font-weight: 500;
                }
                .footer a:hover {
                    text-decoration: underline;
                }
                .unsubscribe {
                    color: #EF4444;
                    text-decoration: none;
                }
                .unsubscribe:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>$title</h1>
                </div>
                <div class='content'>
                    " . ($imageUrl ? "<img src='$imageUrl' alt='Article Image'>" : "") . "
                    <strong><p>Hi $name,</p></strong>
                    <p>$content</p>
                    <a href='$articleUrl' class='cta-button'>Read the Article</a>
                </div>
                <div class='footer'>
                    <p>You are receiving this email because you subscribed to our newsletter.</p>
                    <p><a href='" . Constants::SITE_URL . "/unsubscribe?email=$email' class='unsubscribe'>Unsubscribe</a> | <a href='" . Constants::SITE_URL . "'>Visit our website</a></p>
                </div>
            </div>
        </body>
        </html>
    ";
}
