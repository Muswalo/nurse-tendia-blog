<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Admin\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Utils\Utils;
use Muswalo\NurseTendiaBlog\Templates\AdminPostCard;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Templates\AdminPost;
use Muswalo\NurseTendiaBlog\Templates\AdminEvent;
use Muswalo\NurseTendiaBlog\Templates\AdminEventCard;
use Muswalo\NurseTendiaBlog\Controllers\Analytics;

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
        "Nurse Tendai's Blog - Admin Dashboard",
        "Manage your blog posts, events, and other website content.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "admin, dashboard, blog management, HIV/AIDS, Nurse Tendai",
        "Nurse Tendai",
        Constants::SITE_URL . "/admin/home",
    );
    $head->render();
    ?>
    <script src="../js/main.js" defer></script>
    <script src="js/home.js" defer></script>
    <script src="js/side-bar.js" defer></script>

</head>

<body class="bg-gray-100">
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL, "Tendia Mumba");
    $sidebar->render();
    ?>

    <div class="lg:ml-64 pt-16 lg:-mt-16">
        <main class="container mx-auto p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php
                // Create an instance of the Analytics object
                $analytics = new Analytics();
                ?>

                <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Total Visits</h2>
                        <p class="text-4xl font-bold"><?php echo Utils::sanitizeString(Utils::formatNumber($analytics->total_visits())) ?></p>
                    </div>
                    <div class="icon-wrapper bg-blue-100 text-blue-500 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sigma">
                            <path d="M18 7V5a1 1 0 0 0-1-1H6.5a.5.5 0 0 0-.4.8l4.5 6a2 2 0 0 1 0 2.4l-4.5 6a.5.5 0 0 0 .4.8H17a1 1 0 0 0 1-1v-2" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Total Unique Visits</h2>
                        <p class="text-4xl font-bold"><?php echo Utils::sanitizeString(Utils::formatNumber($analytics->total_unique_visits())) ?></p>
                    </div>
                    <div class="icon-wrapper bg-yellow-100 text-yellow-500 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-check-2">
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                            <path d="M3 10h18" />
                            <path d="m16 20 2 2 4-4" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Total Articles</h2>
                        <p class="text-4xl font-bold"><?php echo Utils::sanitizeString(Utils::formatNumber($analytics->total_articles())) ?></p>
                    </div>
                    <div class="icon-wrapper bg-green-100 text-green-500 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-archive">
                            <rect width="20" height="5" x="2" y="3" rx="1" />
                            <path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8" />
                            <path d="M10 12h4" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Total Reads</h2>
                        <p class="text-4xl font-bold"><?php echo Utils::sanitizeString(Utils::formatNumber($analytics->total_reads())) ?></p>
                    </div>
                    <div class="icon-wrapper bg-purple-100 text-purple-500 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-check">
                            <path d="M12 21V7" />
                            <path d="m16 12 2 2 4-4" />
                            <path d="M22 6V4a1 1 0 0 0-1-1h-5a4 4 0 0 0-4 4 4 4 0 0 0-4-4H3a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h6a3 3 0 0 1 3 3 3 3 0 0 1 3-3h6a1 1 0 0 0 1-1v-1.3" />
                        </svg>
                    </div>
                </div>
            </div>
            <section class="my-10">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Articles</h2>
                    <div class="flex justify-end">
                        <a href="/admin/create-post" class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg">
                            Create Article
                        </a>
                    </div>
                </div>
                <!-- Article Cards -->

                <!-- ADMIN POST RENDERING -->
                <?php
                $data = $controller->getFeaturedBlogPosts();
                $data = Utils::transformData($data);

                $AdminPostCard = new AdminPostCard();
                $posts = array_map(function ($item) {
                    return new AdminPost(
                        $item["id"],
                        $item['title'],
                        $item['image'],
                        $item['excerpt'],
                        $item['admin_article_link'],
                        $item['reads'],
                        $item['isFeatured'],
                    );
                }, $data);

                $renderedPosts = $AdminPostCard::renderMultiple($posts);

                if (preg_match('/<div class="grid gap-6 md:grid-cols-3">\s*<\/div>/', $renderedPosts)) {
                    echo <<<HTML
                    <div class="flex flex-col items-center justify-center">
                        <img src="../assets/images/empty.svg" alt="No content available" class="w-64 h-auto mb-4">
                        <p class="text-gray-700 text-center mb-4">You havent added any articles yet</p>
                        <a href="create-post" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Create Article</a>

                    </div>
                    HTML;
                } else {
                    echo $renderedPosts;
                }

                ?>

                <div class="mt-8">
                    <a href="/admin/articles" class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg">
                        View All Articles
                    </a>
                </div>
            </section>

            <!-- Section for events -->

            <section class="mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Events</h2>
                    <div class="flex justify-end">
                        <a href="/admin/create-event" class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg">
                            Create Event
                        </a>
                    </div>
                </div>
                <?php
                $data = $controller->getFeaturedEvents();
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

                <div class="mt-8">
                    <a href="/admin/events" class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg">
                        View All Events
                    </a>
                </div>
            </section>

        </main>
    </div>


</body>

</html>