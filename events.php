<?php
require_once __DIR__ . '/vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Templates\HTMLFooter;
use Muswalo\NurseTendiaBlog\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Components\Heading;

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
        Constants::SITE_URL."/events",
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
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Event 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/600x400" alt="Event Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">HIV Awareness Workshop</h2>
                        <p class="text-gray-700 text-base mb-4">Join us for an informative workshop on HIV awareness and prevention.</p>
                        <p class="text-gray-700 text-base mb-4">Date: December 25, 2024</p>
                        <a href="#" class="text-purple-600 hover:underline">Learn More</a>
                    </div>
                </div>
                <!-- Event 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/600x400" alt="Event Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">Community Support Group Meeting</h2>
                        <p class="text-gray-700 text-base mb-4">A support group meeting for individuals living with HIV.</p>
                        <p class="text-gray-700 text-base mb-4">Date: December 10, 2023</p>
                        <a href="#" class="text-purple-600 hover:underline">Learn More</a>
                    </div>
                </div>
                <!-- Event 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/600x400" alt="Event Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">Webinar on HIV Research</h2>
                        <p class="text-gray-700 text-base mb-4">An online webinar discussing the latest advancements in HIV research.</p>
                        <p class="text-gray-700 text-base mb-4">Date: January 15, 2024</p>
                        <a href="#" class="text-purple-600 hover:underline">Learn More</a>
                    </div>
                </div>
            </div>

        </main>
        
        <?php
        $footer = new HTMLFooter(Constants::SITE_URL);
        $footer->render();
        ?>
    </div>
</body>

</html>