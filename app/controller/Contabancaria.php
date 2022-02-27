<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\ContabancariaModel;

class Contabancaria extends Controller {
  public $controller = "contabancaria";

  public function __construct()
  {
    parent::__construct();
    $this->model = new ContabancariaModel();
  }

  public function index() {
    $this->view('contabancaria/contabancaria');
  }

  public function create() {
    $this->view('contabancaria/contabancariaadd');
  }

  public function get() {
    $query = $_POST['query'] ?? "";
    $this->contaBancaria = new ContabancariaModel();
    echo json_encode($this->contaBancaria->get($query));
  }
}
