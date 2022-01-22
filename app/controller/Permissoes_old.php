<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\PermissoesModel;

class Permissoes_old extends Controller {
  private $permissoes;
  public function index() {
    $this->view('permissoes/permissoes');
  }

  public function create() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if($_POST['controller']) {
        $this->permissoes = new PermissoesModel();
        $this->permissoes->save($_POST);
      }
    }
    $this->view('permissoes/permissoesadd');
  }
}
