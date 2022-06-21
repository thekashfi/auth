<?php

namespace App;


class Core
{
    public $controller = 'IndexController';
    public $method = 'index';
    public $params = [];

    public function __construct()
    {
        $url = explode('/', rtrim($_GET['url'], '/'));

        $controller = ucfirst($url[0]) . 'Controller';
        if (file_exists(ROOT . '/controllers/' . $controller . '.php')) {
            $this->controller = $controller;
        }

        $controller = "Controllers\\{$this->controller}";
        $this->controller = new $controller;
        unset($url[0]);

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
            }
            unset($url[1]);
        }
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}