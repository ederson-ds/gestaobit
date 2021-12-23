<table id="listagem" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <td>Descrição</td>
            <?php if($this->tela->editar || $this->tela->excluir) { ?>
                <td>Ações</td>
            <?php } ?>
        </tr>
    </thead>
</table>
<hr>
<?php echo ($this->tela->cadastrar) ? '<a href="'.URL.'/'.$this->controller.'/create">Inserir novo</a>' : "" ?>

<script>
    $(document).ready(function() {
        $('#listagem').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo URL ?>/formapagamento/list",
                "type": "POST"
            },
            "columns": [{
                    "data": "descricao"
                },
                <?php if($this->tela->editar || $this->tela->excluir) {
                    echo '
                    {
                        "data": null,
                        "orderable": false,
                        "render": function ( data, type, row ) {
                            var edit = `<a href="'.URL.'/formapagamento/create/`+data.id+`" class="btn btn-secondary"><i class="fa fa-pencil" aria-hidden="true"></i></a>`;
                            var excluir = ` <button type="button" class="btn btn-danger btnExcluir" data-id="`+data.id+`" data-controller="formapagamento" data-bs-toggle="modal" data-bs-target="#excluirModal"><i class="fa fa-trash" aria-hidden="true"></i></button>`;
                            var acoes = "";
                            if('.($this->tela->editar ?? "false").') {
                                acoes += edit;
                            }
                            if('.($this->tela->excluir ?? "false").') {
                                acoes += excluir;
                            }
                            return acoes;
                        }
                    }';
                } ?>
            ]
        });
    });
</script>