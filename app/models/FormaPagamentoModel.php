<?php

namespace App\models;
use App\libraries\Model;
use \R;
class FormaPagamentoModel extends Model {

  public $fieldsName = ['Descrição'];
  public $fields = ['descricao'];
  public $fieldsTypeData = ['text'];
  public $table = "formapagamento";

  /*public function list($column, $order, $searchValue = "", $start, $length) {
    echo "TEste";
    /*$sql = "SELECT * FROM $this->table WHERE descricao ILIKE '%$searchValue%' ORDER BY $column $order LIMIT $length OFFSET $start";
    return R::getAll($sql);*/
  /*}*/

  public function get($query) {
    $listFormaPagamento = R::find($this->table, "descricao ILIKE ?", ["%".$query."%"]);
    $listFormaPagamento['field'] = "descricao";
    return $listFormaPagamento;
  }

}
