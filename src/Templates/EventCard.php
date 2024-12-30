<?php

namespace Muswalo\NurseTendiaBlog\Templates;

/**
 * Class EventCard
 * 
 * Renders a card for blog events.
 */
class EventCard
{
    /**
     * Renders the HTML for multiple event cards.
     *
     * @param Event[] $events An array of Event objects.
     *
     * @return string The HTML for the event cards.
     */
    public static function renderMultiple(array $events): string
    {
        $cards = '';

        foreach ($events as $event) {
            $cards .= <<<HTML
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-2">{$event->title}</h3>
                <div class="flex items-start space-x-4">
                    <p class="text-gray-700 mb-4 flex-1">{$event->description} <br> 
                    <strong>Date:</strong> {$event->date} <br> 
                    <strong>Location:</strong> {$event->location}</p>
                    <img src="{$event->image}" alt="Event image" class="w-20 h-20 rounded-md">
                </div>
                <a href="{$event->link}" class="text-purple-600 hover:underline">Learn more</a>
            </div>
            HTML;
        }

        return <<<HTML
        <div class="grid gap-6 md:grid-cols-3">
            $cards
        </div>
        HTML;
    }
}

class Event
{
    public string $title;
    public string $image;
    public string $description;
    public string $date;
    public string $link;
    public string $location;

    /**
     * Constructor for the Event class.
     *
     * @param string $title The title of the event.
     * @param string $image The URL of the image for the event.
     * @param string $description The description of the event.
     * @param string $date The date of the event.
     * @param string $link The link to the event.
     * @param string $location The location of the event.
     */
    public function __construct(string $title, string $image, string $description, string $date, string $link, string $location)
    {
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
        $this->date = $date;
        $this->link = $link;
        $this->location = $location;
    }
}
