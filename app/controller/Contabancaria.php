<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\ContabancariaModel;

class Contabancaria extends Controller {
  private $contaBancaria;
  public function index() {
    $this->view('contasapagar/contasapagar');
  }

  public function create() {
    $this->view('contasapagar/contasapagaradd');
  }

  public function get() {
    $query = $_POST['query'] ?? "";
    $this->contaBancaria = new ContabancariaModel();
    echo json_encode($this->contaBancaria->get($query));
  }
}
