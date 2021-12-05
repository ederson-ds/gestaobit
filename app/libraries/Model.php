<?php

namespace App\libraries;

use \R;
use Dotenv\Dotenv;

require "rb-postgres.php";

class Model
{
  public function __construct()
  {
    if (!R::testConnection()) {
      R::setup('pgsql:host=' . getenv('DB_HOST') . ';
          dbname=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'));
    }
    /*
    $formaPagamento = R::dispense('formapagamento');
    $formaPagamento->descricao = "A Combinar";
    R::store($formaPagamento);*/
  }
}
