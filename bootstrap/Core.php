<?php

namespace Bootstrap;


use App\Controllers\MiddlewaresTrait;

class Core
{
    use MiddlewaresTrait;

    public $url;
    public $controller = 'IndexController';
    public $method = 'index';
    public $params = [];

    public function __construct()
    {

        $this->url = $_GET['url'] ?? '';
        $this->url = explode('/', rtrim($this->url, '/'));

        // TODO: implement 404 scenario.

        $this->controller = $this->determineController();

        $this->determineMethod();

        $this->callController();
    }

    private function determineController()
    {
        $controller = ucfirst($this->url[0]) . 'Controller';
        if (file_exists(ROOT . '/app/controllers/' . $controller . '.php')) {
            $this->controller = $controller;
        }

        $controller = "App\\Controllers\\{$this->controller}";
        if (class_exists($controller))
            return new $controller;
        die("class $controller does not exists.");
    }

    private function determineMethod()
    {
        if (isset($this->url[1])) {
            if (method_exists($this->controller, $this->url[1])) {
                $this->method = $this->url[1];
            }
        }
    }

    private function callController()
    {
        unset($this->url[0]);
        unset($this->url[1]);

        $this->callMiddleware();

        $this->params = $this->url ? array_values($this->url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function callMiddleware()
    {
        if (property_exists($this->controller, 'middleware') &&
            method_exists($this->controller, $m = $this->controller->middleware)) {
            $this->controller->{$m}();
        }
    }
}