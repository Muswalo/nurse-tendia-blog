<?php 
require_once __DIR__ . "/../vendor/autoload.php";
use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Templates\HTMLFooter;
use Muswalo\NurseTendiaBlog\Constants\Constants;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $head = new HTMLHead(
        "404 Page Not Found",
        "Sorry, the page you are looking for could not be found.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "HIV, AIDS, Nurse Tendai",
        "Nurse Tendai"
    );
    $head->render();
    ?>
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col items-center justify-center min-h-screen">
    <div class="text-center p-4">
        <h1 class="text-6xl font-bold mb-4">404</h1>
        <p class="text-xl mb-8">Sorry, the page you are looking for could not be found.</p>
        <a href="/" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Go to Home</a>
    </div>

    <?php 
    
    $footer = new HTMLFooter(Constants::SITE_URL);
    $footer->render();
    
    ?>
</body>
</html>