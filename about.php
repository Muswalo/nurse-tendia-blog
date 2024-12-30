<?php
require_once __DIR__ . '/vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Templates\HTMLFooter;
use Muswalo\NurseTendiaBlog\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Components\Heading;
use Muswalo\NurseTendiaBlog\Controllers\Monitor;

$Monitor = new Monitor();
$Monitor->monitor();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $head = new HTMLHead(
        "About Nurse Tendai's Blog",
        "Learn more about Nurse Tendai and her mission to raise HIV/AIDS awareness.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "About, Nurse Tendai, HIV/AIDS, Blog, Awareness",
        "Nurse Tendai",
        Constants::SITE_URL."/about",
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
            <!-- Hero Section -->
             <?php
             $heading = new Heading ("About Nurse Tendai's Blog", "Empowering lives through education, awareness, and support for individuals affected by HIV and AIDS.");
             $heading->render();
             ?>

            <!-- Meet Nurse Tendai -->
            <section class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center" id="me">
                <div>
                    <img src="./assets/images/nurse-tendia-highres.JPG" alt="Nurse Tendai" class="w-full rounded-lg shadow-lg">
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scan-heart text-purple-600 mr-2">
                            <path d="M11.246 16.657a1 1 0 0 0 1.508 0l3.57-4.101A2.75 2.75 0 1 0 12 9.168a2.75 2.75 0 1 0-4.324 3.388z" />
                            <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                            <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                            <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                            <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                        </svg> Meet Nurse Tendai
                    </h2>
                    <p class="text-gray-700 text-lg mb-4">
                        <strong>Tendai Mumba</strong>, a registered HIV nurse practitioner, is a passionate advocate for HIV/AIDS awareness. Driven by a commitment to education and support, she created this blog to share accurate information, personal stories, and the latest research findings on HIV and AIDS.
                    </p>
                    <p class="text-gray-700 text-lg">
                        A graduate of the <strong>University of Zambia</strong>, she has over 5 years of experience in the healthcare field. Nurse Tendai is a member of the International Association of Providers of AIDS Care and the Association of Nurses in AIDS Care.
                    </p>
                </div>
            </section>

            <!-- About the Blog -->
            <section class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-purple-50 p-8 rounded-lg shadow-lg" id="about">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="48" height="48" class="mr-2 fill-current text-purple-600">
                            <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M192 32c0 17.7 14.3 32 32 32c123.7 0 224 100.3 224 224c0 17.7 14.3 32 32 32s32-14.3 32-32C512 128.9 383.1 0 224 0c-17.7 0-32 14.3-32 32zm0 96c0 17.7 14.3 32 32 32c70.7 0 128 57.3 128 128c0 17.7 14.3 32 32 32s32-14.3 32-32c0-106-86-192-192-192c-17.7 0-32 14.3-32 32zM96 144c0-26.5-21.5-48-48-48S0 117.5 0 144L0 368c0 79.5 64.5 144 144 144s144-64.5 144-144s-64.5-144-144-144l-16 0 0 96 16 0c26.5 0 48 21.5 48 48s-21.5 48-48 48s-48-21.5-48-48l0-224z" />
                        </svg>
                        About This Blog
                    </h2>
                    <p class="text-gray-700 text-lg mb-4">
                        Nurse Tendai's blog is a valuable resource for anyone seeking accurate information, personal stories, and the latest research on HIV and AIDS. Explore articles on topics ranging from HIV transmission to the latest treatment and prevention advancements.
                    </p>
                    <p class="text-gray-700 text-lg">
                        This blog is committed to providing a supportive space for education and open discussion. Join the conversation and help make a difference in the fight against HIV/AIDS.
                    </p>
                </div>
                <div>
                    <img src="./assets/images/purple.png" alt="About Image" class="w-full rounded-lg shadow-lg">
                </div>
            </section>

            <!-- Call to Action -->

            <section class="mt-12 text-center">
                <a href="/blog" class="bg-purple-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-purple-700 transition flex items-center justify-center mx-auto" style="max-width: 200px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 mr-2 fill-current">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
                    </svg>
                    Explore the Blog
                </a>
            </section>
        </main>

        <!-- Footer -->
        <?php
        $footer = new HTMLFooter(Constants::SITE_URL);
        $footer->render();
        ?>
    </div>
</body>

</html>