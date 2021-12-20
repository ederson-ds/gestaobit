<div class="row">
  <div class="col-lg-3">
    <label for="descricao">Descrição do pagamento</label>
    <input type="text" class="form-control" id="descricao" name="descricao">
  </div>
  <div class="col-lg-3">
    <label for="vencimento">Vencimento</label>
    <input type="date" class="form-control" id="vencimento" name="vencimento">
  </div>
  <div class="col-lg-3">
    <label for="selectInput">Forma de pagamento</label>
    <div class="input-group">
      <input type="hidden" class="form-control" id="formapagamento" name="formapagamento">
      <input type="text" class="form-control selectInput" id="selectInput">
      <span class="input-group-addon" style="display: none;">
        <button type="button" class="fa fa-trash removeOption" style="background:transparent;border: 1px solid #ced4da;width: 100%;height: 100%;"></button>
      </span>
    </div>
  </div>
  <div class="col-lg-3">
    <label for="selectInput2">Conta bancária</label>
    <div class="input-group">
      <input type="hidden" class="form-control" id="contabancaria" name="contabancaria">
      <input type="text" class="form-control selectInput" id="selectInput2">
      <span class="input-group-addon" style="display: none;">
        <button type="button" class="fa fa-trash removeOption" style="background:transparent;border: 1px solid #ced4da;width: 100%;height: 100%;"></button>
      </span>
    </div>
  </div>
</div>

<div class="select" style="display: none;" tabindex="-1">
  <table>
  </table>
</div>
