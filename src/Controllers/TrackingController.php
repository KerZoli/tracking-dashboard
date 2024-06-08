<?php

namespace App\Controllers;

use App\Services\TrackingService;

class TrackingController
{
    private TrackingService $trackingService;
    public function __construct(TrackingService $trackingService = null)
    {
        $this->trackingService = $trackingService ?: new TrackingService();
    }

    public function index(): void
    {
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: image/gif');

        $filters = [
            'client_id' => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH],
            'visitor_id' => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH],
            'pathname' => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH]
        ];
        $queryParams = filter_input_array(INPUT_GET, $filters);

        //transparent gif image
        $gif = base64_decode('R0lGODlhAQABAPAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');

        if (!isset($queryParams['client_id'])
            || !isset($queryParams['visitor_id'])
            || !isset($queryParams['pathname'])
            || !$this->trackingService->checkIfClientExists($queryParams['client_id'])
        ) {
            echo $gif;
            exit;
        }

        $this->trackingService->createPageView($queryParams['client_id'], $queryParams['visitor_id'], $queryParams['pathname']);

        echo $gif;
    }
}