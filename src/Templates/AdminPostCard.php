<?php

namespace Muswalo\NurseTendiaBlog\Templates;
use Muswalo\NurseTendiaBlog\Utils\Utils;
/**
 * Class AdminPost
 *
 * Represents a single admin-managed blog post.
 */
class AdminPost
{
    public string $id;
    public string $title;
    public string $image;
    public string $excerpt;
    public string $link;
    public bool $isFeatured;
    public string $reads;
    

    /**
     * Constructor for the AdminPost class.
     *
     * @param string $id          The post id
     * @param string $title       The title of the blog post.
     * @param string $image       The URL of the image for the blog post.
     * @param string $excerpt     The excerpt of the blog post.
     * @param string $link        The link to manage the blog post.
     * @param bool   $isFeatured  Indicates if the post is featured.
     * @param string $reads       The number of reads the post has
     */
    public function __construct(string $id, string $title, string $image, string $excerpt, string $link, string $reads, bool $isFeatured = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->excerpt = $excerpt;
        $this->link = $link;
        $this->isFeatured = $isFeatured;
        $this->reads = $reads;
    }
}

/**
 * Class AdminPostCard
 *
 * Renders a card for admin-managed blog posts.
 */
class AdminPostCard
{
    /**
     * Renders the HTML for multiple admin post cards.
     *
     * @param AdminPost[] $posts An array of AdminPost objects.
     *
     * @return string The HTML for the admin post cards.
     */
    public static function renderMultiple(array $posts): string
    {
        $cards = '';

        foreach ($posts as $post) {
            $formatedReads = Utils::formatNumber($post->reads);
            $title = Utils::generateExcerpt($post->title, 23);
            $Activeicon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-yellow-500">
                            <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd" />
                        </svg>';

            $inActiveIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-500">
                            <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd" />
                        </svg>';
            $featuredIcon = $post->isFeatured ? $Activeicon : $inActiveIcon;

            $cards .= <<<HTML
            <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
                <img src="{$post->image}" alt="Article Image" class="w-full h-48 object-cover">
                <div class="absolute top-4 right-4"onclick="toggleFeatured({$post->id},  {$post->isFeatured})" id="{$post->id}">
                    $featuredIcon
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{$title}</h3>
                    <p class="text-gray-700 mb-4">{$post->excerpt}</p>
                    <p class="text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                        </svg>
                        <span class="text-sm">{$formatedReads}</span>
                    </p>
                    <a href="{$post->link}" class="text-purple-600 hover:underline">Manage article</a>
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
}
