<?php
session_start();
require_once '../vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;

$router = Router::getInstance();
require_once '../app/Config/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($uri);