<?php

namespace App\libraries;

use \R;

require "rb-postgres.php";

class Model
{
  protected $fieldsName = [];
  protected $fields = [];
  protected $table = null;
  public $id = 0;

  public function save($dados)
  {
    if (!$dados['camposInvalidos'] && !$dados['camposVazios']) {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data[$this->table] = R::load($this->table, $this->id);
        $data[$this->table]->login = R::load("login", $_SESSION['login_id']);
        $achou = false;
        foreach ($_POST as $key => $campo) {
          foreach ($this->fields as $field) {
            if ($key == $field) {
              if($this->endsWith($field, "_id") && $campo) {
                $controller = substr($field, 0, -3);
                $data[$this->table]->$controller = R::load($controller, $campo);
              } else if($campo) {
                $data[$this->table]->$key = $campo;
              }
              $achou = true;
            }
          }
        }
        if ($achou) {
          R::store($data[$this->table]);
          return true;
        }
      }
    }
    return false;
  }

  public function delete($id)
  {
    R::trash($this->table, $id);
  }

  public function getOne($id)
  {
    if (!$id)
      $id = 0;
    return R::findOne($this->table, "id = ?", [$id]);
  }

  public function numRows()
  {
    return R::count($this->table, "login_id = ?", [$_SESSION['login_id']]);
  }

  public function __construct()
  {
    if (!R::testConnection()) {
      R::setup('pgsql:host=' . getenv('DB_HOST') . ';
          dbname=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'));
    }

    /*$tela = R::load("telas", 0);
    $tela->icon = "fa dollar";
    R::store($tela);*/
    /*$tela = R::load("telas", 0);
    $tela->controller = "";
    $tela->nome = "Cadastro";
    $tela->menupai = R::load("telas", 1);
    R::store($tela);*/
  /*  $tela = R::load("telas", 0);
    $tela->controller = "Contasapagar";
    $tela->nome = "Contas a pagar";
    R::store($tela);*/
    /*$login = R::load("login", 0);
    $login->contapai = 1;
    R::store($login);
*/
    /*$permissoes = R::load("permissoes", 0);
    $permissoes->permissoes = R::load("permissoes", 6);
    R::store($permissoes);*/
    /*
    $formaPagamento = R::dispense('formapagamento');
    $formaPagamento->descricao = "A Combinar";
    R::store($formaPagamento);*/
    /*$contaBancaria = R::dispense('contabancaria');
    $contaBancaria->nome = "Caixa";
    $contaBancaria->saldoinicial = 2000.25;
    $contaBancaria->datasaldo = R::isoDate();
    R::store($contaBancaria);*/
  }

  function endsWith($haystack, $needle)
  {
    $length = strlen($needle);
    if (!$length) {
      return true;
    }
    return substr($haystack, -$length) === $needle;
  }
}
