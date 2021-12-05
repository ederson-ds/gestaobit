<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\LoginModel;

class Login extends Controller {
  private $login;
  public function index() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $senha = $_POST['senha'];
      $this->login = new LoginModel();
      $loginResult = $this->login->login($email, $senha);
      if($loginResult) {
        $_SESSION['login'] = true;
        $_SESSION['login_id'] = $loginResult->id;
        $_SESSION['email'] = $loginResult->email;
        $_SESSION['senha'] = $loginResult->senha;
        $_SESSION['telas'] = json_encode($this->login->getTelas($loginResult->id));
        header("Location: ".URL."/");
        exit();
      }
    }
    $this->view('login/login');
  }

  public function cadastrar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $senha = $_POST['senha'];
      $this->login = new LoginModel();
      $login_id = $this->login->cadastrar($email, $senha);
      $_SESSION['login'] = true;
      $_SESSION['login_id'] = $login_id;
      $_SESSION['email'] = $email;
      $_SESSION['senha'] = $senha;
      header("Location: ".URL."/");
      exit();
    }
    $this->view('login/cadastrar');
  }
}
