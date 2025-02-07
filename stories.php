<?php
require_once __DIR__ . '/vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Templates\HTMLFooter;
use Muswalo\NurseTendiaBlog\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Components\Heading;
use Muswalo\NurseTendiaBlog\Templates\VideoCard;
use Muswalo\NurseTendiaBlog\Templates\Video;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;
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
    <script src="js/stories.js" defer></script>
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL);
    $sidebar->render();
    ?>

    <div class="lg:ml-64 pt-16 lg:-mt-16">
        <main class="container mx-auto px-4 py-10" id="main-content">

            <?php
            $heading = new Heading("Living Voices, HIV/AIDS Journeys", "Hear personal stories of strength, resilience, and hope from individuals living with HIV/AIDS.");
            $heading->render();

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

        </main>
        <?php
        $footer = new HTMLFooter(Constants::SITE_URL);
        $footer->render();
        ?>
    </div>
</body>

</html>