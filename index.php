<?php

use App\Controllers\PageViewController;
use App\Controllers\TrackingController;
use App\Router;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
Dotenv::createImmutable(__DIR__)->load();

$router = new Router();
$router->add('/', [new PageViewController(), 'index']);
$router->add('/tracking', [new TrackingController(), 'index']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->call($uri);
