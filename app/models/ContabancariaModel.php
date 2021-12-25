<?php

namespace App\models;

use App\libraries\Model;
use \R;

class ContabancariaModel extends Model
{
  public $table = "contabancaria";

  public function get($query)
  {
    $listContaBancaria = R::find("contabancaria", "nome ILIKE ?", ["%" . $query . "%"]);
    $listContaBancaria['field'] = "nome";
    return $listContaBancaria;
  }
}
