<?php

namespace App\controller;
use App\libraries\Controller;

class Logout extends Controller {
  public function index() {
    session_unset();
    header("Location: ".URL."/login");
  }
}
