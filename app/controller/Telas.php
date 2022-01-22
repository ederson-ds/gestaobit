<?php

namespace App\controller;
use App\libraries\Controller;
use App\models\TelasModel;

class Telas extends Controller {
  public $controller = "telas";

  public function __construct()
  {
    parent::__construct();
    $this->model = new TelasModel();
  }

  public function get()
  {
    $query = $_POST['query'] ?? "";
    echo json_encode($this->model->get($query));
  }
}
