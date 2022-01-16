<?php

use App\models\ContabancariaModel;
use App\models\FormaPagamentoModel; ?>

<div class="container">
  <?php
  $html->mensagemSucesso();
  ?>
  <div class="row">
    <div class="col-lg-3">
      <?php $html->textField("Email", "email") ?>
    </div>
    <div class="col-lg-3">
      <?php $html->passwordField("Senha", "senha") ?>
    </div>
  </div>
</div>