<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <title><?php echo APP_NOME ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo URL ?>/public/css/estilos.css?v=<?php echo time(); ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="main">
    <?php if (isset($_SESSION['login'])) { ?>
      <nav class="sidebar">
        <div class="logo_content">
          <div class="logo">
            <div class="logo_name">GestãoBit <i class="fa fa-bars" id="btnSidebar"></i></div>
          </div>
        </div>
        <ul>
          <?php foreach (json_decode($_SESSION['telas']) as $tela) {
            if ($tela->top) { ?>
              <li>
                <a href="#" class="menuPaiBtn"><?php echo $tela->nometop; ?>
                  <span class="fa fa-caret-down caret"></span>
                </a>
                <ul class="filhos">
                  <?php foreach (json_decode($_SESSION['telas']) as $subtela) {
                    if ($subtela->permissoes_id == $tela->id) {
                  ?>
                      <li>
                        <a href="<?php echo URL . "/" . strtolower($subtela->controller) ?>"><?php echo $subtela->controller; ?></a>
                      </li>
                  <?php }
                  } ?>
                </ul>
              </li>
              <!--<li>
                <a href="<?php echo URL . "/" . strtolower($tela->controller) ?>"><?php echo $tela->controller; ?></a>
              </li>-->
          <?php }
          } ?>
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
      </nav>
    <?php } ?>
    <div class="content">
      <header style="display: none;"><i class="fa fa-bars" id="btn"></i></header>