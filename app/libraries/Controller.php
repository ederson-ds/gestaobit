<?php

namespace App\libraries;

use App\helpers\Htmlhelper;

class Controller
{
  public $model;
  protected $controller = null;
  public $tela = null;
  public $requiredFields = [];

  public function __construct()
  {
    foreach (json_decode($_SESSION['telas']) as $key => $tela) {
      if (strtolower($tela->controller) == $this->controller) {
        $this->tela = $tela;
      }
    }
  }

  public function list()
  {
    $requestData = $_REQUEST;

    $arrayFields = [];
    foreach ($this->model->fields as $key => $field) {
      array_push($arrayFields, array($key => $field));
    }
    $columns = $arrayFields;

    $orderColumn = $columns[$requestData['order'][0]['column']][array_key_first($columns[$requestData['order'][0]['column']])];
    $numRows = $this->model->numRows();
    $dados = $this->model->list($orderColumn, $requestData['order'][0]['dir'], $requestData['search']['value'], $requestData['start'], $requestData['length']);
    $json_data = array(
      "draw" => intval($requestData['draw']),
      "recordsTotal" => intval($numRows),
      "recordsFiltered" => intval(sizeof($dados)),
      "data" => $dados
    );
    echo json_encode($json_data);
  }

  public function permissaoCadastrarEditar($id)
  {
    if (!$this->tela->cadastrar && !$id) {
      die("Você não tem permissão para cadastrar nesta tela");
    } else if (!$this->tela->editar && $id) {
      die("Você não tem permissão para editar nesta tela");
    }
  }

  public function permissaoDelete()
  {
    if (!$this->tela->excluir) {
      die("Você não tem permissão para excluir nesta tela");
    }
  }

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
        if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST[$key])) {
          array_push($camposInvalidos, $key);
        }
      }
    }
    return $camposInvalidos;
  }

  public function validacoes()
  {
    $dados['camposInvalidos'] = $this->verificaCamposInvalidos();
    $dados['camposVazios'] = $this->verificaCamposVazios($this->requiredFields);
    return $dados;
  }

  public function postSave($dados, $model, $insertOuUpdate)
  {
    $dados['objeto'] = ($model->id) ? $model->getOne($model->id) : "";

    if ($insertOuUpdate && $model->id) {
      $dados['sucessoMsg'] = "Atualizado com sucesso!";
    } else if ($insertOuUpdate && !$model->id) {
      $dados['cadastrado'] = true;
      $dados['sucessoMsg'] = "Inserido com sucesso!";
    }
    return $dados;
  }

  public function delete($id = 0)
  {
    $this->permissaoDelete();
    if ($id) {
      $this->model->delete($id);
    }
    header("Location: " . URL . "/". $this->controller);
    die();
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
