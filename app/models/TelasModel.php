<?php

namespace App\models;

use App\libraries\Model;
use \R;

class TelasModel extends Model
{

  public $fieldsName = ['Descrição', 'Vencimento', 'Forma de pagamento', 'Conta bancária'];
  public $fields = ['descricao', 'vencimento', 'formapagamento_id', 'contabancaria_id'];
  public $table = "telas";

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
  }

  public function get($query)
  {
    $listTelas = R::find($this->table, "nome ILIKE ? AND id NOT IN (7,11) AND menupai_id IS NOT NULL LIMIT 10", ["%" . $query . "%"]);
    $listTelas['field'] = "nome";
    $listTelas['cadastrarNovo'] = false;
    return $listTelas;
  }

  public function getPermissoes($usuario_id)
  {
    $sql = "
      select p.id, t.id as telas_id, t.nome, p.visualizar, p.cadastrar, p.editar, p.excluir
      from telas t 
      left join login l on l.id = $usuario_id
      left join permissoes p on p.usuario_id = l.id and t.id = p.telas_id 
      where t.id NOT IN (7,11) AND menupai_id IS NOT null
      ORDER BY t.nome";
    return R::getAll($sql);
  }
}
