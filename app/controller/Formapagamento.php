<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\FormaPagamentoModel;

class Formapagamento extends Controller {
  private $formaPagamento;
  public function index() {
    $this->view('formapagamento/formapagamento');
  }

  public function create($id = 0) {
    $this->formaPagamento = new FormaPagamentoModel();
    $this->requiredFields = ['descricao'];
    $dados['camposInvalidos'] = parent::verificaCamposInvalidos();
    $dados['camposVazios'] = parent::verificaCamposVazios($this->requiredFields);
    $dados['formaPagamento'] = ($id) ? $this->formaPagamento->getOne($id) : "";
    
    if(!$dados['camposInvalidos'] && !$dados['camposVazios']) {
      $this->formaPagamento->save();
    }

    $this->view('formapagamento/formapagamentoadd', $dados);
  }

  public function get() {
    $query = $_POST['query'] ?? "";
    $this->formaPagamento = new FormaPagamentoModel();
    echo json_encode($this->formaPagamento->get($query));
  }
}
