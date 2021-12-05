<?php

namespace App\controller;
use App\libraries\Controller;

class Paginas extends Controller {
  public function index() {
    $dados = [
      'titulo' => 'Página Inicial',
      'descricao' => 'GestãoBit'
    ];
    $this->view('paginas/home', $dados);
  }

  public function erro404() {
    $this->view('paginas/erro404');
  }

  public function sobre() {
    $dados = [
      'titulo' => 'Página Sobre',
      'descricao' => 'GestãoBit'
    ];
    $this->view('paginas/sobre', $dados);
  }
}
