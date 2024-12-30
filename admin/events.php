<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Admin\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Components\Heading;
use Muswalo\NurseTendiaBlog\Utils\Utils;
use Muswalo\NurseTendiaBlog\Templates\AdminEventCard;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Templates\AdminEvent;

if (!Utils::isAuthenticated()) {
    header("Location: index");
    exit();
}

$controller = new Controllers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $head = new HTMLHead(
        "Nurse Tendai's Blog - Admin Events",
        "Manage your  Events.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "admin, Events, blog management, HIV/AIDS, Nurse Tendai",
        "Nurse Tendai",
        Constants::SITE_URL . "/admin/events",
    );
    $head->render();
    ?>
    <script src="../js/main.js" defer></script>
    <script src="js/articles.js" defer></script>
    <script src="js/side-bar.js" defer></script>
</head>

<body class="bg-gray-100">
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL, "Tendia Mumba");
    $sidebar->render();
    ?>

    <div class="lg:ml-64 pt-16 lg:-mt-16">
        <main class="container mx-auto p-4">

            <?php

            $Heading = new Heading("Event Content Management", "Manage and update event details to keep your audience informed and engaged.");
            $Heading->render();

            $data = $controller->getAllEvents();
            $data = Utils::transformData($data);

            $AdminEventCard = new AdminEventCard();

            $posts = array_map(function ($item) {
                return new AdminEvent(
                    $item['id'],
                    $item['title'],
                    $item['image'],
                    $item['description'],
                    $item['link'],
                    $item['isFeatured'],
                );
            }, $data);

            $renderedPosts = $AdminEventCard->renderMultiple($posts);


            if (preg_match('/<div class="grid gap-6 md:grid-cols-3">\s*<\/div>/', $renderedPosts)) {
                echo <<<HTML
                    <div class="flex flex-col items-center justify-center">
                        <img src="../assets/images/empty.svg" alt="No content available" class="w-64 h-auto mb-4">
                        <p class="text-gray-700 text-center mb-4">You havent added any events yet</p>
                        <a href="create-event" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Create Event</a>

                    </div>
                    HTML;
            } else {
                echo $renderedPosts;
            }
            ?>
        </main>
    </div>

</body>

</html>