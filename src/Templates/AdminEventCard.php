<?php

namespace Muswalo\NurseTendiaBlog\Templates;
use Muswalo\NurseTendiaBlog\Utils\Utils;

/**
 * Class AdminEvent
 *
 * Represents a single admin-managed event.
 */
class AdminEvent
{
    public string $id;
    public string $title;
    public string $image;
    public string $description;
    public string $link;
    public bool $isFeatured;

    /**
     * Constructor for the AdminEvent class.
     *
     * @param string $id          The event ID.
     * @param string $title       The title of the event.
     * @param string $image       The URL of the event image.
     * @param string $description The description of the event.
     * @param string $link        The link to manage the event.
     * @param bool   $isFeatured  Indicates if the event is featured.
     */
    public function __construct(string $id, string $title, string $image, string $description, string $link, bool $isFeatured = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
        $this->link = $link;
        $this->isFeatured = $isFeatured;
    }
}

/**
 * Class AdminEventCard
 *
 * Renders a card for admin-managed events.
 */
class AdminEventCard
{
    /**
     * Renders the HTML for multiple admin event cards.
     *
     * @param AdminEvent[] $events An array of AdminEvent objects.
     *
     * @return string The HTML for the admin event cards.
     */
    public static function renderMultiple(array $events): string
    {
        $cards = '';

        foreach ($events as $event) {
            $formattedTitle = Utils::generateExcerpt($event->title, 23);
            $featuredIcon = $event->isFeatured ? self::getActiveIcon() : self::getInactiveIcon();

            $cards .= <<<HTML
            <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
                <img src="{$event->image}" alt="Event Image" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{$formattedTitle}</h3>
                    <p class="text-gray-700 mb-4">{$event->description}</p>
                    <a href="{$event->link}" class="text-purple-600 hover:underline">Manage event</a>
                </div>
            </div>
            HTML;
        }

        return <<<HTML
            <div class="grid gap-6 md:grid-cols-3">
                $cards
            </div>
        HTML;
    }

    /**
     * Gets the SVG icon for an active featured state.
     *
     * @return string The SVG HTML for the active icon.
     */
    private static function getActiveIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-yellow-500">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                </svg>';
    }

    /**
     * Gets the SVG icon for an inactive featured state.
     *
     * @return string The SVG HTML for the inactive icon.
     */
    private static function getInactiveIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-500">
                    <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd" />
                </svg>';
    }
}
