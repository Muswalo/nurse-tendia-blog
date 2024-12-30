<?php
require_once __DIR__ . '/vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Templates\HTMLFooter;
use Muswalo\NurseTendiaBlog\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Components\Heading;
use Muswalo\NurseTendiaBlog\Templates\PostCard;
use Muswalo\NurseTendiaBlog\Templates\Post;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Utils\Utils;

$Controller = new Controllers();

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
        Constants::SITE_URL . "/blog",
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

            // Fetch data using the controller
            $data = $Controller->getAllBlogPosts();
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
                    $item['link']
                );
            }, $data);
            $renderedPosts = $PostCard::renderMultiple($posts);
            if (preg_match('/<div class="grid gap-6 md:grid-cols-3">\s*<\/div>/', $renderedPosts)) {
                echo <<<HTML
                <div class="flex flex-col items-center justify-center">
                    <img src="./assets/images/empty.svg" alt="No content available" class="w-64 h-auto mb-4">
                    <p class="text-gray-700 text-center mb-4">No blog posts found yet. Stay tuned for updates.</p>
                    <a href="/" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Go to Home</a>
                </div>
                HTML;
            } else {
                echo $renderedPosts;
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