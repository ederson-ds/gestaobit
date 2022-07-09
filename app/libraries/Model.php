<?php

namespace App\libraries;

use \R;

require "rb-postgres.php";

class Model
{
  protected $fieldsName = [];
  protected $fields = [];
  protected $fieldsTypeData = [];
  protected $table = null;
  protected $foreignTables = [];
  protected $foreignTablesFilterColumn = [];
  public $id = 0;

  public function save($dados)
  {
    if (!$dados['camposInvalidos'] && !$dados['camposVazios'] && !$dados['erro']) {
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
    /*$permissoes = R::load("permissoes", 0);
    $permissoes->excluir = 1;
    R::store($permissoes);*/
    /*$permissoes = R::load("permissoes", 0);
    $permissoes->cadastrar = 1;
    $permissoes->visualizar = 1;
    R::store($permissoes);*/
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

  public function list($column, $order, $searchValue = "", $start, $length)
  {
    //date
    if($searchValue) {
      $date = explode("/", $searchValue);
    }
    if(isset($date[0]) && is_numeric($date[0])) {
      $dia = $date[0];
      if(isset($date[1]) && $date[1] != "") {
        $mes = $date[1];
        if(isset($date[2]) && $date[2] != "") {
          $ano = $date[2];
        }
      }
    }

    //joins
    $join = "";
    foreach($this->foreignTables as $foreignTable) {
      $join .= " LEFT JOIN $foreignTable ON maintable.".$foreignTable."_id = $foreignTable.id";
    }

    //filter
    $filter = "";
    $i = 0;
    $firstOR = false;
    $selectFields = "maintable.id, ";
    foreach($this->fields as $key => $field) {
      if($i == 0) {
        $selectFields .= "maintable.$field, ";
        $filter .= " AND (maintable.$field ILIKE '%$searchValue%'";
      } else {
        if($this->fieldsTypeData[$key] == "fk") {
          foreach($this->foreignTables as $key2 => $foreignTable) {
            if($foreignTable == substr($field, 0, -3)) {
              $selectFields .= $foreignTable.".".$this->foreignTablesFilterColumn[$key2]." as $field, ";
              if(!$firstOR) {
                $filter .= " OR (";
                $firstOR = true;
              } else {
                $filter .= " OR ";
              }
              $filter .= $foreignTable.".".$this->foreignTablesFilterColumn[$key2]." ILIKE '%$searchValue%'";
            }
          }
        } else if($this->fieldsTypeData[$key] == "text") {
          $selectFields .= "maintable.$field, ";
          if(!$firstOR) {
            $filter .= " OR (";
            $firstOR = true;
          } else {
            $filter .= " OR ";
          }
          $filter .= "maintable.$field ILIKE '%$searchValue%'";
        } else if($this->fieldsTypeData[$key] == "date") {
          $selectFields .= "to_char(maintable.$field, 'DD/MM/YYYY') as $field, ";
        }
      }
      $i++;
    }

    foreach($this->fields as $key => $field) {
      if($this->fieldsTypeData[$key] == "date") {
        if (isset($dia)) {
          $filter .= " OR (";
          $filter .= " EXTRACT(DAY FROM $field) = " . $dia;
          if (isset($mes)) {
            $filter .= " AND EXTRACT(MONTH FROM $field) = " . $mes;
            if (isset($ano)) {
              $filter .= " AND EXTRACT(YEAR FROM $field) = " . $ano;
            }
          }
          $filter .= ")";
        }
      }
    }
    if($i != 1) {
      $filter .= ")";
    }
    $filter .= ")";
    $selectFields = rtrim($selectFields, " ,");

    $sql = "
      SELECT $selectFields FROM $this->table maintable
      $join
      WHERE maintable.login_id = ".$_SESSION['login_id']."$filter ORDER BY maintable.$column $order LIMIT $length OFFSET $start
    ";
    return R::getAll($sql);
  }
}
