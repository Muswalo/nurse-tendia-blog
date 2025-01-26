<?php

require_once __DIR__ . '/vendor/autoload.php';
use Muswalo\NurseTendiaBlog\Utils\Utils;
use Muswalo\NurseTendiaBlog\Database\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

Database::connect();

$name = Utils::sanitizeString($_POST["name"] ?? "");
$email = Utils::sanitizeString($_POST["email"] ?? "");
$message = Utils::sanitizeString($_POST["message"] ?? "");

if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['error' => 'Please fill out all fields.']);
    exit();
}

$to = $_SERVER['EMAIL'];
$subject = "New Message from Contact Form";
$body = generateHtmlMessage($name, $email, $message);

$options = [
    'isHTML' => true,
];

if (sendEmail($to, $subject, $body, $options)) {
    http_response_code(200);
    echo json_encode(['message' => 'Message sent successfully']); 
    exit();
} else {
    http_response_code(500); 
    echo json_encode(['error' => 'Message could not be sent.']);
    exit();
}

/**
 * Sends an email using PHPMailer.
 *
 * @param string $to
 * @param string $subject
 * @param string $body
 * @param array $options
 * @return bool
 */
function sendEmail($to, $subject, $body, $options = [])
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $_SERVER['EMAIL'];
        $mail->Password   = $_SERVER['PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('me@nursetendia.com', "Nurse Tendia");
        $mail->addAddress($to);

        // Attachments
        if (isset($options['attachments'])) {
            foreach ($options['attachments'] as $attachment) {
                $mail->addAttachment($attachment);
            }
        }

        // Content
        $mail->isHTML($options['isHTML'] ?? false);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Generates an HTML email message.
 *
 * @param string $name
 * @param string $email
 * @param string $message
 * @return string
 */
function generateHtmlMessage($name, $email, $message)
{
    return "
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>New Contact Form Submission</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f9;
                    margin: 0;
                    padding: 0;
                    color: #333;
                }
                .container {
                    max-width: 600px;
                    margin: 40px auto;
                    background-color: #ffffff;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                    border: 1px solid #eaeaea;
                }
                .header {
                    background-color: #007BFF;
                    color: #ffffff;
                    text-align: center;
                    padding: 20px 10px;
                }
                .header h1 {
                    margin: 0;
                    font-size: 22px;
                }
                .content {
                    padding: 20px 30px;
                    line-height: 1.6;
                }
                .content p {
                    margin: 10px 0;
                    font-size: 16px;
                }
                .content strong {
                    color: #007BFF;
                }
                .footer {
                    text-align: center;
                    padding: 15px;
                    background-color: #f9f9f9;
                    font-size: 14px;
                    color: #666;
                }
                @media (max-width: 600px) {
                    .container {
                        padding: 10px;
                    }
                    .content {
                        padding: 15px;
                    }
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>New Contact Form Submission</h1>
                </div>
                <div class='content'>
                    <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
                    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                    <p><strong>Message:</strong></p>
                    <p>" . nl2br(htmlspecialchars($message)) . "</p>
                </div>
                <div class='footer'>
                    <p>This email was automatically generated by your website's contact form.</p>
                </div>
            </div>
        </body>
        </html>
    ";
}
