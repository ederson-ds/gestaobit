<table id="listagem" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <td>Descrição</td>
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
            }]
        });
    });
</script>