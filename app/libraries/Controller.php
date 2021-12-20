<?php

namespace App\libraries;

use App\helpers\Htmlhelper;

class Controller
{
  public $requiredFields = [];

  private function endsWith($haystack, $needle)
  {
    $length = strlen($needle);
    if (!$length) {
      return true;
    }
    return substr($haystack, -$length) === $needle;
  }

  public function verificaCamposVazios($camposObrigatorios = [])
  {
    $camposVazios = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      foreach ($camposObrigatorios as $campo) {
        if (!$_POST[$campo]) {
          array_push($camposVazios, $campo);
        }
      }
    }
    return $camposVazios;
  }

  public function verificaCamposInvalidos()
  {
    $camposInvalidos = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      foreach ($_POST as $key => $campo) {
        if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST[$key])) {
          array_push($camposInvalidos, $key);
        }
      }
    }
    return $camposInvalidos;
  }

  protected function view($view, $dados = [])
  {
    $html = new Htmlhelper($dados, $this->requiredFields);
    $arquivo = ('../app/view/' . $view . '.php');
    if (file_exists($arquivo)) {
      include('../app/view/partials/header.php');
      if ($this->endsWith($arquivo, 'add.php')) {
        include('../app/view/partials/openform.php');
      }
      include($arquivo);
      if ($this->endsWith($arquivo, 'add.php')) {
        include('../app/view/partials/closeform.php');
      }
      include('../app/view/partials/footer.php');
    } else {
      die('O arquivo de view não existe!');
    }
  }
}
