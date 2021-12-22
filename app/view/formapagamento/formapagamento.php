<table id="listagem" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <td>Descrição</td>
            <td>Ações</td>
        </tr>
    </thead>
</table>
<hr>
<a href="<?php echo URL ?>/formapagamento/create">create</a>

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
                {
                    "data": null,
                    "orderable": false,
                    "render": function ( data, type, row ) {
                        return `
                            <a href="<?php echo URL ?>/formapagamento/create/`+data.id+`" class="btn btn-secondary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        `
                    }
                }
            ]
        });
    });
</script>