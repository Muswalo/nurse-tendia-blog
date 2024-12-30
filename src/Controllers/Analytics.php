<?php

namespace Muswalo\NurseTendiaBlog\Controllers;

use Muswalo\NurseTendiaBlog\Controllers\Controllers;

/**
 * Class Analytics
 * Provides analytics for the blog, including total visits, articles, unique visits, and reads.
 */
class Analytics
{
    /**
     * @var Controllers The controller instance used for retrieving analytics data.
     */
    private $controller;

    /**
     * Analytics constructor.
     * Initializes the controller instance.
     */
    public function __construct()
    {
        $this->controller = new Controllers();
    }

    /**
     * Get the total number of visits.
     *
     * @return string The total number of visits.
     */
    public function total_visits(): string
    {
        return $this->controller->sumTimesVisited();
    }

    /**
     * Get the total number of articles.
     *
     * @return string The total number of articles.
     */
    public function total_articles(): string
    {
        return $this->controller->countBlogPostsRows();
    }

    /**
     * Get the total number of unique visits.
     *
     * @return string The total number of unique visits.
     */
    public function total_unique_visits(): string
    {
        return $this->controller->countMetricsRows();
    }

    /**
     * Get the total number of reads.
     *
     * @return string The total number of reads.
     */
    public function total_reads(): string
    {
        return $this->controller->sumBlogPostViews();
    }
}
