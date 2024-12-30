<?php

namespace Muswalo\NurseTendiaBlog\Admin\Templates;

use Muswalo\NurseTendiaBlog\Constants\Constants;

/**
 * Class HtmlSideBar
 *
 * Generates the HTML code for the sidebar section of a webpage.
 */
class HtmlSideBar
{
    private string $url;
    private array $contacts;
    private string $userName;
    private string $userImage;


    public function __construct(string $url, string $userName = "Admin User", string $userImage = "/assets/images/nursetendia.webp") 
    {
        $this->url = $url;
        $this->contacts = Constants::CONTACTS;
        $this->userName = $userName;
        $this->userImage = $userImage;
    }

    public function render(): void
    {

        $currentYear = date("Y");

        echo <<<HTML
        <aside id="side-menu" class="fixed top-0 left-0 h-full w-64 bg-purple-600 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50">
            <div class="flex flex-col h-full p-6">
                <!-- User Profile Section -->
                <div class="flex items-center mb-8">
                    <img src="{$this->userImage}" alt="User Profile" class="w-10 h-10 rounded-full mr-2">
                    <span class="text-lg font-medium">{$this->userName}</span>
                </div>
                

                <nav class="mt-8 space-y-6">
                    <h3 class="font-semibold text-lg mb-4">Navigation</h3>
                    <a href="/admin/home" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>

                        <span class="text-lg font-medium">Dashboard</span>
                    </a>

                    <a href="/admin/create-post" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                        </svg>

                        <span class="text-lg font-medium">Create Post</span>
                    </a>

                    <a href="/admin/create-event" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span class="text-lg font-medium">Create Event</span>
                    </a>
                    <a href="/admin/articles" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                        </svg>
                        <span class="text-lg font-medium">Articles</span>
                    </a>
                     <a href="/admin/events" class="flex items-center space-x-4 text-white hover:bg-purple-700 p-2 px-6 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                    </svg>
                    <span class="text-lg font-medium">Events</span>
                </a>


                </nav>

                <!-- Logout Button -->
                <div class="mt-auto">  
                    <button class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded mt-6" id="logout-btn">
                        Logout
                    </button>
                </div>
                <div class="mt-8 text-center">
                    <p class="text-gray-300 text-sm">&copy; {$currentYear} Nurse Tendai's Blog. All Rights Reserved.</p>
                </div>

            </div>

        </aside>

        <header class="bg-purple-600 text-white fixed w-full z-40 lg:hidden h-16">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <button id="menu-toggle" class="p-2 rounded-full bg-gray-800 text-white hover:bg-gray-700 transition-colors"
                onclick="toggleMenu()" aria-expanded="false">
                <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="flex items-center">
                    <img src="{$this->userImage}" alt="User Profile" class="w-8 h-8 rounded-full mr-2">
                    <span class="text-lg font-medium">{$this->userName}</span>
             </div>
         </div>
        </header>
        HTML;
    }
}
