<?php

namespace App\controller;
use App\libraries\Controller;

class Contasareceber extends Controller {
  public function index() {
    $this->view('contasareceber/contasareceber');
  }

  public function create() {
    $this->view('contasareceber/contasareceberadd');
  }
}
