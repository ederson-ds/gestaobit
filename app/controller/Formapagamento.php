<?php

namespace App\controller;

use App\libraries\Controller;
use App\models\FormaPagamentoModel;

class Formapagamento extends Controller
{
  private $formaPagamento;
  public $controller = "formapagamento";
  public function index()
  {
    $this->view('formapagamento/formapagamento');
  }

  public function create($id = 0)
  {
    parent::permissaoCadastrarEditar($id);
    $this->formaPagamento = new FormaPagamentoModel();
    $this->formaPagamento->id = $id;
    $this->requiredFields = ['descricao'];
    $dados = parent::validacoes();

    $insertOuUpdate = $this->formaPagamento->save($dados);

    $dados = parent::postSave($dados, $this->formaPagamento, $insertOuUpdate);

    $this->view('formapagamento/formapagamentoadd', $dados);
  }

  public function delete($id = 0)
  {
    parent::permissaoDelete();
    if ($id) {
      $this->formaPagamento = new FormaPagamentoModel();
      $this->formaPagamento->delete($id);
    }
    header("Location: " . URL . "/". $this->controller);
    die();
  }

  public function list()
  {
    $requestData = $_REQUEST;

    $columns = array(
      array('0' => 'descricao'),
    );

    $this->formaPagamento = new FormaPagamentoModel();
    $numRows = $this->formaPagamento->numRows();
    $dados = $this->formaPagamento->list($columns[$requestData['order'][0]['column']][0], $requestData['order'][0]['dir'], $requestData['search']['value'], $requestData['start'], $requestData['length']);
    $json_data = array(
      "draw" => intval($requestData['draw']),
      "recordsTotal" => intval($numRows),
      "recordsFiltered" => intval(sizeof($dados)),
      "data" => $dados
    );
    echo json_encode($json_data);
  }

  public function get()
  {
    $query = $_POST['query'] ?? "";
    $this->formaPagamento = new FormaPagamentoModel();
    echo json_encode($this->formaPagamento->get($query));
  }
}
