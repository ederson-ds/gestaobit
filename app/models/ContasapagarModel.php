<?php

namespace App\models;

use App\libraries\Model;
use \R;

class ContasapagarModel extends Model
{

  public $fieldsName = ['Descrição', 'Vencimento', 'Forma de pagamento', 'Conta bancária'];
  public $fields = ['descricao', 'vencimento', 'formapagamento_id', 'contabancaria_id'];
  public $fieldsTypeData = ['text', 'date', 'fk', 'fk'];
  public $foreignTables = ['formapagamento', 'contabancaria'];
  public $foreignTablesFilterColumn = ['descricao', 'nome'];
  public $table = "contasapagar";

  /*public function list($column, $order, $searchValue = "", $start, $length)
  {
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
    if ($column == "formapagamento_id")
      $column = "f.descricao";
    elseif ($column == "contabancaria_id")
      $column = "cb.nome";
    else
      $column = "c." . $column;

    //filtro
    $filter = "";
    $filter .= " AND (c.descricao ILIKE '%$searchValue%'";

    $filter .= " OR (";
    $filter .= " f.descricao ILIKE '%$searchValue%'";
    $filter .= " OR cb.nome ILIKE '%$searchValue%'";

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
    $filter .= ")";
    $filter .= ")";


    $sql = "
    SELECT c.id, c.descricao, to_char(c.vencimento, 'DD/MM/YYYY') as vencimento, f.descricao as formapagamento_id, cb.nome as contabancaria_id FROM $this->table c
    LEFT JOIN formapagamento f ON c.formapagamento_id = f.id
    LEFT JOIN contabancaria cb ON c.contabancaria_id = cb.id
    WHERE c.login_id = ".$_SESSION['login_id']."$filter ORDER BY $column $order LIMIT $length OFFSET $start
    ";
    return R::getAll($sql);
  }*/

  public function get($query)
  {
    $listFormaPagamento = R::find($this->table, "descricao ILIKE ? LIMIT 10", ["%" . $query . "%"]);
    $listFormaPagamento['field'] = "descricao";
    return $listFormaPagamento;
  }
}
