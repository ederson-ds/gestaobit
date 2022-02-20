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
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
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
          <?php
          if (isset($_SESSION['telas'])) {
            $arrayMenuPai = [];
            foreach (json_decode($_SESSION['telas']) as $tela) {
              if (!in_array($tela->telapainome, $arrayMenuPai)) {
                array_push($arrayMenuPai, $tela->telapainome); ?>
                <li>
                  <a href="#" class="menuPaiBtn"><i class="<?php echo $tela->icon; ?>"></i> <?php echo $tela->telapainome; ?>
                    <span class="fa fa-caret-down caret"></span>
                  </a>
                  <ul class="filhos">
                    <?php foreach (json_decode($_SESSION['telas']) as $subtela) {
                      if ($subtela->telapainome == $tela->telapainome) {
                    ?>
                        <li>
                          <a href="<?php echo URL . "/" . strtolower($subtela->controller) ?>" <?php echo ($this->controller == strtolower($subtela->controller)) ? 'id="filhoActive"' : "" ?>><?php echo $subtela->nome; ?></a>
                        </li>
                    <?php }
                    } ?>
                  </ul>
                </li>
          <?php }
            }
          } ?>
          <li>
            <a href="<?php echo URL ?>/logout"><i class="fa fa-sign-out"></i> Sair</a>
          </li>
        </ul>
      </nav>
    <?php } ?>
    <div class="content">
      <header><i class="fa fa-bars" id="btn"></i></header>
      <div class="container">
        <div class="content_card">
          <div class="content_card_header">
              <?php echo $this->tela->telapainome . " / ". $this->tela->nome ?>
          </div>
        <div class="content_card_body">