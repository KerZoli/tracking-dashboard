<?php

namespace App\Controllers;

use App\Repositories\ClientRepository;
use App\Services\PageViewService;
use League\Plates\Engine;

class PageViewController
{
    private Engine $templateEngine;
    private PageViewService $pageViewService;
    private ClientRepository $clientRepository;
    public function __construct(
        Engine $templateEngine = null,
        PageViewService $pageViewService = null,
        ClientRepository $clientRepository = null
    )
    {
        $this->templateEngine = $templateEngine ?: new Engine('views');
        $this->pageViewService = $pageViewService ?: new PageViewService();
        $this->clientRepository = $clientRepository ?: new ClientRepository();
    }
    public function index(): void
    {
        $pageViews = $this->pageViewService->getUniqueVisitors($_GET);
        $clients = $this->clientRepository->clients();

        echo $this->templateEngine->render('pageviews', ['statistics' => $pageViews, 'clients' => $clients]);
    }
}