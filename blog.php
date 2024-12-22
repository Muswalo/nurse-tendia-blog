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
        "Nurse Tendai's Blog - HIV/AIDS Awareness",
        "Read Nurse Tendai's latest articles on HIV/AIDS awareness, personal stories, and research.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "HIV/AIDS blog, Nurse Tendai, HIV awareness, personal stories, HIV resources, healthcare, blog posts",
        "Nurse Tendai",
        Constants::SITE_URL."/blog",
    );
    $head->render();
    ?>
    <script src="js/main.js" defer></script>
    </script>
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
            $heading = new Heading("My Latest Blog Posts and Insights", "Stay up-to-date with the latest news, research, and personal stories on HIV/AIDS. Learn about the latest advancements in treatment, prevention, and living positively with HIV.");
            $heading->render();
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Blog Post 1 -->
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/600x400" alt="Blog Post Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">Understanding HIV Transmission</h2>
                        <p class="text-gray-700 text-base mb-4">Learn about the ways HIV can be transmitted and how to prevent it.</p>
                        <a href="#" class="text-purple-600 hover:underline">Read More</a>
                    </div>
                </article>
                <!-- Blog Post 2 -->
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/600x400" alt="Blog Post Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">Latest Advancements in AIDS Research</h2>
                        <p class="text-gray-700 text-base mb-4">Explore the most recent breakthroughs in AIDS research and treatment.</p>
                        <a href="#" class="text-purple-600 hover:underline">Read More</a>
                    </div>
                </article>
                <!-- Blog Post 3 -->
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/600x400" alt="Blog Post Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">Living Positively with HIV</h2>
                        <p class="text-gray-700 text-base mb-4">Personal stories and advice on living a fulfilling life with HIV.</p>
                        <a href="#" class="text-purple-600 hover:underline">Read More</a>
                    </div>
                </article>

                <!-- Blog Post 4   -->
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/600x400" alt="Blog Post Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">Understanding HIV Transmission</h2>
                        <p class="text-gray-700 text-base mb-4">Learn about the ways HIV can be transmitted and how to prevent it.</p>
                        <a href="#" class="text-purple-600 hover:underline">Read More</a>
                    </div>
                </article>

                <!-- Blog Post 5 -->
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/600x400" alt="Blog Post Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">Latest Advancements in AIDS Research</h2>
                        <p class="text-gray-700 text-base mb-4">Explore the most recent breakthroughs in AIDS research and treatment.</p>
                        <a href="#" class="text-purple-600 hover:underline">Read More</a>
                    </div>
                </article>

                <!-- Blog Post 6 -->
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/600x400" alt="Blog Post Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">Living Positively with HIV</h2>
                        <p class="text-gray-700 text-base mb-4">Personal stories and advice on living a fulfilling life with HIV.</p>
                        <a href="#" class="text-purple-600 hover:underline">Read More</a>
                    </div>
                </article>
            </div>

        </main>
        <?php
        $footer = new HTMLFooter(Constants::SITE_URL);
        $footer->render();
        ?>
    </div>
</body>

</html>