<?php

namespace App\libraries;
use App\models\LoginModel;

class Rota {
  private $controller = 'Paginas';
  private $metodo = 'index';
  private $parametros = [];

  public function __construct() {
    $url = $this->url() ?? [0];

    if(file_exists('../app/controller/'.ucwords($url[0]).'.php')) {
      $this->controller = ucwords($url[0]);
      unset($url[0]);
    }

    $classe = "App\\controller\\".$this->controller;

    $this->controller = new $classe;

    if(isset($url[1])) {
      if(method_exists($this->controller, $url[1])) {
        $this->metodo = $url[1];
        unset($url[1]);
      }
    }

    $this->parametros = $url ? array_values($url) : [];
    if($this->metodo != 'view' && $this->metodo != 'endsWith') {
      if(isset($_SESSION['usuario_id'])) {
        $login = new LoginModel();
        $_SESSION['telas'] = json_encode($login->getTelas($_SESSION['usuario_id']));
      }
      call_user_func_array([$this->controller, $this->metodo], $this->parametros);
    } else {
      $classe = "App\\controller\\Paginas";
      $this->controller = new $classe;
      call_user_func_array([$this->controller, 'erro404'], $this->parametros);
    }
  }

  public function url() {
    $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

    if(isset($url)) {
      $url = trim(rtrim($url, '/'));
      $url = explode('/', $url);
      return $url;
    }
  }
}
