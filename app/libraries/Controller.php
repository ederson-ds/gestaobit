<?php

namespace App\libraries;

class Controller {
  private function endsWith( $haystack, $needle ) {
      $length = strlen( $needle );
      if( !$length ) {
          return true;
      }
      return substr( $haystack, -$length ) === $needle;
  }

  protected function view($view, $dados = []) {
    $arquivo = ('../app/view/'.$view.'.php');
    if(file_exists($arquivo)) {
      if($this->endsWith($arquivo, 'add.php')) {
        include('../app/view/partials/openform.php');
      }
      include($arquivo);
      if($this->endsWith($arquivo, 'add.php')) {
        include('../app/view/partials/closeform.php');
      }
    } else {
      die('O arquivo de view não existe!');
    }
  }
}
