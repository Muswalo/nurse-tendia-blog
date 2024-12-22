<?php

namespace Muswalo\NurseTendiaBlog\Templates;

/**
 * Class HTMLHead
 * 
 * Renders the head section of an HTML document with meta tags and icons.
 */
class HTMLHead {
    /**
     * @var string The title of the webpage.
     */
    private string $title;

    /**
     * @var string The description of the webpage for meta tags.
     */
    private string $description;

    /**
     * @var string The URL of the image for social sharing.
     */
    private string $image;

    /**
     * @var string The URL of the website.
     */
    private string $siteUrl;

    /**
     * @var string The theme color for the browser.
     */
    private string $themeColor;

    /**
     * @var string The keywords for the webpage.
     */
    private string $keywords;

    /**
     * @var string The authors of the webpage.
     */
    private string $author;

    /**
     * @var string The URL of the current page.
     */
    private $pageUrl;

    /**
     * Constructor for the HTMLHead class.
     *
     * @param string $title       The title of the webpage.
     * @param string $description The description of the webpage.
     * @param string $image       The URL of the image for social sharing.
     * @param string $siteUrl     The URL of the website.
     * @param string $themeColor  The theme color for the browser.
     * @param string $keywords    The keywords for the webpage.
     * @param string  $author      The authors of the webpage.
     * @param string $pageUrl     The URL of the current page.
     */
    public function __construct(
        string $title,
        string $description,
        string $image,
        string $siteUrl,
        string $themeColor,
        string $keywords,
        string $author,
        string $pageUrl
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->siteUrl = $siteUrl;
        $this->themeColor = $themeColor;
        $this->keywords = $keywords;
        $this->author = $author;
        $this->pageUrl = $pageUrl;
    }

    /**
     * Renders the HTML head section.
     *
     * @return void
     */
    public function render(): void {
        echo <<<HTML
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{$this->title}</title>
        <meta name="description" content="{$this->description}">
        <meta name="theme-color" content="{$this->themeColor}">
        <meta property="og:title" content="{$this->title}">
        <meta property="og:description" content="{$this->description}">
        <meta property="og:image" content="{$this->image}">
        <meta property="og:url" content="{$this->pageUrl}">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{$this->title}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{$this->title}">
        <meta name="twitter:description" content="{$this->description}">
        <meta name="twitter:image" content="{$this->image}">
        <meta name="keywords" content="{$this->keywords}">
        <meta name="author" content="{$this->author}">
        <link rel="canonical" href="{$this->pageUrl}">
        <link rel="apple-touch-icon" sizes="57x57" href="{$this->siteUrl}/assets/icons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="{$this->siteUrl}/assets/icons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="{$this->siteUrl}/assets/icons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{$this->siteUrl}/assets/icons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="{$this->siteUrl}/assets/icons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{$this->siteUrl}/assets/icons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="{$this->siteUrl}/assets/icons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{$this->siteUrl}/assets/icons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="{$this->siteUrl}/assets/icons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192" href="{$this->siteUrl}/assets/icons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{$this->siteUrl}/assets/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="{$this->siteUrl}/assets/icons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{$this->siteUrl}/assets/icons/favicon-16x16.png">
        <link rel="manifest" href="{$this->siteUrl}/assets/icons/manifest.json">
        <script src="https://cdn.tailwindcss.com"></script>
        HTML;
    }
}
