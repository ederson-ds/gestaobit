<?php

namespace App\models;
use App\libraries\Model;
use \R;
class FormaPagamentoModel extends Model {

  public function get($query) {
    $listFormaPagamento = R::find("formapagamento", "descricao ILIKE ?", ["%".$query."%"]);
    return $listFormaPagamento;
  }

}
