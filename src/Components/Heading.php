<?php
namespace Muswalo\NurseTendiaBlog\Components;

/**
 * Class Heading
 *
 * Generates the HTML code for a heading section of a webpage.
 *
 * @package Muswalo\Components
 */

class Heading
{
    /**
     * @var string The text to display in the heading.
     */
    private string $text;

    /**
     * @var string The message to display below the heading.
     */
    private string $message;

    /**
     * Constructor for the Heading class.
     *
     * @param string $text The text to display in the heading.
     * @param string $message The message to display below the heading.
     */
    public function __construct(string $text, string $message)
    {
        $this->text = $text;
        $this->message = $message;
    }

    /**
     * Renders the heading section.
     *
     * This method outputs the heading markup, including the text and message.
     *
     * @return void
     */
    public function render(): void
    {
        echo <<<HTML
        <section class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-gray-800 mb-4">{$this->text}</h1>
            <p class="text-lg text-gray-600">
                {$this->message}
            </p>
        </section>
        HTML;
    }
}
