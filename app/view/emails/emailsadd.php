<?php

use App\models\ContabancariaModel;
use App\models\FormaPagamentoModel; ?>

<div class="container">
  <?php
  $html->mensagemSucesso();
  $html->mensagemErro();
  ?>
  <div class="row">
    <div class="col-lg-3">
      <?php $html->textField("Email", "email") ?>
    </div>
    <div class="col-lg-3">
      <?php $html->passwordField("Senha", "senha") ?>
    </div>
  </div>
  <?php if($this->model->id != 0) { ?>
    <div class="row">
      <table class="table table-bordered table-hover dataTable no-footer dtr-inline">
        <thead>
          <tr>
            <th>Tela</th>
            <th style="text-align: center;">Visualizar</th>
            <th style="text-align: center;">Cadastrar</th>
            <th style="text-align: center;">Editar</th>
            <th style="text-align: center;">Excluir</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dados['listTelas'] as $key => $tela) { 
            $visualizar = $tela['visualizar'] ? 1 : 0;
            $cadastrar = $tela['cadastrar'] ? 1 : 0;
            $editar = $tela['editar'] ? 1 : 0;
            $excluir = $tela['excluir'] ? 1 : 0;
            ?>
            <tr>
              <td><?php echo $tela['nome'] ?></td>
              <td style="text-align: center;">
                <button onclick="liberarOuBloquear(this, 'visualizar', '<?php echo ($tela['id']) ?? 0 ?>', '<?php echo ($tela['telas_id']) ?? 0 ?>', '<?php echo ($this->model->id) ?? 0 ?>')" type="button" class="btn <?php echo ($visualizar) ? "btn-success" : "btn-danger" ?>"><?php echo ($visualizar) ? "Liberado" : "Bloqueado" ?></button>
              </td>
              <td style="text-align: center;">
                <button onclick="liberarOuBloquear(this, 'cadastrar', '<?php echo ($tela['id']) ?? 0 ?>', '<?php echo ($tela['telas_id']) ?? 0 ?>', '<?php echo ($this->model->id) ?? 0 ?>')" type="button" class="btn <?php echo ($cadastrar) ? "btn-success" : "btn-danger" ?>"><?php echo ($cadastrar) ? "Liberado" : "Bloqueado" ?></button>
              </td>
              <td style="text-align: center;">
                <button onclick="liberarOuBloquear(this, 'editar', '<?php echo ($tela['id']) ?? 0 ?>', '<?php echo ($tela['telas_id']) ?? 0 ?>', '<?php echo ($this->model->id) ?? 0 ?>')" type="button" class="btn <?php echo ($editar) ? "btn-success" : "btn-danger" ?>"><?php echo ($editar) ? "Liberado" : "Bloqueado" ?></button>
              </td>
              <td style="text-align: center;">
                <button onclick="liberarOuBloquear(this, 'excluir', '<?php echo ($tela['id']) ?? 0 ?>', '<?php echo ($tela['telas_id']) ?? 0 ?>', '<?php echo ($this->model->id) ?? 0 ?>')" type="button" class="btn <?php echo ($excluir) ? "btn-success" : "btn-danger" ?>"><?php echo ($excluir) ? "Liberado" : "Bloqueado" ?></button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <script type="text/javascript">
      var loading = false;
      function liberarOuBloquear(button, acao, permissoes_id, telas_id, usuario_id) {
        if(!loading) {
          loading = true;
          var spinner = $(`<i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i>`);
          var libOuBloq = ($(button).html() == "Liberado") ? null : 1;
          $(button).after(spinner);
          $(button).remove();
          $.ajax({
            type: "POST",
            url: URL + "emails/liberarOuBloquear",
            data: { 
                acao: acao,
                permissoes_id: permissoes_id,
                liberarOuBloquear: libOuBloq,
                telas_id: telas_id,
                usuario_id: usuario_id
            },
            success: function(result) {
              result = JSON.parse(result);
              if(libOuBloq) {
                $(button).html("Liberado");
              } else {
                $(button).html("Bloqueado");
              }
              $(button).toggleClass("btn-success btn-danger");
              $(spinner).before(button);
              $(spinner).remove();
              $(button).parent().parent().find("td").eq(1).find("button").attr("onclick",`liberarOuBloquear(this, 'visualizar', '`+result.permissoes_id+`', '`+telas_id+`', '`+usuario_id+`')`);
              $(button).parent().parent().find("td").eq(2).find("button").attr("onclick",`liberarOuBloquear(this, 'cadastrar', '`+result.permissoes_id+`', '`+telas_id+`', '`+usuario_id+`')`);
              $(button).parent().parent().find("td").eq(3).find("button").attr("onclick",`liberarOuBloquear(this, 'editar', '`+result.permissoes_id+`', '`+telas_id+`', '`+usuario_id+`')`);
              $(button).parent().parent().find("td").eq(4).find("button").attr("onclick",`liberarOuBloquear(this, 'excluir', '`+result.permissoes_id+`', '`+telas_id+`', '`+usuario_id+`')`);
              loading = false;
            },
            error: function(result) {
              $(spinner).before(button);
              $(spinner).remove();
              loading = false;
            }
          });
        }
      }
    </script>
  <?php } ?>
</div>
