<?php

namespace Muswalo\NurseTendiaBlog\Templates;

/**
 * Class Post
 * 
 * Represents a single blog post.
 */
class Post
{
    public string $title;
    public string $image;
    public string $excerpt;
    public string $author;
    public string $date;
    public string $id;
    public string $link;

    /**
     * Constructor for the Post class.
     *
     * @param string $title   The title of the blog post.
     * @param string $image   The URL of the image for the blog post.
     * @param string $excerpt The excerpt of the blog post.
     * @param string $author  The author of the blog post.
     * @param string $date    The date of the blog post.
     * @param string $id      The ID of the blog post.
     * @param string $link    The link to the blog post.
     */
    public function __construct(string $title, string $image, string $excerpt, string $author, string $date, string $id, string $link)
    {
        $this->title = $title;
        $this->image = $image;
        $this->excerpt = $excerpt;
        $this->author = $author;
        $this->date = $date;
        $this->id = $id;
        $this->link = $link;
    }
}

/**
 * Class PostCard
 * 
 * Renders a card for blog posts.
 */
class PostCard
{
    /**
     * Renders the HTML for multiple post cards.
     *
     * @param Post[] $posts An array of Post objects.
     *
     * @return string The HTML for the post cards.
     */
    public static function renderMultiple(array $posts): string
    {
        $cards = '';

        foreach ($posts as $post) {
            $cards .= <<<HTML
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{$post->image}" alt="Article Image" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{$post->title}</h3>
                    <p class="text-gray-600 text-sm mb-2">By {$post->author}</p>
                    <p class="text-gray-500 text-xs mb-4">Published on {$post->date}</p>
                    <p class="text-gray-700 mb-4">{$post->excerpt}</p>
                    <a href="{$post->link}" class="text-purple-600 hover:underline">Read more</a>
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
