<?php
namespace App\Core;

class Router {
    private static $instance = null;
    private $routes = [];
    private $params = [];

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function add($route, $controller, $action, $method = 'GET') {
        // Convert route to regex
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[0-9]+)', $route);
        $route = str_replace('/', '\/', $route);
        $route = '/^' . $route . '$/i';
        
        $this->routes[$method][$route] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($url) {
        $url = $this->removeQueryStringVariables($url);
        $method = $_SERVER['REQUEST_METHOD'];

        if ($this->match($url, $method)) {
            $controller = "App\\Controllers\\" . $this->params['controller'];
            $action = $this->params['action'];
            
            if (class_exists($controller)) {
                $controller_object = new $controller();
                if (method_exists($controller_object, $action)) {
                    return $controller_object->$action($this->params);
                }
            }
        }
        throw new \Exception('No route matched.');
    }

    private function match($url, $method) {
        foreach ($this->routes[$method] ?? [] as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    private function removeQueryStringVariables($url) {
        if ($url !== '') {
            $parts = explode('?', $url, 2);
            $url = $parts[0];
        }
        return $url;
    }
}