<?php

namespace App\models;
use App\libraries\Model;
use \R;
class LoginModel extends Model {

  public function login($email, $senha) {
    $login = R::findOne('login', 'email = ? and senha = ?', [$email, $senha]);
    return $login;
  }

  public function cadastrar($email, $senha) {
    $login = R::dispense('login');
    $login->email = $email;
    $login->senha = $senha;
    return R::store($login);
  }

  public function findEmail($email) {
    return R::findOne('login', 'email = ?', [$email]);
  }

  public function getTelas($idLogin) {
    $telas = R::find("permissoes", "login_id = ? ", [$idLogin]);
    return $telas;
  }

}
