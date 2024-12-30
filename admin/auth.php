<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Controllers\Controllers;
$controller = new Controllers();

session_start();

header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

try {
    $user = $controller->getUserByUsername($username);

    if (!$user) {
        http_response_code(404);
        echo json_encode(["message" => "Invalid username or password"]);
        exit();
    }

    $password_hash = $user['password'];

    if (!password_verify($password, $password_hash)) {
        http_response_code(403);
        echo json_encode(["message" => "Invalid username or password"]);
        exit();
    }

    session_regenerate_id();

    $_SESSION["user_id"] = $user["id"];
    $_SESSION["is_loged_in"] = true;


    http_response_code(200);
    echo json_encode(["message" => "Login successful"]);
    exit();
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode(["message" => "Internal server error"]);
    exit();
}
