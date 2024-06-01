<?php

// routing app happens
class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    // php will automatically call this function when create an object from a class
    public function __construct()
    {
        $url = $this->parseUrl();

        // controller
        if (isset($url[0]) && file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        // call the controller
        require_once '../app/controllers/' . $this->controller . '.php';
        // instansiasi agar bisa mengambil methodnya
        $this->controller = new $this->controller;

        // method
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // params
        $this->params = $url ? array_values($url) : [];

        // jalankan controller dan menthod serta kirimkan array jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            //removes white space or other predefined characters from the right side of a string
            $url = rtrim($_GET['url'], '/');
            // first remove ilegal characters from $url, then check if it's a valid url address
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // breaks a string into an array
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
