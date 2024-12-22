<?php

namespace Muswalo\NurseTendiaBlog\Templates;

/**
 * Class HtmlSideBar
 *
 * Generates the HTML code for the sidebar section of a webpage.
 *
 * @package Muswalo\Templates
 */

class HtmlSideBar
{
    /**
     * @var string Url path to append to logo.
     */
    private string $url;

    /**
     * Constructor for the HtmlSideBar class.
     *
     * @param string $url The URL of the website.
     */
    public function __construct(string $url) {
        $this->url = $url;
    }

    /**
     * Renders the HTML sidebar.
     *
     * @return void
     */
    public function render(): void
    {
        echo <<<HTML
            <aside id="side-menu"
        class="fixed top-0 left-0 h-full w-64 bg-purple-600 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50">
        <div class="flex flex-col h-full p-6">
            <div class="flex items-center justify-between">
                <a href="/" class="block p-4 shadow-lg rounded">
                    <img src="{$this->url}/assets/logo.png" alt="Nurse Tendai's Blog Logo" class="w-40">
                </a>
            </div>

            <nav class="mt-8 space-y-6">
                <h3 class="font-semibold text-lg mb-4">Navigation</h3>
                <a href="/" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
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
                            d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                    </svg>
                    <span class="text-lg font-medium">Blog</span>
                </a>

                <a href="/events" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                    </svg>
                    <span class="text-lg font-medium">Events</span>
                </a>

                <a href="/contact"
                    class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    <span class="text-lg font-medium">Contact</span>
                </a>
            </nav>

            <div class="mt-8">
                <h3 class="font-semibold text-lg text-bold mb-4">Connect</h3>
                <ul class="space-y-2">
                    <li><a href="#"
                            class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-facebook">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                            </svg> <span>Facebook</span>
                        </a></li>
                    <li><a href="#"
                            class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-instagram">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg> <span>Instagram</span>
                        </a></li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Header -->
    <header class="bg-purple-600 bg-opacity-90 backdrop-blur-md text-white fixed w-full z-10 lg:hidden h-16">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="block">
                <img src="./assets/logo.png" alt="Nurse Tendai's Blog Logo" class="w-20 h-auto">
            </a>
            <button id="menu-toggle" class="p-2 rounded-full bg-gray-800 text-white hover:bg-gray-700 transition-colors"
                onclick="toggleMenu()" aria-expanded="false">
                <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>
    </header>

    HTML;
    }
}
