<?php
require_once __DIR__ . '/vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Templates\HTMLFooter;
use Muswalo\NurseTendiaBlog\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Components\Heading;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Templates\EventCard;
use Muswalo\NurseTendiaBlog\Templates\Event;
use Muswalo\NurseTendiaBlog\Utils\Utils;


$Controller = new Controllers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $head = new HTMLHead(
        "Nurse Tendai's Blog - Upcoming Events",
        "View all upcoming events related to HIV/AIDS awareness and support.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "HIV/AIDS blog, Nurse Tendai, HIV awareness, events, support groups, workshops, webinars",
        "Nurse Tendai",
        Constants::SITE_URL . "/events",
    );
    $head->render();
    ?>
    <script src="js/main.js" defer></script>
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL);
    $sidebar->render();
    ?>

    <div class="lg:ml-64 pt-16 lg:-mt-16">
        <main class="container mx-auto px-4 py-10">

            <?php
            $heading = new Heading("Upcoming Events", "Stay informed about upcoming events related to HIV/AIDS awareness and support.  Join us for workshops, webinars, and community gatherings.");
            $heading->render();

            // Fetch data using the controller
            $data = $Controller->getAllEvents();
            $data = Utils::transformEventData($data);

            $EventCard = new EventCard();
            $events = array_map(function ($item) {
                return new Event(
                    $item['title'],
                    $item['image'],
                    $item['description'],
                    $item['date'],
                    $item['link'],
                    $item['location'],
                );
            }, $data);

            $renderedEvents = $EventCard::renderMultiple($events);
            if (preg_match('/<div class="grid gap-6 md:grid-cols-3">\s*<\/div>/', $renderedEvents)) {
                echo <<<HTML
                <div class="flex flex-col items-center justify-center">
                    <img src="./assets/images/empty.svg" alt="No content available" class="w-64 h-auto mb-4">
                    <p class="text-gray-700 text-center mb-4">No events found yet. Stay tuned for updates.</p>
                    <a href="/" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Go to Home</a>
                </div>
                HTML;
            } else {
                echo $renderedEvents;
            }

            ?>


        </main>

        <?php
        $footer = new HTMLFooter(Constants::SITE_URL);
        $footer->render();
        ?>
    </div>
</body>

</html>