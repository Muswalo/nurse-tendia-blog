<?php
require_once __DIR__ . '/vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Templates\HtmlFooter;
use Muswalo\NurseTendiaBlog\Controllers\Monitor;

$Monitor = new Monitor();
$Monitor->monitor();

$controller = new Controllers();
$eventId = $_GET['id'] ?? null;

if (!$eventId) {
    header("Location: /events");
    exit();
}

$event = $controller->getEvent($eventId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    http_response_code(404);
    $title = "Event Not Found";
    $description = "The requested event was not found.";
    $imageUrl = Constants::DEFAULT_IMAGE;
    $canonicalUrl = Constants::SITE_URL . "/events";

    if ($event) {
        $title = htmlspecialchars($event['title']);
        $description = htmlspecialchars(substr($event['description'], 0, 150));
        $imageUrl = $event['image_url'] ?? Constants::DEFAULT_IMAGE;
        $canonicalUrl = Constants::SITE_URL . "/view_event.php?id=" . $eventId;
    }

    $head = new HTMLHead(
        $title,
        $description,
        $imageUrl,
        $canonicalUrl,
        Constants::THEME_COLOR,
        "event, HIV/AIDS, Nurse Tendai",
        "Nurse Tendai",
        $canonicalUrl
    );

    $head->render();
    ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="js/main.js"></script>
</head>

<body class="bg-gray-100">
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL);
    $sidebar->render();
    ?>
    <div class="lg:ml-64 pt-16 lg:-mt-16">
        <main class="container mx-auto px-6 lg:px-12 py-10">
            <?php if ($event): ?>
                <article>
                    <h1 class="text-5xl font-extrabold text-gray-800 mb-4"><?php echo htmlspecialchars($event['title']); ?></h1>

                    <div class="flex items-center space-x-4 my-6">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($canonicalUrl); ?>"
                            target="_blank"
                            class="text-blue-600 hover:text-blue-800 rounded-lg p-3 transition-transform transform hover:scale-105">
                            <i class="fab fa-facebook-square text-2xl"></i>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($canonicalUrl); ?>&text=<?php echo urlencode($title); ?>"
                            target="_blank"
                            class="text-blue-400 hover:text-blue-600 rounded-lg p-3 transition-transform transform hover:scale-105">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>

                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($canonicalUrl); ?>"
                            target="_blank"
                            class="text-blue-700 hover:text-blue-900 rounded-lg p-3 transition-transform transform hover:scale-105">
                            <i class="fab fa-linkedin text-2xl"></i>
                        </a>

                        <a href="https://wa.me/?text=<?php echo urlencode($title . ' ' . $canonicalUrl); ?>"
                            target="_blank"
                            class="text-green-500 hover:text-green-700 rounded-lg p-3 transition-transform transform hover:scale-105">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </a>

                        <button id="copyButton" class="text-gray-700 hover:text-gray-900 rounded-lg p-3 transition-transform transform hover:scale-105">
                            <i class="fas fa-copy text-2xl"></i>
                        </button>
                    </div>

                    <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="w-full h-96 object-cover mb-4 rounded-lg">
                    <div class="text-gray-700 text-lg">
                        <?php echo nl2br($event['description']); ?>
                    </div>
                    <p class="text-gray-600 text-lg mb-4 mt-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                        Date: <?php echo htmlspecialchars($event['date']); ?>
                    </p>

                    <p class="text-gray-600 text-lg mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        Location: <?php echo htmlspecialchars($event['location']); ?>
                    </p>
                </article>

            <?php else: ?>
                <div class="flex flex-col items-center justify-center">
                    <img src="./assets/images/empty.svg" alt="No content available" class="w-64 h-auto mb-4">
                    <p class="text-gray-700 text-center mb-4">Oops... No event found with ID <?php echo $postId; ?></p>
                    <a href="/events" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Back to Events</a>
                </div>
            <?php endif; ?>

            <div class="flex flex-col items-center justify-center">
                <a href="/" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Go to home</a>
            </div>

        </main>
        <?php
        $footer = new HTMLFooter(Constants::SITE_URL);
        $footer->render();
        ?>
    </div>
</body>
<script>
    const copyButton = document.getElementById('copyButton');
    const textToShare = "<?php echo $canonicalUrl; ?>";
    const title = "<?php echo $title; ?>";

    copyButton.addEventListener('click', () => {
        if (navigator.share) {
            navigator.share({
                    title: title,
                    url: textToShare
                })
                .then(() => {
                    console.log('Successfully shared');
                })
                .catch(err => {
                    console.error('Error sharing: ', err);
                });
        } else {
            alert('Sharing is not supported on this device.');
        }
    });
</script>

</html>