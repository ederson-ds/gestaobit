<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\PermissoesModel;

class Permissoes extends Controller {
  public $controller = "permissoes";

  public function __construct()
  {
    parent::__construct();
    $this->model = new PermissoesModel();
  }

  public function index() {
    $this->view('permissoes/permissoes');
  }

  public function create($id = 0) {
    parent::permissaoCadastrarEditar($id);
    $this->model->id = $id;
    $this->requiredFields = ['usuario_id', 'telas_id'];
    $dados = parent::validacoes();

    $insertOuUpdate = $this->model->save($dados);

    $dados = parent::postSave($dados, $this->model, $insertOuUpdate);

    $this->view('permissoes/permissoesadd', $dados);
  }
}
