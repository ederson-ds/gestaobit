<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\ContasapagarModel;
use App\models\EmailsModel;

class Emails extends Controller {
  public $controller = "emails";

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
      echo array_search("email", $dados['camposVazios']);
      if(array_search("email", $dados['camposVazios']) !== 0) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          array_push($dados['camposInvalidos'], "email");
        }
      }
    }

    $insertOuUpdate = $this->model->save($dados);

    $dados = parent::postSave($dados, $this->model, $insertOuUpdate);

    $this->view('emails/emailsadd', $dados);
  }
}
