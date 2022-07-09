<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\LoginModel;

class Login extends Controller {
  private $login;
  public $controller = "login";
  public function __construct()
  {
    parent::__construct();
    $this->model = new LoginModel();
  }

  public function index() {
    $dados['invalidUser'] = false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $senha = $_POST['senha'];
      $dados['email'] = $email;
      if($email == "" || $senha == "") {
        $dados['invalidUser'] = "Email ou senha são obrigatórios";
        $this->rawView('login/login', $dados);
        die;
      }
      $this->login = new LoginModel();
      $loginResult = $this->login->login($email, $senha);
      if($loginResult) {
        $_SESSION['login'] = true;
        if($loginResult->contapai) {
          $_SESSION['login_id'] = $loginResult->id;
        } else {
          $_SESSION['login_id'] = $loginResult->login_id;
        }
        $_SESSION['usuario_id'] = $loginResult->id;
        $_SESSION['email'] = $loginResult->email;
        $_SESSION['senha'] = $loginResult->senha;
        //$_SESSION['telas'] = json_encode($this->login->getTelas($loginResult->id));
        header("Location: ".URL."/");
        exit();
      } else {
        $dados['invalidUser'] = "Email ou senha incorretos";
      }
    }
    $this->rawView('login/login', $dados);
  }

  public function cadastrar() {
    $dados['error'] = false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $senha = $_POST['senha'];
      $resenha = $_POST['resenha'];
      $this->login = new LoginModel();
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $dados['error'] = "Email inválido";
      } else if($this->login->findEmail($email)) {
        $dados['error'] = "Email já existe";
      } else if(strlen($senha) < 6) {
        $dados['error'] = "A senha precisa ter mais que 5 caracteres";
      } else if($senha != $resenha) {
        $dados['error'] = "A senha e a confirmação de senha não conferem";
      } else {
        $this->login = new LoginModel();
        $login_id = $this->login->cadastrar($email, $senha);
        $_SESSION['login'] = true;
        $_SESSION['login_id'] = $login_id;
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        header("Location: ".URL."/");
        exit();
      }
    }
    $this->rawView('login/cadastrar', $dados);
  }

  public function get()
  {
    $query = $_POST['query'] ?? "";
    echo json_encode($this->model->get($query));
  }
}
