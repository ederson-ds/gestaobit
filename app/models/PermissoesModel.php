<?php

namespace App\models;
use App\libraries\Model;
use \R;
class PermissoesModel extends Model {

  public function save($postRequests) {
    $permissoes = R::dispense('permissoes');
    $permissoes->controller = $postRequests['controller'];
    $permissoes->visualizar = 1;
    $permissoes->editar = 1;
    $permissoes->excluir = 1;
    $permissoes->login = R::load('login', $_SESSION['login_id']);
    R::store($permissoes);
  }

}
