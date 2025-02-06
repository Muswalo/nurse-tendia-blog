<?php

namespace Muswalo\NurseTendiaBlog\Templates;


/**
 * Class VideoCard
 * 
 * Renders a card for video content with a modal player.
 */
class VideoCard
{
    /**
     * Renders the HTML for multiple video cards.
     *
     * @param Video[] $videos An array of Video objects.
     *
     * @return string The HTML for the video cards and modal.
     */
    public static function renderMultiple(array $videos): string
    {
        $cards = '';

        foreach ($videos as $video) {
            $cards .= <<<HTML
            <div class="relative group overflow-hidden rounded-lg shadow-xl hover:shadow-2xl transition-all duration-300" data-video-src="{$video->videoSrc}">
                <div class="relative aspect-video">
                    <img src="{$video->thumbnail}" alt="{$video->altText}"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-purple-900/30 flex items-center justify-center">
                        <button class="play-button bg-white/90 rounded-full p-4 hover:bg-white transition-colors"
                            aria-label="Play video">
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6 bg-white">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{$video->title}</h3>
                    <p class="text-gray-600 text-sm mb-4">{$video->description}</p>
                    <div class="flex items-center text-sm text-purple-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {$video->duration} min watch
                    </div>
                </div>
            </div>
            HTML;
        }

        $modal = <<<HTML
        <!-- Video Modal -->
        <div id="video-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/75 p-4">
            <div class="relative w-full max-w-4xl bg-white rounded-lg overflow-hidden shadow-2xl">
                <button id="close-modal" class="absolute top-4 right-4 z-50 p-2 bg-white/80 rounded-full hover:bg-white transition-colors">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="aspect-video bg-black">
                    <video id="modal-video" class="w-full h-full" controls>
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <div class="p-6">
                    <h3 id="video-title" class="text-2xl font-bold text-gray-800 mb-2"></h3>
                    <p id="video-description" class="text-gray-600"></p>
                </div>
            </div>
        </div>
        HTML;

        return <<<HTML
        <div class="grid gap-6 md:grid-cols-3">
            $cards
        </div>
        $modal
        HTML;
    }
}

class Video
{
    public string $title;
    public string $thumbnail;
    public string $altText;
    public string $description;
    public string $duration;
    public string $videoSrc;

    /**
     * Constructor for the Video class.
     *
     * @param string $title The title of the video.
     * @param string $thumbnail The URL of the thumbnail image.
     * @param string $altText The alt text for the thumbnail image.
     * @param string $description The description of the video.
     * @param string $duration The duration of the video.
     * @param string $videoSrc The URL of the video file.
     */
    public function __construct(string $title, string $thumbnail, string $altText, string $description, string $duration, string $videoSrc)
    {
        $this->title = $title;
        $this->thumbnail = $thumbnail;
        $this->altText = $altText;
        $this->description = $description;
        $this->duration = $duration;
        $this->videoSrc = $videoSrc;
    }
}