<?php
 
declare(strict_types=1);

$uri = $_SERVER['REQUEST_URI'];

// require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/vendor/autoload.php';


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\ErrorHandler\Debug;
use League\Route\Http\Exception\NotFoundException;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;

Debug::enable();

if(str_contains($uri, '.css') || str_contains($uri, '.js') || str_contains($uri, '.png') || str_contains($uri, '.jpg') || str_contains($uri, '.jpeg') || str_contains($uri, '.gif') || str_contains($uri, '.webp')) {
    return false;
}

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

session_start();

$router = new League\Route\Router;

// default routes 
$router->map('GET', '/', App\Controller\HomeController::class);
$router->map('GET', '/404', [App\Controller\HomeController::class, 'error']);

// login and registration routes
$router->map('POST', '/login', [App\Controller\HomeController::class, 'login']);
$router->map('GET', '/login', [App\Controller\HomeController::class, 'login']);
$router->map('POST', '/register', [App\Controller\HomeController::class, 'register']);
$router->map('GET', '/register', [App\Controller\HomeController::class, 'register']);

// profile routes
$router->map('GET', '/profile', [App\Controller\HomeController::class, 'profile']);
$router->map('GET', '/logout', [App\Controller\HomeController::class, 'logout']);

try {
    $response = $router->dispatch($request);
} catch (NotFoundException $e) {
    $response = new RedirectResponse('/404');
}

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);