<?php
require_once __DIR__ . '/vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Components\Heading;
use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Templates\HTMLFooter;
use Muswalo\NurseTendiaBlog\Templates\HtmlSideBar;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Controllers\Monitor;

$Monitor = new Monitor();
$Monitor->monitor();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $head = new HTMLHead(
        "Contact Nurse Tendai's Blog",
        "Get in touch with Nurse Tendai and her team.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "Contact, Nurse Tendai, HIV/AIDS, Blog, Support",
        "Nurse Tendai",
        Constants::SITE_URL . "/contact",
    );
    $head->render();
    ?>
    <script src="js/main.js" defer></script>
    <script src="js/contacts.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
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
            $heading = new Heading("Get in Touch, I’d Love to Hear From You", " I’d love to hear from you! Use the form below to share your questions, feedback, or thoughts, and I’ll do my best to respond promptly.");
            $heading->render();
            ?>

            <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Get in Touch</h2>

                    <p class="text-gray-700 mb-6">Feel free to reach out to us using the details below</p>
                    <ul class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <li class="flex items-center">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-purple-600">
                                    <path d="M19.5 22.5a3 3 0 0 0 3-3v-8.174l-6.879 4.022 3.485 1.876a.75.75 0 1 1-.712 1.321l-5.683-3.06a1.5 1.5 0 0 0-1.422 0l-5.683 3.06a.75.75 0 0 1-.712-1.32l3.485-1.877L1.5 11.326V19.5a3 3 0 0 0 3 3h15Z" />
                                    <path d="M1.5 9.589v-.745a3 3 0 0 1 1.578-2.642l7.5-4.038a3 3 0 0 1 2.844 0l7.5 4.038A3 3 0 0 1 22.5 8.844v.745l-8.426 4.926-.652-.351a3 3 0 0 0-2.844 0l-.652.351L1.5 9.589Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700">Email</span>
                                <a href="mailto:info@nurse-tendia-blog.com" class="text-purple-600 hover:underline block"><?php echo Constants::CONTACTS['email']; ?></a>
                            </div>
                        </li>
                        <li class="flex items-center">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-purple-600">
                                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700">Phone</span>
                                <a href="tel:+1234567890" class="text-purple-600 hover:underline block"><?php echo Constants::CONTACTS['phone']; ?></a>
                            </div>
                        </li>
                        <li class="flex items-center">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-purple-600">
                                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700">Address</span>
                                <p class="text-gray-600">Miss Tendia's location</p>
                            </div>
                        </li>
                        <li class="flex items-center">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-purple-600">
                                    <path fill-rule="evenodd" d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700">Instagram</span>
                                <a href="<?php echo Constants::CONTACTS["instagram"]; ?>" target="_blank" class="text-purple-600 hover:underline">Follow me on Instagram</a>
                            </div>
                        </li>

                        <li class="flex items-center">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size-5 fill-current text-purple-600">
                                    <path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700">Facebook</span>
                                <a href="<?php echo Constants::CONTACTS["facebook"]; ?>" target="_blank" class="text-purple-600 hover:underline">Follow me on Facebook</a>
                            </div>
                        </li>
                        <li class="flex items-center">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="size-5 text-purple-600 fill-current text-purple-600">
                                    <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" />
                                </svg>

                            </div>
                            <div>
                                <span class="font-bold text-gray-700">TikTok</span>
                                <a href="<?php echo Constants::CONTACTS["tiktok"]; ?>" target="_blank" class="text-purple-600 hover:underline">Follow me on TikTok</a>
                            </div>
                        </li>

                    </ul>
                </div>
                <!-- Contact Form -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Contact Form</h2>
                    <!-- Describe what the form is about -->
                    <p class="text-gray-700 mb-6">
                        I would love to hear from you, Please take a moment to fill in the form below and share your thoughts, questions, or feedback.
                        I'll do my best to get back to you as soon as possible.
                    </p>
                    <form action="#" method="post" id="contact-form">
                        <div class="mb-6">
                            <div id="error-viewer" class="bg-red-500 text-white p-3 rounded-md mb-4 text-center hidden">
                                <span id="error-message">Error message</span>
                            </div>
                            
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                            <div class="flex items-center border border-gray-300 rounded-md focus-within:ring-purple-600 focus-within:border-purple-600">
                                <span class="text-gray-500 px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                    </svg>

                                </span>
                                <input type="text" id="name" name="name" class="w-full px-3 py-2 bg-transparent outline-none" placeholder="Enter your name" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                            <div class="flex items-center border border-gray-300 rounded-md focus-within:ring-purple-600 focus-within:border-purple-600">
                                <span class="text-gray-500 px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                        <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                    </svg>

                                </span>
                                <input type="email" id="email" name="email" class="w-full px-3 py-2 bg-transparent outline-none" placeholder="Enter your email" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 font-semibold mb-2">Message</label>
                            <div class="flex items-start border border-gray-300 rounded-md focus-within:ring-purple-600 focus-within:border-purple-600">
                                <span class="text-gray-500 px-4 py-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97ZM6.75 8.25a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H7.5Z" clip-rule="evenodd" />
                                    </svg>

                                </span>
                                <textarea id="message" name="message" class="w-full px-3 py-2 bg-transparent outline-none resize-none" rows="5" placeholder="Enter your message" required></textarea>
                            </div>
                        </div>

                        <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-md w-full hover:bg-purple-700 focus:outline-none" id="submit-button">Send Message</button>
                    </form>
                </div>

            </div>

        </main>
        <?php
        $footer = new HTMLFooter(Constants::SITE_URL);
        $footer->render();
        ?>

    </div>
</body>

</html>