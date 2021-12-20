<?php

namespace App\libraries;

use \R;

require "rb-postgres.php";

class Model
{
  protected $fields = [];
  protected $table = null;

  public function save()
  {
    $data[$this->table] = R::dispense($this->table);
    $achou = false;
    foreach ($_POST as $key => $campo) {
      foreach ($this->fields as $field) {
        if ($key == $field) {
          $data[$this->table]->$key = $campo;
          $achou = true;
        }
      }
    }
    if($achou) {
      R::store($data[$this->table]);
    }
  }

  public function getOne($id) {
    return R::findOne($this->table, "id = ?", [$id]);
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
