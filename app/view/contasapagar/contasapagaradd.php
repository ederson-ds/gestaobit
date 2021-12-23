<div class="row">
  <div class="col-lg-3">
    <?php

use App\models\FormaPagamentoModel;

$html->textField("Descrição", "descricao") ?>
  </div>
  <div class="col-lg-3">
    <?php $html->dateField("Vencimento", "vencimento") ?>
  </div>
  <div class="col-lg-3">
    <?php $html->selectField("Forma de pagamento", "formapagamento", new FormaPagamentoModel(), "descricao") ?>
  </div>
  <!--<div class="col-lg-3">
    <label for="selectInput2">Conta bancária</label>
    <div class="input-group">
      <input type="hidden" class="form-control" id="contabancaria" name="contabancaria">
      <input type="text" class="form-control selectInput" id="selectInput2">
      <span class="input-group-addon" style="display: none;">
        <button type="button" class="fa fa-trash removeOption" style="background:transparent;border: 1px solid #ced4da;width: 100%;height: 100%;"></button>
      </span>
    </div>
  </div>-->
</div>