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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $head = new HTMLHead(
        "Nurse Tendai's Blog - Create Event",
        "Create and manage your blog events.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "admin, create, event, blog management, HIV/AIDS, Nurse Tendai",
        "Nurse Tendai",
        Constants::SITE_URL . "/admin/create-event",
    );
    $head->render();
    ?>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <script src="../js/main.js" defer></script>
    <script src="js/create-event.js" defer></script>
    <script src="js/side-bar.js" defer></script>

</head>

<body class="bg-gray-100">
    <?php
    $sidebar = new HtmlSideBar(Constants::SITE_URL);
    $sidebar->render();
    ?>

    <div class="lg:ml-64 pt-16 lg:-mt-16">
        <main class="container mx-auto p-4" id="main-content">
            <?php
            $Heading = new Heading("Create New Event", "Ensure the description is concise, includes relevant keywords, and accurately represents the page content.");
            $Heading->render();
            ?>
            <form method="post" class="bg-white p-6 rounded-lg shadow-lg" id="form">
                <p class="text-gray-600 text-sm my-4">All fields marked <span class="text-red-500">*</span> Are mandatory.</p>
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">
                        Title
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition ease-in-out duration-300">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">
                        Description
                        <span class="text-red-500">*</span>
                    </label>
                    <div id="editor" style="height: 300px;"></div>
                </div>
                <div class="mb-4 relative">
                    <label for="image" class="block text-gray-700 font-bold mb-2">Image</label>
                    <div id="drop-region" class="w-full px-4 py-16 border-2 border-dashed border-gray-300 rounded-lg text-center cursor-pointer transition ease-in-out duration-300 hover:border-purple-500 hover:bg-purple-100 flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                        </svg>

                        <p class="text-gray-500">Drag and drop an image here, or click to select a file</p>

                        <input type="file" id="image" class="hidden" accept="image/*">
                    </div>
                    <div id="image-preview" class="hidden mt-4 relative">
                        <img src="" alt="Selected Image" class="w-full h-auto rounded-lg border border-gray-300">
                        <button type="button" id="remove-image" class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 font-bold mb-2">
                        Date
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition ease-in-out duration-300">
                </div>
                <div class="mb-4">
                    <label for="location" class="block text-gray-700 font-bold mb-2">
                        Location
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="location" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition ease-in-out duration-300">
                </div>
                <div class="mb-4">
                    <label for="featured" class="flex items-center">
                        <input type="checkbox" id="featured" class="mr-2">
                        <span class="text-gray-700 font-medium">
                            Feature this event <span class="text-xs text-gray-500">(Featured events are displayed prominently on the home page)</span>
                        </span>
                    </label>
                </div>

                <div class="mb-4">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline" id="submit">
                        Create Event
                    </button>
                </div>
            </form>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });
    </script>
</body>

</html>
