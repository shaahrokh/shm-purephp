<?php

declare(strict_types = 1);

use App\App;
use App\Config;
use App\Controller\ContentController;
use App\Controller\UserController;
use App\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router
	->get('/', function(){ echo "Hello World!";})
	->get('/blog', [ContentController::class, 'index'])
	->get('/users', [UserController::class, 'index'])
;

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config(),
))->run();