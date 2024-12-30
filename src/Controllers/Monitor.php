<?php

namespace Muswalo\NurseTendiaBlog\Controllers;

use Muswalo\NurseTendiaBlog\Utils\Utils;
use Muswalo\NurseTendiaBlog\Controllers\Controllers;

class Monitor
{
    private Controllers $controller;
    private string $metricCookieName = 'metric_id';

    public function __construct()
    {
        $this->controller = new Controllers();
    }


    public function monitor(): void
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $metricId = Utils::getCookie($this->metricCookieName);


        if (!$metricId) {
            $metricId = $this->controller->createMetric(null);

            $expiry = time() + (86400 * 30);
            setcookie($this->metricCookieName, $metricId, $expiry, "/");
        }

        if (!isset($_SESSION['metric_id'])) {

            $_SESSION['metric_id'] = $metricId;


            try {
                $this->controller->incrementTimesVisited ($metricId);
            } catch (\PDOException $e) {
                error_log("Database Error: " . $e->getMessage()); 
            }
        }

    }
}

