<?php
use FastRoute\Dispatcher;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PhpBlog\Core\Config;


require_once __DIR__ . '/../vendor/autoload.php';

$request = Request::createFromGlobals();

//init smarty
$smarty = new Smarty();
$smarty->setTemplateDir('/var/www/php-blog/views/templates/');
$smarty->setCompileDir('/var/www/php-blog/views/templates_c/');
$smarty->setConfigDir('/var/www/php-blog/views/configs/');
$smarty->setCacheDir('/var/www/php-blog/views/cache/');


$container = new Container();
$container
    ->add('Twig_Environment')
    ->withArgument(
        new Twig_Loader_Filesystem(__DIR__ . '/../views/')
    );

$container->add('Smarty');

$container
    ->delegate(
    // Auto-wiring based on constructor typehints.
    // http://container.thephpleague.com/auto-wiring
        new ReflectionContainer()
    );

//routes
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $routes = require __DIR__ . '/routes.php';
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
});


//dispatch
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        // No matching route was found.
        Response::create("404 Not Found", Response::HTTP_NOT_FOUND)
            ->prepare($request)
            ->send();
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        // A matching route was found, but the wrong HTTP method was used.
        Response::create("405 Method Not Allowed", Response::HTTP_METHOD_NOT_ALLOWED)
            ->prepare($request)
            ->send();
        break;
    case Dispatcher::FOUND:
        // Fully qualified class name of the controller
        $fqcn = $routeInfo[1][0];
        // Controller method responsible for handling the request
        $routeMethod = $routeInfo[1][1];
        // Route parameters (ex. /products/{category}/{id})
        $routeParams = $routeInfo[2];

        // Obtain an instance of route's controller
        // Resolves constructor dependencies using the container
        $controller = $container->get($fqcn);

        // Generate a response by invoking the appropriate route method in the controller
        $response = $controller->$routeMethod($routeParams);
        if ($response instanceof Response) {
            // Send the generated response back to the user
            $response
                ->prepare($request)
                ->send();
        }
        break;
    default:
        // According to the dispatch(..) method's documentation this shouldn't happen.
        // But it's here anyways just to cover all of our bases.
        Response::create('Received unexpected response from dispatcher.', Response::HTTP_INTERNAL_SERVER_ERROR)
            ->prepare($request)
            ->send();
        return;
}

