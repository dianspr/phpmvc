<?php

class App
{
  protected $controller = 'Home';
  protected $method = 'index';
  protected $params = [];


  public function __construct()
  {
    $url = $this->parseURL();

    //controller
    if (is_file('../app/controllers/' . $url[0] . '.php')) {
      $this->controller = $url[0];
      unset($url[0]);
    }
    require_once '../app/controllers/' . $this->controller . '.php';
    $this->controller = new $this->controller;
    // var_dump($url);

    //method
    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {
        $this->method = $url[1];
        unset($url[1]);
        // var_dump($url);
      }
    }

    //params
    if (!empty($url)) {
      $this->params = array_values($url);
      // var_dump($url);
    }

    //jalankan controller & method, serta kirimkan params jika ada
    call_user_func_array([$this->controller, $this->method], $this->params);
    // var_dump($url);

  }

  public function parseURL()
  {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
  }
}
