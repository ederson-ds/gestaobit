<?php
  require __DIR__ . '/../vendor/autoload.php';
  use App\libraries\Rota;
  use App\libraries\Environment;

  Environment::load(dirname(__DIR__));

  include('../app/config.php');
  session_start();
  $url = explode('/', $_SERVER['REQUEST_URI']);
  print_r($url);

  $controller = false;
  if(!$url[2]) {
    $controller = true;
  } else {
    if(isset($_SESSION['telas'])) {
      foreach (json_decode($_SESSION['telas']) as $tela) {
        if($url[2] == strtolower($tela->controller) || $url[2] == 'logout') {
          $controller = true;
        }
      }
    }
  }
  if(!isset($_SESSION['login']) && $url[2] != 'login') {
    //header("Location: ".URL."/login");
    exit();
  } else {
    if(isset($_SESSION['login']) && !$controller && $url[2] != 'paginas') {
      header("Location: ".URL."/paginas/erro404");
      exit();
    }
  }

  if(isset($url[3])) {
    $url[3] = strtok($url[3], '?');
    if($url[3] == "get") {
      $rotas = new Rota();
      exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo APP_NOME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL ?>/public/css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <div class="main">
      <?php if(isset($_SESSION['login'])) { ?>
        <div class="sidebar">
          <ul>
            <?php foreach (json_decode($_SESSION['telas']) as $tela) { ?>
              <li>
                <a href="<?php echo URL . "/" . strtolower($tela->controller) ?>"><?php echo $tela->controller; ?></a>
              </li>
            <?php } ?>
            <!--<li>
              <a href="<?php echo URL ?>/contasapagar">Contas a pagar</a>
            </li>
            <li>
              <a href="<?php echo URL ?>/contasareceber">Contas a receber</a>
            </li>
            <li>
              <a href="<?php echo URL ?>/permissoes">Permissões</a>
            </li>-->
            <li>
              <a href="<?php echo URL ?>/logout">Logout</a>
            </li>
          </ul>
        </div>
      <?php } ?>
      <div class="content">
        <?php
          $rotas = new Rota();
        ?>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo URL ?>/public/js/main.js"></script>
    <script>
      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }
    </script>
  </body>
</html>
