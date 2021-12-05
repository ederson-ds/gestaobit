<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\FormaPagamentoModel;

class Formapagamento extends Controller {
  private $formaPagamento;
  public function index() {
    $this->view('contasapagar/contasapagar');
  }

  public function create() {
    $this->view('contasapagar/contasapagaradd');
  }

  public function get() {
    $query = $_POST['query'] ?? "";
    $this->formaPagamento = new FormaPagamentoModel();
    $listFormaPagamento = $this->formaPagamento->get($query);
    echo json_encode($listFormaPagamento);
  }
}
