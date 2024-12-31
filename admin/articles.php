<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Admin\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Components\Heading;
use Muswalo\NurseTendiaBlog\Utils\Utils;
use Muswalo\NurseTendiaBlog\Templates\AdminPostCard;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Templates\AdminPost;

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
        "Nurse Tendai's Blog - Admin Articles",
        "Manage your blog posts.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "admin, articles, blog management, HIV/AIDS, Nurse Tendai",
        "Nurse Tendai",
        Constants::SITE_URL . "/admin/articles",
    );
    $head->render();
    ?>
    <script src="../js/main.js" defer></script>
    <script src="js/side-bar.js" defer></script>
    <script src="js/home.js" defer></script>
</head>

<body class="bg-gray-100">
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL, "Tendia Mumba");
    $sidebar->render();
    ?>

    <div class="lg:ml-64 pt-16 lg:-mt-16">
        <main class="container mx-auto p-4">

            <?php

            $Heading = new Heading("Article Content Management", "Control your blog's articles and keep your content fresh. "); 
            $Heading->render();

            $data = $controller->getAllBlogPosts();
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
        </main>
    </div>

</body>

</html>