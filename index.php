<?php
require_once __DIR__ . '/vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Templates\HTMLFooter;
use Muswalo\NurseTendiaBlog\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Templates\PostCard;
use Muswalo\NurseTendiaBlog\Templates\Post;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Templates\EventCard;
use Muswalo\NurseTendiaBlog\Templates\Event;
use Muswalo\NurseTendiaBlog\Templates\VideoCard;
use Muswalo\NurseTendiaBlog\Templates\Video;
use Muswalo\NurseTendiaBlog\Utils\Utils;
use Muswalo\NurseTendiaBlog\Controllers\Monitor;

$Monitor = new Monitor();
$Monitor->monitor();
$Controller = new Controllers();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $head = new HTMLHead(
        "Nurse Tendai's - HIV/AIDS Blog",
        "Join Nurse Tendai as she shares personal stories, research, and resources on HIV/AIDS awareness and support.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "HIV/AIDS blog, Nurse Tendai, HIV awareness, personal stories, HIV resources, healthcare",
        "Nurse Tendai",
        Constants::SITE_URL,
    );
    $head->render();
    ?>
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js" defer></script>
    <script src="js/newsletter.js" defer></script>
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL);
    $sidebar->render();
    ?>

    <div class="lg:ml-64 pt-16 lg:-mt-16" id="main-content">
        <!-- Hero Section -->
        <section class="relative">
            <div class="absolute inset-0">
                <img src="./assets/images/ribon.jpeg" alt="Background Image"
                    class="w-full h-full object-cover">
            </div>
            <div class="relative container mx-auto px-4 py-20 text-left">
                <h1 class="text-white text-4xl font-bold">Nurse Tendia's HIV/AIDS Awareness Blog</h1>
                <div class="absolute bottom-4 left-4">
                    <a href="/about#about"
                        class="bg-white text-purple-600 font-semibold py-2 px-4 rounded hover:bg-purple-200 flex">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-arrow-up-right">
                            <path d="M7 7h10v10" />
                            <path d="M7 17 17 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section class="container mx-auto px-4 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="w-full md:w-1/2 mb-6 md:mb-0 ml-2">
                    <h2 class="text-2xl text-gray-800 font-bold mb-4 font-extrabold">
                        Welcome to <strong class="text-purple-700" itemprop="author">Nurse Tendia</strong>'s HIV/AIDS
                        Awareness Blog
                    </h2>
                    <p class="text-gray-700 text-lg text-gray-800 ">
                        This blog is dedicated to providing accurate information, personal stories, and the latest
                        research findings on HIV and AIDS. We aim to educate, support, and empower individuals affected
                        by these conditions.
                    </p>
                    <a href="/blog"
                        class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 inline-flex mt-4  items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-3 h-3 mr-2 fill-current">
                            <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
                        </svg>
                        Read Our Blog
                    </a>
                </div>
                <div class="w-full md:w-1/2">
                    <img src="./assets/images/womanholdingribbon.webp" alt="Blog Image"
                        class="w-full h-auto rounded-lg shadow-md">
                </div>
            </div>
        </section>

        <section class="container mx-auto px-4 py-10">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Featured Articles</h2>

            <?php

            // Fetch data using the controller
            $data = $Controller->getFeaturedBlogPosts();
            $data = Utils::transformData($data);

            $PostCard = new PostCard();
            $posts = array_map(function ($item) {
                return new Post(
                    $item['title'],
                    $item['image'],
                    $item['excerpt'],
                    $item['author'],
                    $item['date'],
                    $item['id'],
                    $item['link'],
                );
            }, $data);

            $renderedPosts = $PostCard::renderMultiple($posts);
            if (preg_match('/<div class="grid gap-6 md:grid-cols-3">\s*<\/div>/', $renderedPosts)) {
                echo <<<HTML
                <div class="flex flex-col items-center justify-center">
                    <img src="./assets/images/empty.svg" alt="No content available" class="w-64 h-auto mb-4">
                    <p class="text-gray-700 text-center mb-4">No blog posts found yet. Stay tuned for updates.</p>
                </div>
                HTML;
            } else {
                echo $renderedPosts;
            }

            ?>

            <div class="mt-10 text-center">
                <a href="/blog"
                    class="inline-flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors shadow-lg hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                    </svg>

                    View All Articles
                </a>
            </div>

        </section>

        <section class="container mx-auto px-4 py-10">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Living Voices HIV/AIDS Journeys</h2>

            <?php
            $VideoCard = new VideoCard();

            $data = $Controller->getAllVideos();
            $data = Utils::transformData($data);

            $videos = array_map(function ($item) {
                return new Video(
                    $item['title'],
                    $item['thumbnail'],
                    $item['altText'],
                    $item['description'],
                    $item['duration'],
                    $item['videoSrc'],
                );
            }, $data);

            $renderedVideos = VideoCard::renderMultiple($videos);
            if (preg_match('/<div class="grid gap-6 md:grid-cols-3">\s*<\/div>/', $renderedVideos)) {
                echo <<<HTML
                <div class="flex flex-col items-center justify-center">
                    <img src="./assets/images/empty.svg" alt="No content available" class="w-64 h-auto mb-4">
                    <p class="text-gray-700 text-center mb-4">No Video Stories yet. Stay tuned for updates.</p>
                </div>
                HTML;
            } else {
                echo $renderedVideos;
            }
            ?>
            <div class="mt-10 text-center">
                <a href="/stories"
                    class="inline-flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    View All Stories
                </a>
            </div>

        </section>

        <section class="container mx-auto px-4 py-10">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-8">My Notable Work</h2>

            <p class="text-gray-700 text-lg mb-6">Here are some of my notable works in the field of HIV/AIDS awareness
                and research. Click on a project to learn more!</p>

            <div class="grid gap-6 md:grid-cols-3">

                <!-- Project 1 -->
                <div class="relative group cursor-pointer rounded-lg ">
                    <img src="./assets/images/project1.webp" alt="Project Image 1"
                        class="w-full h-72 object-cover transition-transform duration-300 group-hover:scale-105">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <h3 class="text-white text-2xl font-semibold mb-2">Article Published in Major Newspaper</h3>
                        <p class="text-white text-center text-sm px-4">An article I wrote on HIV/AIDS research was published in a major newspaper, raising awareness and highlighting key advancements.</p>
                    </div>
                </div>
                <!-- Project 2 -->
                <div class="relative group cursor-pointer rounded-lg ">
                    <img src="./assets/images/project2.webp" alt="Project Image 2"
                        class="w-full h-72 object-cover transition-transform duration-300 group-hover:scale-105">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <h3 class="text-white text-2xl font-semibold mb-2">Our Future: The Economic Power</h3>
                        <p class="text-white text-center text-sm px-4">Worked with fellow nurses to spread awareness about HIV/AIDS.</p>
                    </div>
                </div> <!-- Project 3 -->
                <div class="relative group cursor-pointer rounded-lg ">
                    <img src="./assets/images/womanholdingribbon.webp" alt="Project Image 3"
                        class="w-full h-72 object-cover transition-transform duration-300 group-hover:scale-105">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <h3 class="text-white text-2xl font-semibold mb-2">Awesome achievement by miss tendia</h3>
                        <p class="text-gray-300 text-center text-sm px-4">Description of project 3 This will be another thing she has achieved so far</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="container mx-auto px-4 py-10">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Upcoming Events</h2>

            <?php

            // Fetch data using the controller
            $data = $Controller->getFeaturedEvents();
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
                </div>
                HTML;
            } else {
                echo $renderedEvents;
            }
            ?>
            <div class="mt-8">

                <div class="mt-10 text-center">
                    <a href="/events"
                        class="inline-flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors shadow-lg hover:shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>

                        View All Events
                    </a>
                </div>

            </div>

        </section>
        <section class="bg-gradient-to-r from-purple-50 to-purple-100 py-14">
            <div class="container mx-auto px-6 md:px-12 lg:px-20">
                <h2 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">About the Blog Owner</h2>
                <div class="flex flex-col md:flex-row items-center bg-white shadow-lg rounded-lg p-6 md:p-10 gap-6">
                    <img src="./assets/images/nursetendia.webp" alt="Dr. Emily Thompson"
                        class="w-32 h-32 rounded-full border-4 border-purple-500">
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl font-bold text-purple-600 mb-2">Nurse Thandaza Tendai</h3>
                        <p class="text-gray-700 text-lg leading-relaxed mb-4">
                            Tendai Mumba BSC, registered HIV nurse practitioner, renowned advocate, and HIV/NURSE leader. I started this blog to share accurate information, personal stories, and the latest findings about HIV/AIDS...
                            <a href="/about#me" class="text-purple-600 font-medium hover:underline">Read more</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <div id="newsletter-popup" class="hidden fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
                <button type="button" id="close-popup" class="absolute top-2 right-2 bg-gray-200 rounded-full p-1 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <form id="newsLetter-form">
                    <h3 class="text-xl font-semibold mb-4">Stay Updated with Nurse Tendai</h3>
                    <p class="text-gray-700 mb-4">Subscribe to receive email notifications whenever a new article is published.</p>
                    <input type="text" name="name" placeholder="Enter your name" class="w-full p-2 border rounded mb-2" id="newsLetter-name">
                    <input type="email" name="email" placeholder="Enter your email" class="w-full p-2 border rounded mb-2" id="newsLetter-email">
                    <button type="submit" class="bg-purple-600 text-white p-2 rounded w-full" id="newsLetter-submit">Subscribe</button>
                </form>
            </div>
        </div>
        <?php
        $footer = new HTMLFooter(Constants::SITE_URL);
        $footer->render();
        ?>
    </div>


</body>
<script>
    function showPopup() {
        const popup = document.getElementById('newsletter-popup');
        popup.classList.remove('hidden');
        document.cookie = "popupShown=true; path=/";
    }


    window.addEventListener('scroll', () => {
        if (document.cookie.indexOf('popupShown=true') === -1 && window.scrollY > 500) {
            showPopup();
        }
    });

    document.getElementById('close-popup').addEventListener('click', () => {
        document.getElementById('newsletter-popup').classList.add('hidden');
    });

    // Video Modal Functionality
    const videoModal = document.getElementById('video-modal');
    const modalVideo = document.getElementById('modal-video');
    const videoTitle = document.getElementById('video-title');
    const videoDescription = document.getElementById('video-description');

    document.querySelectorAll('.play-button').forEach(button => {

        button.addEventListener('click', (e) => {
            const card = e.target.closest('.group');
            const videoSrc = card.dataset.videoSrc;
            const title = card.querySelector('h3').textContent;
            const description = card.querySelector('p').textContent;

            modalVideo.src = videoSrc;
            videoTitle.textContent = title;
            videoDescription.textContent = description;

            videoModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            modalVideo.play();
        });

    });

    document.getElementById('close-modal').addEventListener('click', () => {
        videoModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        modalVideo.pause();
    });

    videoModal.addEventListener('click', (e) => {
        if (e.target === videoModal) {
            videoModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            modalVideo.pause();
        }
    });
</script>

</html>