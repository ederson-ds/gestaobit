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

  public function validacoes() {
    $dados['camposInvalidos'] = $this->verificaCamposInvalidos();
    $dados['camposVazios'] = $this->verificaCamposVazios($this->requiredFields);
    return $dados;
  }

  public function postSave($dados, $model, $insertOuUpdate) {
    $dados['objeto'] = ($model->id) ? $model->getOne($model->id) : "";

    if ($insertOuUpdate && $model->id) {
      $dados['sucessoMsg'] = "Atualizado com sucesso!";
    } else if ($insertOuUpdate && !$model->id) {
      $dados['sucessoMsg'] = "Inserido com sucesso!";
    }
    return $dados;
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
