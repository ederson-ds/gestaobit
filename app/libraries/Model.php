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
        $achou = false;
        foreach ($_POST as $key => $campo) {
          foreach ($this->fields as $field) {
            if ($key == $field) {
              $data[$this->table]->$key = $campo;
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
    return R::count($this->table);
  }

  public function __construct()
  {
    if (!R::testConnection()) {
      R::setup('pgsql:host=' . getenv('DB_HOST') . ';
          dbname=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'));
    }
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
}
