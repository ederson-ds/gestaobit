<?php $html->datatable($this); ?>
<script>
    mudarString();

    function mudarString() {
        var html = $(".dataTables_length").find("label").html();
        setTimeout(function() {
            if(!html) {
                mudarString();
            } else {
                html = html.replace("resultados por página", "registros");
                $(".dataTables_length").find("label").html(html);
                /*$("#listagem_filter").empty();
                $("#listagem_filter").html(`
                        <label>Pesquisar
                        <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="listagem">
                        </label>
                        
                   
                `);*/
            }
        }, 200);
    }

    
</script>