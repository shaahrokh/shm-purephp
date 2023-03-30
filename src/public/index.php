<?php

declare(strict_types = 1);

use App\Controller\ContentController;
use App\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router
	->get('/', function(){ echo "Hello World!";})
	->get('/blog', [ContentController::class, 'index']);

$router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);