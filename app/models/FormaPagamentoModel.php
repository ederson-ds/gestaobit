<?php

namespace App\models;
use App\libraries\Model;
use \R;
class FormaPagamentoModel extends Model {

  public $fields = ['descricao'];
  public $table = "formapagamento";

  public function save() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      parent::save();
    }
  }

  public function list($column, $order, $searchValue = "", $start, $length) {
    $sql = "SELECT * FROM $this->table WHERE descricao ILIKE '%$searchValue%' ORDER BY $column $order LIMIT $length OFFSET $start";
    return R::getAll($sql);
  }

  public function get($query) {
    $listFormaPagamento = R::find($this->table, "descricao ILIKE ?", ["%".$query."%"]);
    $listFormaPagamento['field'] = "descricao";
    return $listFormaPagamento;
  }

}
