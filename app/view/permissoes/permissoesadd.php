<?php

use App\models\ContabancariaModel;
use App\models\FormaPagamentoModel;
use App\models\TelasModel;
use App\models\LoginModel; ?>

<div class="container">
  <?php
  $html->mensagemSucesso();
  ?>
  <div class="row">
    <div class="col-lg-3">
      <?php $html->selectField("Usuário", "login_id", new LoginModel(), "email") ?>
    </div>
    <div class="col-lg-3">
      <?php $html->selectField("Tela", "telas_id", new TelasModel(), "nome") ?>
    </div>
    <div class="col-lg-3">
      <?php $html->checkbox("Cadastrar", "cadastrar") ?>
    </div>
    <div class="col-lg-3">
      <?php $html->checkbox("Editar", "editar") ?>
    </div>
    <div class="col-lg-3">
      <?php $html->checkbox("Excluir", "excluir") ?>
    </div>
  </div>
</div>
