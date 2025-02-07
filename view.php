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
$postId = $_GET['id'] ?? null;

if (!$postId) {
    header("Location: /blog");
    exit();
}

$post = $controller->getBlogPost($postId);
$suggestedPosts = $controller->getSuggestedPosts($postId);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Post Not Found";
    $description = "The requested post was not found.";
    $imageUrl = Constants::DEFAULT_IMAGE;
    $canonicalUrl = Constants::SITE_URL . "/blog";

    if (!$post) {
        http_response_code(404);
    }

    if ($post) {
        $title = htmlspecialchars($post['title']);
        $description = htmlspecialchars(substr($post['content'], 0, 150));
        $imageUrl = $post['image_url'] ?? Constants::DEFAULT_IMAGE;
        $canonicalUrl = Constants::SITE_URL . "/view.php?id=" . $postId;


        try {
            $controller->incrementPostViews($postId);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        }
    }


    $head = new HTMLHead(
        $title,
        $description,
        $imageUrl,
        $canonicalUrl,
        Constants::THEME_COLOR,
        "blog, article, HIV/AIDS, Nurse Tendai",
        "Nurse Tendai",
        $canonicalUrl
    );

    $head->render();
    ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="js/main.js"></script>
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL);
    $sidebar->render();
    ?>


    <div class="lg:ml-64 pt-16 lg:-mt-16">
        <main class="container mx-auto px-6 lg:px-12 py-10" id="main-content">
            <?php if ($post): ?>
                <article>
                    <h1 class="text-5xl font-extrabold text-gray-800 mb-4"><?php echo htmlspecialchars($post['title']); ?></h1>
                    <p class="text-gray-600 mb-4">By <?php echo htmlspecialchars($post['author']); ?> on <?php echo date("F j, Y", strtotime($post['created_at'])); ?></p>

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

                    <?php if ($post['image_url']): ?>
                        <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="w-full rounded-lg mb-4">
                    <?php endif; ?>

                    <div class="text-gray-700 text-lg">
                        <?php echo nl2br($post['content']); ?>
                    </div>
                </article>

            <?php else: ?>
                <div class="flex flex-col items-center justify-center">
                    <img src="./assets/images/empty.svg" alt="No content available" class="w-64 h-auto mb-4">
                    <p class="text-gray-700 text-center mb-4">Oops... No post found with ID <?php echo $postId; ?></p>
                    <a href="/blog" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Back to Blog</a>
                </div>
            <?php endif; ?>

            <h2 class="text-3xl font-extrabold text-gray-800 mt-12 mb-6">Suggested Posts</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($suggestedPosts as $suggestedPost): ?>
                    <div class="bg-white p-6 rounded-lg shadow-lg mb-6"> <!-- Added mb-6 for spacing -->
                        <img src="<?php echo htmlspecialchars($suggestedPost['image_url']); ?>" alt="Post Image" class="w-full h-48 object-cover mb-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="/view.php?id=<?php echo htmlspecialchars($suggestedPost['id']); ?>" class="hover:underline">
                                <?php echo htmlspecialchars($suggestedPost['title']); ?>
                            </a>
                        </h3>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex justify-center mt-6">
                <a href="/" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                    Go to home
                </a>
            </div>
        </main>
        <!-- Footer -->
        <?php
        $footer = new HTMLFooter(Constants::SITE_URL);
        $footer->render();
        ?>

    </div>
</body>
<script>
    const textToShare = "<?php echo $canonicalUrl; ?>";
    const title = "<?php echo $title; ?>";
    const copyButton = document.getElementById('copyButton');

    copyButton.addEventListener('click', () => {
        console.log("Emmanuel is awesome");
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