<?php

namespace Muswalo\NurseTendiaBlog\Utils;

use Muswalo\NurseTendiaBlog\Constants\Constants;

class Utils
{
    /**
     * Sets a cookie with the specified parameters.
     *
     * @param string $name     The name of the cookie.
     * @param string $value    The value of the cookie.
     * @param int    $expiry  The expiry time of the cookie in seconds.
     * @param string $path    The path for which the cookie is valid.
     * @param string $domain  The domain for which the cookie is valid.
     * @param bool   $secure  Whether the cookie should only be transmitted over HTTPS.
     * @param bool   $httponly Whether the cookie should only be accessible through HTTP.
     *
     * @return void
     */
    public static function setCookie(
        string $name,
        string $value,
        int $expiry,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httponly = true
    ): void {
        setcookie($name, $value, time() + $expiry, $path, $domain, $secure, $httponly);
    }

    /**
     * Retrieves the value of a cookie.
     *
     * @param string $name The name of the cookie.
     *
     * @return string|null The value of the cookie, or null if the cookie is not set.
     */
    public static function getCookie(string $name): ?string
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    /**
     * Deletes a cookie by setting its expiry time to the past.
     *
     * @param string $name   The name of the cookie.
     * @param string $path   The path for which the cookie is valid.
     * @param string $domain The domain for which the cookie is valid.
     *
     * @return void
     */
    public static function deleteCookie(string $name, string $path = '/', string $domain = ''): void
    {
        self::setCookie($name, '', time() - 3600, $path, $domain);
    }


    /**
     * Redirects the user to the specified URL.
     *
     * @param string $url The URL to redirect to.
     *
     * @return void
     */
    public static function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }

    /**
     * Checks if the given string is a valid URL.
     *
     * @param string $url The URL to check.
     *
     * @return bool True if the URL is valid, false otherwise.
     */
    public static function isValidUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Sanitizes a string to prevent XSS attacks.
     *
     * @param string $string The string to sanitize.
     *
     * @return string The sanitized string.
     */
    public static function sanitizeString(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }


    /**
     * Generate UUID
     * @return string
     */
    public static function generateUUID(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff)
        );
    }

    /**
     * Generates an excerpt from text.
     *
     * @param string $text The long text to be converted.
     * @param int $limit The maximum number of characters for the excerpt. Default is 100.
     * @return string The excerpt.
     */
    public static function generateExcerpt(string $text, int $limit = 100): string
    {
        if (strlen($text) <= $limit) {
            return $text;
        }

        // Trim the text to the specified limit and add ellipsis
        return substr($text, 0, $limit) . '...';
    }

    /**
     * Converts database format to the desired format.
     *
     * @param array $data The input data from the database.
     * @return array The transformed data.
     */
    public static function transformData(array $data): array
    {
        $transformedData = [];

        foreach ($data as $item) {
            $transformedData[] = [
                "id" => $item["id"] ?? "",
                "title" => $item["title"] ?? "",
                "author" => $item["author"] ?? "",
                "excerpt" => self::generateExcerpt($item["content"] ?? "", 100),
                "image" => $item["image_url"] ?? "",
                "link" => Constants::SITE_URL . "/view?id=" . $item["id"],
                "date" => isset($item["created_at"]) ? date("F d, Y", strtotime($item["created_at"])) : "",
                "id" => $item["id"] ?? "",
                "isFeatured" => $item["featured"] ?? false,
                "reads" => $item["views"] ?? "",
                "description" => self::generateExcerpt($item["description"] ?? "", 90) ?? "",
                "admin_article_link" => Constants::SITE_URL . "/admin/manage?id=" . $item["id"],
                "thumbnail" => $item["thumbnail"] ?? "",
                "altText" => $item["alt_text"] ?? "",
                "duration" => $item["duration"] ?? "",
                "videoSrc" => $item["video_file"] ?? "",
            ];
        }

        return $transformedData;
    }

    /**
     * Transforms event data from the database format to the desired object-like format.
     *
     * @param array $data The input data from the database.
     * @return array The transformed data.
     */
    public static function transformEventData(array $data): array
    {
        $transformedData = [];

        foreach ($data as $item) {
            $transformedData[] = [
                "id" => $item["id"] ?? "",
                "title" => $item["title"] ?? "",
                "image" => $item["image_url"] ?? "",
                "description" => self::generateExcerpt($item["description"], 90) ?? "",
                "date" => isset($item["date"]) ? date("F d, Y", strtotime($item["date"])) : "",
                "link" => Constants::SITE_URL . "/view_event.php?id=" . $item["id"],
                "location" => $item["location"],
            ];
        }

        return $transformedData;
    }

    /**
     * Checks if the user is authenticated.
     * Starts the session if it hasn't already been started.
     *
     * @return bool True if authenticated, false otherwise.
     */
    public static function isAuthenticated(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['is_loged_in']) && $_SESSION['is_loged_in'] === true;
    }


    /**
     * Formats a number into "k", "m", or "b" notation (e.g., 1000 -> 1k, 1000000 -> 1m, 1000000000 -> 1b).
     *
     * @param int|float $number The number to format.
     * @param int $precision The number of decimal places to include (default is 0).
     *
     * @return string The formatted number in "k", "m", or "b" notation.
     */
    public static function formatNumber($number, $precision = 0): string
    {
        if ($number >= 1_000_000_000) {
            $formatted = round($number / 1_000_000_000, $precision) . 'b';
        } elseif ($number >= 1_000_000) {
            $formatted = round($number / 1_000_000, $precision) . 'm';
        } elseif ($number >= 1_000) {
            $formatted = round($number / 1_000, $precision) . 'k';
        } else {
            $formatted = (string)$number;
        }

        return $formatted;
    }
}
