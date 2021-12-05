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
    <label for="formapagamento">Forma de pagamento</label>
    <div class="input-group">
      <input type="hidden" class="form-control" id="formapagamento" name="formapagamento">
      <input type="text" class="form-control selectInput">
      <span class="input-group-addon" style="display: none;">
        <button type="button" class="fa fa-trash removeOption" style="background:transparent;border: 1px solid #ced4da;width: 100%;height: 100%;"></button>
      </span>
    </div>
  </div>
</div>

<div class="select" style="display: none;" tabindex="-1">
  <table>
    <tr>
      <th>A Combinar</th>
    </tr>
    <tr>
      <th>Boleto Bancário</th>
    </tr>
    <tr>
      <th>Dinheiro à Vista</th>
    </tr>
    <tr>
      <th style="background: green; color:white">Cadastrar novo</th>
    </tr>
  </table>
</div>

<script type="text/javascript">
  var selectInput = null;
  $(".selectInput").focus(function() {
    selectInput = $(this);
    if(!selectInput.val()) {
      var inputGroup = selectInput.parent().position();
      $(".select").show();
      $(".select").css({top: inputGroup.top + 40, left: inputGroup.left, height: "auto", overflow: "hidden", width: selectInput.parent().width() });
      $(".select table").empty();
      $(".select table").append('<p style="padding: 6px;margin: 0;">Buscando...</p>');
      //$(".select").focus();

      $.ajax({
        type: 'GET',
        url: '<?php echo URL ?>/formapagamento/get',
        dataType: 'json',
        success: function (data) {
          $(".select table").empty();
          $(".select").css({height: "67px", "overflow-y": "scroll"});
          var result = Object.keys(data);
          result.forEach(element => {
            $(".select table").append("<tr id="+data[element].id+"><th>"+data[element].descricao+"</th></tr>");
          });
        }
      });
    }
  });

  $(document).on("keyup", ".selectInput", function() {
    $(".select").show();
    $(".select table").empty();
    $(".select table").append('<p style="padding: 6px;margin: 0;">Buscando...</p>');

    $.ajax({
      type: 'POST',
      url: '<?php echo URL ?>/formapagamento/get',
      data: { query: $(".selectInput").val() },
      dataType: 'json',
      success: function (data) {
        $(".select table").empty();
        $(".select").css({height: "67px", "overflow-y": "scroll"});
        var result = Object.keys(data);
        result.forEach(element => {
          $(".select table").append("<tr id="+data[element].id+"><th>"+data[element].descricao+"</th></tr>");
        });
        if(result.length == 0) {
          $(".select table").append("<tr><th>Nenhum resultado encontrado</th></tr>");
          $(".select table").append('<tr><th style="background: green; color:white">Cadastrar novo</th></tr>');
        }
      }
    });
  });

/*  $(".select").focusout(function(){
    $(".select").hide();
  });*/

  $(".select").focusout(function () {
     $(".select").hide();
  });

  $(document).on("click",".select table tr", function() {
    var id = $(this).attr('id');
    $("#formapagamento").val(id);
    selectInput.val($(this).find("th").text());
    $(".select").hide();
    selectInput.parent().find(".input-group-addon").show();
  });

  $(document).on("click",".removeOption", function() {
    $(this).parent().hide();
    selectInput.val('');
    $("#formapagamento").val('');
  });
</script>
