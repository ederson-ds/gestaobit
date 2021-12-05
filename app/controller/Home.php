<?php

namespace App\controller;
use App\libraries\Controller;

class Home extends Controller {
  public function index() {
    $this->view('paginas/home');
  }
}
