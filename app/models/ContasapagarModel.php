<?php

namespace App\models;
use App\libraries\Model;
use \R;
class ContasapagarModel extends Model {

  public $fieldsName = ['Descrição', 'Vencimento', 'Forma de pagamento', 'Conta bancária'];
  public $fields = ['descricao', 'vencimento', 'formapagamento_id', 'contabancaria_id'];
  public $table = "contasapagar";

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
