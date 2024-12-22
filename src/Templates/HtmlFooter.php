<?php

namespace Muswalo\NurseTendiaBlog\Templates;

/**
 * Class HtmlFooter
 *
 * Generates the HTML code for the footer section of a webpage.
 *
 * @package Muswalo\Templates
 */
class HtmlFooter {
    /**
     * @var string Url path to append to logo.
     */
    private string $url;


    /**
     * Constructor for the HtmlFooter class.
     *
     * @param string $url The URL of the website.
     */
    public function __construct(string $url) {
        $this->url = $url;
    }

    /**
     * Renders the HTML footer.
     *
     * This method outputs the footer markup, including sections for About Us,
     *
     * @return void
     */
    public function render(): void {
        echo <<<HTML
        <footer class="bg-purple-600 text-white p-8 mt-8  flex place-content-center">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <a href="/">
                        <img src="{$this->url}./assets/logo.png" alt="Logo" class="mb-4 w-32 h-auto">
                    </a>
                    <h3 class="text-xl font-semibold mb-4">About Us</h3>
                    <p class="text-sm">
                        We are dedicated to providing accurate information and support for those affected by HIV and AIDS.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="hover:text-purple-200">Home</a></li>
                        <li><a href="/about" class="hover:text-purple-200">About</a></li>
                        <li><a href="/blog" class="hover:text-purple-200">Blog</a></li>
                        <li><a href="/contact" class="hover:text-purple-200">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-purple-200">HIV Testing</a></li>
                        <li><a href="#" class="hover:text-purple-200">Support Groups</a></li>
                        <li><a href="#" class="hover:text-purple-200">Educational Materials</a></li>
                        <li><a href="#" class="hover:text-purple-200">Research Updates</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
                    <p class="text-sm"><strong>Phone</strong>: +260973400223</p>
                    <p class="text-sm"><strong>Email</strong>: me@nursetendia.com</p>
                    <br>
                    <strong>
                        <p>&copy; <?php echo date("Y"); ?> Nurse Tendai's Blog. All Rights Reserved.</p>
                    </strong>
                </div>
            </div>
        </footer>
        HTML;
    }
}
