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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if($_POST['usuario_id'] && $_POST['telas_id']) {
        $dados['camposInvalidos'] = $this->model->verificaMesmoUsuarioETela($dados['camposInvalidos'], $_POST['usuario_id'], $_POST['telas_id']);
      }
    }

    $insertOuUpdate = $this->model->save($dados);

    $dados = parent::postSave($dados, $this->model, $insertOuUpdate);

    $this->view('permissoes/permissoesadd', $dados);
  }
}
