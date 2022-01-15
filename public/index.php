<?php
  require __DIR__ . '/../vendor/autoload.php';
  use App\libraries\Rota;
  use App\libraries\Environment;

  Environment::load(dirname(__DIR__));

  include('../app/config.php');
  session_start();
  $url = explode('/', $_SERVER['REQUEST_URI']);
  if($url[1] == "gestaobit") {
    unset($url[1]);
    $url = array_values($url);
  }
  $controller = false;
  if(!$url[1] || $url[1] == 'logout') {
    $controller = true;
  } else {
    if(isset($_SESSION['telas'])) {
      foreach (json_decode($_SESSION['telas']) as $tela) {
        if($url[1] == strtolower($tela->controller) || $url[1] == 'logout') {
          $controller = true;
        }
      }
    }
  }
  if(!isset($_SESSION['login']) && $url[1] != 'login') {
    header("Location: ".URL."/login");
    exit();
  } else {
    if(isset($_SESSION['login']) && !$controller && $url[1] != 'paginas') {
      header("Location: ".URL."/paginas/erro404");
      exit();
    }
  }
  $rotas = new Rota();
