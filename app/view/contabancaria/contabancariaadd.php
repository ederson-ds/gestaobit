<?php

use App\models\ContabancariaModel;
use App\models\FormaPagamentoModel; ?>

<div class="container">
  <?php
  $html->mensagemSucesso();
  ?>
  <div class="row">
    <div class="col-lg-3">
      <?php $html->textField("Descrição", "descricao") ?>
    </div>
    <div class="col-lg-3">
      <?php $html->dateField("Vencimento", "vencimento") ?>
    </div>
    <div class="col-lg-3">
      <?php $html->selectField("Forma de pagamento", "formapagamento_id", new FormaPagamentoModel(), "descricao", "formapagamento") ?>
    </div>
    <div class="col-lg-3">
      <?php $html->selectField("Conta bancária", "contabancaria_id", new ContabancariaModel(), "nome", "contabancaria") ?>
    </div>
  </div>
</div>