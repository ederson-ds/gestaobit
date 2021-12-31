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
    if(is_numeric(substr($searchValue, 0, 2))) {
      $dia = substr($searchValue, 0, 2);
      if(is_numeric(substr($searchValue, 3, 2))) {
        $mes = substr($searchValue, 3, 2);
        if(is_numeric(substr($searchValue, 6, 4))) {
          $ano = substr($searchValue, 6, 4);
        }
      }
    }
    if ($column == "formapagamento_id")
      $column = "f.descricao";
    elseif ($column == "contabancaria_id")
      $column = "cb.nome";
    else
      $column = "c." . $column;

    //filtro
    $filter = "";
    $filter .= " AND c.descricao ILIKE '%$searchValue%'";
    if (isset($dia)) {
      $filter .= " OR (";
      $filter .= " EXTRACT(DAY FROM vencimento) = " . $dia;
      if (isset($mes)) {
        $filter .= " AND EXTRACT(MONTH FROM vencimento) = " . $mes;
        if (isset($ano)) {
          $filter .= " AND EXTRACT(YEAR FROM vencimento) = " . $ano;
        }
      }
      $filter .= ")";
    }

    $filter .= " OR f.descricao ILIKE '%$searchValue%'";
    $filter .= " OR cb.nome ILIKE '%$searchValue%'";

    $sql = "
    SELECT c.id, c.descricao, to_char(c.vencimento, 'DD/MM/YYYY') as vencimento, f.descricao as formapagamento_id, cb.nome as contabancaria_id FROM $this->table c
    LEFT JOIN formapagamento f ON c.formapagamento_id = f.id
    LEFT JOIN contabancaria cb ON c.contabancaria_id = cb.id
    WHERE 1 = 1$filter ORDER BY $column $order LIMIT $length OFFSET $start
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
