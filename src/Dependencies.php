<?php declare(strict_types = 1);

$injector = new \Auryn\Injector;

/* 
 * Tells injector class to inject an instance of Http\HttpRequest any time 
 * it encounters an Http\Request type-hint
 */
$injector->alias('Http\Request', 'Http\HttpRequest');

/*
 * Store Http\HttpRequest in injector's shared cache and all future
 * requests to provider for an injected instance return originally
 * created object
 */
$injector->share('Http\HttpRequest');
$injector->define('Http\HttpRequest', [
  ':get' => $_GET,
  ':post' => $_POST,
  ':cookies' => $_COOKIE,
  ':files' => $_FILES,
  ':server' => $_SERVER,
]);

$injector->alias('Http\Response', 'Http\HttpResponse');
$injector->share('Http\HttpResponse');

$injector->alias('MyProject\Template\Renderer', 'MyProject\Template\TwigRenderer');
/*
 * Rename .mustache extension to .html for compatibility with other template engines
 * Load Mustache from templates folder in root directory
 */
//$injector->define('Mustache_Engine', [
//  ':options' => [
//    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/templates', [
//    'extension' => '.html',
//    ]),
//  ],
//]);

/*
 * __DIR__ points to .../boyd_ching/public
 */
$injector->delegate('Twig_Environment', function () use ($injector) {
  $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/templates');
  $twig = new Twig_Environment($loader);
  return $twig;
});

/*
 * Set path of pageFolder directory
 */
//$injector->define('MyProject\Page\FilePageReader', [
//  ':pageFolder' => __DIR__ . '/../pages',
//]);
$injector->define('MyProject\Page\FilePageReader', [
  ':pageFolder' => __DIR__ . '/../pages',
]);
$injector->alias('MyProject\Page\PageReader', 'MyProject\Page\FilePageReader');
$injector->share('MyProject\Page\FilePageReader');

$injector->alias('MyProject\Template\FrontendRenderer', 'MyProject\Template\FrontendTwigRenderer');

$injector->alias('MyProject\Menu\MenuReader', 'MyProject\Menu\ArrayMenuReader');
$injector->share('MyProject\Menu\ArrayMenuReader');

return $injector;
