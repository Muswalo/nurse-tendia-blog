<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Tendai's - HIV/AIDS Blog</title>
    <link rel="apple-touch-icon" sizes="57x57" href="./assets/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./assets/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./assets/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./assets/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./assets/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./assets/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./assets/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./assets/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./assets/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/icons/favicon-16x16.png">
    <link rel="manifest" href="./assets/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./assets/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/main.js"></script>
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <aside id="side-menu"
        class="fixed top-0 left-0 h-full w-64 bg-purple-600 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50">
        <div class="flex flex-col h-full p-6">
            <div class="flex items-center justify-between">
                <a href="/" class="block p-4 shadow-lg rounded">
                    <img src="./assets/logo.png" alt="Nurse Tendai's Blog Logo" class="w-40">
                </a>
            </div>

            <nav class="mt-8 space-y-6">
                <h3 class="font-semibold text-lg mb-4">Navigation</h3>
                <a href="/" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.146-.439 1.585 0 .44.439.44 1.146 0 1.585L5.414 12l7.375 7.37c.44.439.44 1.146 0 1.585-.439.44-1.146.44-1.585 0L2.25 12z">  
                        </path>             </svg>
                    <span class="text-lg font-medium">Home</span>
                </a>
                <a href="/about" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                    </svg>
                    <span class="text-lg font-medium">About</span>
                </a>
                <a href="/blog" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.429 9.75 2.25 12l4.179 2.25M17.571 9.75 21.75 12l-4.179 2.25" />
                    </svg>
                    <span class="text-lg font-medium">Blog</span>
                </a>          </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 p-6">
        <h1 class="text-3xl font-semibold mb-6">HIV/AIDS Blog</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="./assets/blog1.jpg" alt="Blog Post 1" class="w-full h-64 object-cover object-center">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">Understanding HIV/AIDS</h2>
                    <p class="text-gray-600">Learn more about the HIV/AIDS virus and how it affects the human body.</p>
                    <a href="/blog/1" class="block mt-4 text-purple-600 hover:underline">Read More</a>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="./assets/blog2.jpg" alt="Blog Post 2" class="w-full h-64 object-cover object-center">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">Preventing HIV/AIDS</h:2>
                    <p class="text-gray-600">Learn how to prevent the spread of HIV/AIDS and protect yourself.</p>   
                    <a href="/blog/2" class="block mt-4 text-purple-600 hover:underline">Read More</a>
                </div>
            </div>