<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo APP_NOME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL ?>/public/css/estilos.css?v=<?php echo time(); ?>">
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
