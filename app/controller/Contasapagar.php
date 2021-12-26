<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\ContasapagarModel;

class Contasapagar extends Controller {
  public $controller = "contasapagar";

  public function __construct()
  {
    parent::__construct();
    $this->model = new ContasapagarModel();
  }

  public function index() {
    $this->view('contasapagar/contasapagar');
  }

  public function create($id = 0) {
    parent::permissaoCadastrarEditar($id);
    $this->model->id = $id;
    $this->requiredFields = ['descricao', 'vencimento', 'formapagamento_id'];
    $dados = parent::validacoes();

    $insertOuUpdate = $this->model->save($dados);

    $dados = parent::postSave($dados, $this->model, $insertOuUpdate);

    $this->view('contasapagar/contasapagaradd', $dados);
  }
}
