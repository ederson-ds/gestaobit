<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\EmailsModel;
use App\models\TelasModel;
use App\models\PermissoesModel;

class Emails extends Controller {
  public $controller = "emails";
  public $telasModel;

  public function __construct()
  {
    parent::__construct();
    $this->model = new EmailsModel();
  }

  public function index() {
    $this->view('emails/emails');
  }

  public function create($id = 0) {
    parent::permissaoCadastrarEditar($id);
    $this->model->id = $id;
    $this->requiredFields = ['email', 'senha'];
    $dados = parent::validacoes();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if(array_search("email", $dados['camposVazios']) !== 0) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          array_push($dados['camposInvalidos'], "email");
        } else {
          $dados['erro'] = $this->model->verificaMesmoEmail($dados['erro'], $id, $_POST['email']);
        }
      }
    }

    if($id) {
      $telasModel = new TelasModel();
      $dados['listTelas'] = $telasModel->getPermissoes($id);
    }

    $insertOuUpdate = $this->model->save($dados);

    $dados = parent::postSave($dados, $this->model, $insertOuUpdate);

    $this->view('emails/emailsadd', $dados);
  }

  public function liberarOuBloquear() {
    $acao = $_POST['acao'];
    $permissoes_id = $_POST['permissoes_id'];
    $liberarOuBloquear = $_POST['liberarOuBloquear'];
    $telas_id = $_POST['telas_id'];
    $usuario_id = $_POST['usuario_id'];
    if($acao == "visualizar" || $acao == "cadastrar" || $acao == "editar" || $acao == "excluir") {
      $permissoes = new PermissoesModel();
      $permissoes_id = $permissoes->liberarOuBloquear($acao, $permissoes_id, $liberarOuBloquear, $telas_id, $usuario_id);
    }

    echo json_encode(array("permissoes_id" => $permissoes_id));
  }
}
