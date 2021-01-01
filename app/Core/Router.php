<?php

namespace App\Core;

class Router
{
    protected array $routes = [];
    protected array $params = [];

    /**
     * @param $route
     * @param array $params
     */
    function add($route, $params = [])
    {
        $route = preg_replace('/\//', '\\/', $route);
        $this->routes[$route] = $params;
    }

    /**
     * @param $string
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * @param $string
     * @return string|string[]
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }

    /**
     * @param $path
     * @return bool
     */
    public function match($path)
    {
        foreach ($this->routes as $route => $params) {
            if ($path === $route) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     *
     */
    public function dispatch()
    {
        $req = new Request();
        $path = $req->getPath();
        $pathFirstPart = explode('/', $path);
        $pathFirstPart = count($pathFirstPart) > 0 ? $pathFirstPart[0] : 'base';
        if ($this->match($pathFirstPart)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;
            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action(new Request());
                }
            }
        }
        http_response_code(404);
    }
}