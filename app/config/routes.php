<?php
use App\Core\Router;

$router = Router::getInstance();
$basePath = '/mvc_new/public';

// Auth Routes
$router->add('/mvc_new/public/login', 'AuthController', 'login', 'GET');
$router->add('/mvc_new/public/auth/login', 'AuthController', 'authenticate', 'POST');
$router->add('/mvc_new/public/register', 'AuthController', 'register', 'GET');
$router->add('/mvc_new/public/auth/register', 'AuthController', 'store', 'POST');
$router->add('/mvc_new/public/logout', 'AuthController', 'logout', 'GET');
$router->add('/mvc_new/public/forgot-password', 'AuthController', 'forgotPassword', 'GET');

// Post Routes
$router->add($basePath . '/', 'PostController', 'index', 'GET');
$router->add($basePath . '/posts', 'PostController', 'index', 'GET');
$router->add('/mvc_new/public/posts/create', 'PostController', 'create', 'GET');
$router->add('/mvc_new/public/posts/store', 'PostController', 'store', 'POST');
$router->add($basePath . '/posts/{id}', 'PostController', 'show', 'GET');  
$router->add('/mvc_new/public/posts/{id}/edit', 'PostController', 'edit', 'GET');
$router->add('/mvc_new/public/posts/{id}/update', 'PostController', 'update', 'POST');
