<?php
    class Router{
        private $routes = [];

        public function get($uri,$callback){
            $this->routes['GET'][$uri] = $callback;
        }
        public function post($uri,$callback){
            $this->routes['POST'][$uri] = $callback;
        }
        public function resolve()
    {
    $method = $_SERVER['REQUEST_METHOD'];

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $basePath = '/habittracker/public';

    $uri = str_replace($basePath, '', $uri);

    if ($uri === '') {
        $uri = '/';
    }

    if (isset($this->routes[$method][$uri])) {

        $callback = $this->routes[$method][$uri];

        if (is_array($callback)) {

            $controller = new $callback[0];

            $action = $callback[1];

            $controller->$action();

            return;
        }

        call_user_func($callback);

        return;
    }

    http_response_code(404);

    echo "404 Page Not Found";
    }
}
?>