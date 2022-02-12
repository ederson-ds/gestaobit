<?php

namespace App\models;
use App\libraries\Model;
use \R;
class LoginModel extends Model {
  public $table = "login";

  public function login($email, $senha) {
    $login = R::findOne('login', 'email = ? and senha = ?', [$email, $senha]);
    return $login;
  }

  public function cadastrar($email, $senha) {
    $login = R::dispense('login');
    $login->email = $email;
    $login->senha = $senha;
    $login->contapai = 1;
    return R::store($login);
  }

  public function findEmail($email) {
    return R::findOne('login', 'email = ?', [$email]);
  }

  public function getTelas($usuario_id) {
    $sql = "
    SELECT cadastrar, editar, excluir, t.controller, t.nome, tpai.nome as telapainome, tpai.icon FROM permissoes c
    INNER JOIN telas t ON c.telas_id = t.id
    INNER JOIN telas tpai ON t.menupai_id = tpai.id
    WHERE c.login_id = ".$_SESSION['login_id']."
    AND usuario_id = ".$usuario_id;
    return R::getAll($sql);
  }

  public function get($query)
  {
    $listEmails = R::find($this->table, "email ILIKE ? AND contapai IS NULL AND login_id = ? LIMIT 10", ["%".$query."%", $_SESSION['login_id']]);
    $listEmails['field'] = "email";
    $listEmails['cadastrarNovo'] = false;
    return $listEmails;
  }

}
