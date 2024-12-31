<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Admin\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Utils\Utils;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;
use Muswalo\NurseTendiaBlog\Components\Heading;

if (!Utils::isAuthenticated()) {
    header("Location: index");
    exit();
}

$controller = new Controllers();
$postId = $_GET['id'] ?? null;

if (!$postId) {
    header("Location: articles");
    exit();
}

$post = $controller->getBlogPost($postId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Post Not Found";
    $description = "The requested post was not found.";
    $imageUrl = Constants::DEFAULT_IMAGE;
    $canonicalUrl = Constants::SITE_URL . "/admin/manage?id=" . $postId;

    if ($post) {
        $title = htmlspecialchars($post['title']);
        $description = htmlspecialchars(substr($post['content'], 0, 150));
        $imageUrl = $post['image_url'] ?? Constants::DEFAULT_IMAGE;
        $canonicalUrl = Constants::SITE_URL . "/admin/manage?id=" . $postId;
    }

    $head = new HTMLHead(
        $title,
        $description,
        $imageUrl,
        $canonicalUrl,
        Constants::THEME_COLOR,
        "admin, manage, article, blog management, HIV/AIDS, Nurse Tendai",
        "Nurse Tendai",
        $canonicalUrl
    );
    $head->render();
    ?>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <script src="../js/main.js" defer></script>
    <script src="js/manage.js" defer></script>
    <script src="js/side-bar.js" defer></script>
</head>

<body class="bg-gray-100">
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL, "Tendia Mumba");
    $sidebar->render();
    ?>
    <div class="lg:ml-64 pt-16 lg:-mt-16">
        <main class="container mx-auto px-6 lg:px-12 py-10">
            <?php if ($post): ?>
                <?php
                $Heading = new Heading("Manage Article", "Edit and manage your blog posts. after you have updated the necessary parts click save changes to update the article.");
                $Heading->render();
                ?>
                <h2 class="text-3xl font-extrabold text-gray-800 mb-8"><?php echo $post['title']; ?></h2>
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <div class="flex justify-between items-center">
                        <p class="text-gray-700 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>

                            <span>Views <?php echo $post['views'] ?? 0; ?></span>
                        </p>
                        <div onclick="handleDelete('<?php echo $postId ?>')" class="flex items-center">
                            <button class="flex items-center px-4 py-2 bg-red-600 text-white rounded-md shadow hover:bg-red-700">
                                <span id="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </span>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <form method="post" class="bg-white p-6 rounded-lg shadow-lg" id="form">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($postId); ?>" id="id">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-bold mb-2">
                            Title
                        </label>
                        <input type="text" id="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition ease-in-out duration-300" value="<?php echo $post['title']; ?>">
                    </div>


                    <div class="mb-4">
                        <label for="author" class="block text-gray-700 font-bold mb-2">
                            Author
                        </label>
                        <input type="text" id="author" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition ease-in-out duration-300" value="<?php echo $post['author']; ?>">
                    </div>

                    <div class="mb-4 relative">
                        <label for="image" class="block text-gray-700 font-bold mb-2">Image</label>
                        <div id="drop-region" class="w-full px-4 py-16 border-2 border-dashed border-gray-300 rounded-lg text-center cursor-pointer transition ease-in-out duration-300 hover:border-purple-500 hover:bg-purple-100 flex flex-col items-center justify-center <?php echo ($post['image_url']) ? 'hidden' : ''; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400 mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                            </svg>

                            <p class="text-gray-500">Drag and drop an image here, or click to select a file</p>

                            <input type="file" id="image" name="image_url" class="hidden" accept="image/*">
                        </div>
                        <div id="image-preview" class="mt-4 relative <?php echo ($post['image_url']) ? '' : 'hidden'; ?>">
                            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="Preview" class="w-full h-auto rounded-lg border border-gray-300">
                            <button type="button" id="remove-image" class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 font-bold mb-2">
                            Content
                        </label>
                        <div id="editor" style="height: 300px;"></div>

                    </div>

                    <div class="mb-4">
                        <label for="featured" class="flex items-center">
                            <input type="checkbox" id="featured" class="mr-2" value="<?php echo $post['featured']; ?>">
                            <span class="text-gray-700 font-medium">
                                Feature this article
                            </span>
                        </label>
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline" id="submit">
                            Save Changes
                        </button>
                    </div>

                </form>
            <?php else: ?>
                <div class="flex flex-col items-center justify-center">
                    <img src="../assets/images/empty.svg" alt="No content available" class="w-64 h-auto mb-4">
                    <p class="text-gray-700 text-center mb-4">Oops... No post found with ID <?php echo htmlspecialchars($postId); ?></p>
                    <a href="articles" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Back to Articles</a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.min.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    quill.root.innerHTML = `<?php echo $post['content']; ?>`;
</script>

</html>