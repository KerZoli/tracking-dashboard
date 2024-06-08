<?php

namespace App;

class Router {
    private array $routes = [];

    public function add($route, $callback): void
    {
        $this->routes[$route] = $callback;
    }

    public function call($uri): void
    {
        if (array_key_exists($uri, $this->routes)) {
            //Call controller method
            call_user_func($this->routes[$uri]);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}