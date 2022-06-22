<?php

namespace App;


use Controllers\MiddlewaresTrait;

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

        $this->controller = $this->determineController();

        $this->determineMethod();

        $this->callController();
    }

    private function determineController() // TODO: change all methods and properties access level to minimum possible level.
    {
        $controller = ucfirst($this->url[0]) . 'Controller';
        if (file_exists(ROOT . '/controllers/' . $controller . '.php')) {
            $this->controller = $controller;
        }

        $controller = "Controllers\\{$this->controller}";
        return new $controller;
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