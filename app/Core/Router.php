<?php

class Router
{
    private array $routes = [];

    public function get(
        string $path,
        array $action,
        array $middleware = []
    ): void {
        $this->routes['GET'][$path] = [
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public function post(
        string $path,
        array $action,
        array $middleware = []
    ): void {
        $this->routes['POST'][$path] = [
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $uri = parse_url(
            $_SERVER['REQUEST_URI'] ?? '/',
            PHP_URL_PATH
        );

        $uri = preg_replace(
            '#^/(?:Individual/)?(?:php-basic-mvc|php-mvc)(?:/public)?#',
            '',
            $uri
        );

        $uri = '/' . trim($uri, '/');

        if ($uri === '//') {
            $uri = '/';
        }

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo '404 - Page Not Found';
            return;
        }

        $route = $this->routes[$method][$uri];

        /*
        |--------------------------------------------------------------------------
        | Middleware
        |--------------------------------------------------------------------------
        */
        foreach ($route['middleware'] as $middleware) {
            $middlewareInstance = new $middleware();
            $middlewareInstance->handle();
        }

        /*
        |--------------------------------------------------------------------------
        | Controller
        |--------------------------------------------------------------------------
        */
        [
            $controller,
            $methodName
        ] = $route['action'];

        $controllerInstance = new $controller();
        $controllerInstance->$methodName();
    }
}

