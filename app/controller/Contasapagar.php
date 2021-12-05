<?php

namespace App\controller;
use App\libraries\Controller;

class Contasapagar extends Controller {
  public function index() {
    $this->view('contasapagar/contasapagar');
  }

  public function create() {
    $this->view('contasapagar/contasapagaradd');
  }
}
