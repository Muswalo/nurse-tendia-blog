<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Muswalo\NurseTendiaBlog\Templates\HTMLHead;
use Muswalo\NurseTendiaBlog\Constants\Constants;
use Muswalo\NurseTendiaBlog\Components\Heading;
use Muswalo\NurseTendiaBlog\Utils\Utils;

session_start();

if (Utils::isAuthenticated()) {
    header("Location: home");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $head = new HTMLHead(
        "Nurse Tendai's Blog - Admin Login",
        "Login to manage your blog posts, events, and other website content.",
        Constants::DEFAULT_IMAGE,
        Constants::SITE_URL,
        Constants::THEME_COLOR,
        "admin, login, blog management, HIV/AIDS, Nurse Tendai",
        "Nurse Tendai",
        Constants::SITE_URL . "/admin/index",
    );
    $head->render();
    ?>
    <script src="js/login.js" defer></script>
</head>

<body class="bg-gray-100 flex items-center min-h-screen">
    <div class="grid grid-cols-1 md:grid-cols-[2fr_3fr] min-h-screen">
        <div class="flex-col flex items-center justify-center">
            <?php
            $heading = new Heading("Welcome Miss Mumba", "Log in to manage blog posts, track upcoming events, and keep the site up-to-date with the latest content.");
            $heading->render();
            ?>
            <div id="error-viewer" class="bg-red-500 text-white p-3 rounded-md mb-4 text-center w-full max-w-md hidden">
                <span id="error-message">Error message</span>
            </div>

            <form action="/admin/auth" method="post" class="w-10/12 max-w-md w-full bg-white p-8 rounded-xl shadow-lg space-y-6">
                <div class="mb-6">
                    <label for="username" class="block text-gray-800 font-semibold mb-2 text-lg">Username</label>
                    <input type="text" id="username" name="username" class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-lg transition ease-in-out duration-300" required>
                </div>
                <div class="mb-6 relative">
                    <label for="password" class="block text-gray-800 font-semibold mb-2 text-lg">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-lg transition ease-in-out duration-300"
                            required>
                        <button
                            type="button"
                            id="toggle-password"
                            class="absolute inset-y-0 right-4 flex items-center text-gray-500 focus:outline-none">
                            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-4 px-5 rounded-xl text-lg focus:outline-none focus:ring-4 focus:ring-purple-300 transition ease-in-out duration-300">
                        Login
                    </button>
                </div>
            </form>
        </div>

        <div class="hidden md:block">
            <img src="./assets/login-image.webp" alt="Login Image" class="w-full h-screen object-cover">
        </div>
    </div>
</body>
<script>
    const togglePasswordButton = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');
    const iconEye = document.getElementById('icon-eye');

    togglePasswordButton.addEventListener('click', () => {
        const isPasswordVisible = passwordField.type === 'text';
        passwordField.type = isPasswordVisible ? 'password' : 'text';
        iconEye.innerHTML = isPasswordVisible ?
            `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />` :
            `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
               <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />`;
    });
</script>

</html>