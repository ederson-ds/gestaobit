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

  public function get($query) {
    $listFormaPagamento = R::find("formapagamento", "descricao ILIKE ?", ["%".$query."%"]);
    $listFormaPagamento['field'] = "descricao";
    return $listFormaPagamento;
  }

}
