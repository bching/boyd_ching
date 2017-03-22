<?php declare(strict_types = 1);

namespace MyProject;

use Http\HttpRequest;
use Http\HttpResponse;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

/**
 * Register the error handler
 */
$whoops = new \Whoops\Run;
if($environment !== 'production') {
  $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} 
else {
  $whoops->pushHandler(function($e) {
    echo 'TODO: Friendly error page and send an email to developmer';
  });
}
$whoops->register();

/*
 * Set HttpRequest and HttpResponse
 */
$request = new \Http\HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
$response = new \Http\HttpResponse;

/*
 * Import routes to the application
 */
$routeDefinitionCallback = function(\FastRoute\RouteCollector $r) {
  $routes = include('Routes.php');
  foreach($routes as $route) {
    $r->addRoute($route[0], $route[1], $route[2]);
  }
};

$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback); 
/*
{
  $r->addRoute('GET', '/hello-world', function() {
    echo 'Hello World';
  });
  $r->addRoute('GET', '/another-route', function() {
    echo 'This too';
  });
});
 */

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
switch($routeInfo[0]) {
  case \FastRoute\Dispatcher::NOT_FOUND:
    $response->setContent('404 - Page not found');
    $response->setStatusCode(404);
    break;
  case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $response->setContent('405 - Method not allowed');
    $response->setStatusCode(405);
    break;
  case \FastRoute\Dispatcher::FOUND:
    $className = $routeInfo[1][0];
    $method = $routeInfo[1][1];
    $vars = $routeInfo[2];

    $class = new $className;
    $class->$method($vars);
    break;
}

$content = '<h1>Hello World</h1>';
$response->setContent($content);

foreach($response->getHeaders() as $header) {
  /* Second parameter is false, otherwise existing headers will be overwritten */
  header($header, false);
}

echo $response->getContent();
