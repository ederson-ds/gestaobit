<?php

namespace App\models;

use App\libraries\Model;
use \R;

class ContasapagarModel extends Model
{

  public $fieldsName = ['Descrição', 'Vencimento', 'Forma de pagamento', 'Conta bancária'];
  public $fields = ['descricao', 'vencimento', 'formapagamento_id', 'contabancaria_id'];
  public $table = "contasapagar";

  public function list($column, $order, $searchValue = "", $start, $length)
  {
    if ($column == "formapagamento_id")
      $column = "f.descricao";
    elseif ($column == "contabancaria_id")
      $column = "cb.nome";
    else
      $column = "c." . $column;
    $sql = "
    SELECT c.id, c.descricao, to_char(c.vencimento, 'DD/MM/YYYY') as vencimento, f.descricao as formapagamento_id, cb.nome as contabancaria_id FROM $this->table c
    LEFT JOIN formapagamento f ON c.formapagamento_id = f.id
    LEFT JOIN contabancaria cb ON c.contabancaria_id = cb.id
    WHERE c.descricao ILIKE '%$searchValue%' ORDER BY $column $order LIMIT $length OFFSET $start
    ";
    return R::getAll($sql);
  }

  public function get($query)
  {
    $listFormaPagamento = R::find($this->table, "descricao ILIKE ? LIMIT 10", ["%" . $query . "%"]);
    $listFormaPagamento['field'] = "descricao";
    return $listFormaPagamento;
  }
}
