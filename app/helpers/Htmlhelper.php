<?php

namespace App\helpers;

class Htmlhelper
{
    private $dados = [];
    private $requiredFields = [];

    public function __construct($dados, $requiredFields)
    {
        $this->dados = $dados;
        $this->requiredFields = $requiredFields;
    }

    public function mensagemSucesso()
    {
        if (isset($this->dados['sucessoMsg'])) {
            echo '
            <div class="alert alert-success" role="alert">
                ' . $this->dados['sucessoMsg'] . '
            </div>
        ';
        }
    }

    public function mensagemErro()
    {
        if (isset($this->dados['erro'])) {
            echo '
            <div class="alert alert-danger" role="alert">
                ' . $this->dados['erro'] . '
            </div>
        ';
        }
    }

    public function datatable($controller, $checkboxes = [])
    {
        $columnsName = "";
        foreach ($controller->model->fieldsName as $key => $fieldName) {
            $columnsName .= "<td>" . $fieldName . "</td>";
        }
        $acoes = "";
        if ($controller->tela->editar || $controller->tela->excluir) {
            $acoes .= "<td>Ações</td>";
        }
        $cadastrar = "";
        if ($controller->tela->cadastrar) {
            $cadastrar .= '<a href="' . URL . '/' . $controller->controller . '/create" class="btn btn-dark btn-sm" id="inserirNovo">Inserir novo</a>';
        }
        // Table
        echo $cadastrar . '
            <table id="listagem" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        ' . $columnsName . '
                        ' . $acoes . '
                    </tr>
                </thead>
            </table>
            <hr>
            ';

        $acoesScript = "";
        if ($controller->tela->editar || $controller->tela->excluir) {
            $acoesScript .= '
                            {
                                "data": null,
                                "orderable": false,
                                "render": function ( data, type, row ) {
                                    var edit = `<a href="' . URL . '/' . $controller->controller . '/create/`+data.id+`" class="icon"><i class="fa fa-pencil" aria-hidden="true"></i></a><span style="margin-right: 10px;"></span>`;
                                    var excluir = ` <span class="btnExcluir icon" data-id="`+data.id+`" data-controller="' . $controller->controller . '" data-bs-toggle="modal" data-bs-target="#excluirModal"><i class="fa fa-trash" aria-hidden="true"></i></span>`;
                                    var acoes = "";
                                    if(' . ($controller->tela->editar ?? "false") . ') {
                                        acoes += edit;
                                    }
                                    if(' . ($controller->tela->excluir ?? "false") . ') {
                                        acoes += excluir;
                                    }
                                    return acoes;
                                }
                            }';
        }

        $columns = "";
        foreach ($controller->model->fields as $key => $field) {
            if (in_array($field, $checkboxes)) {
                $columns .= '
                {
                    "data": "' . $field . '",
                    "render": function ( data, type, row ) {
                        var html = `<input class="form-check-input" type="checkbox" `+((data) ? "checked" : "")+` disabled>`;
                        return html;
                    }
                },';
            } else {
                $columns .= '{"data": "' . $field . '"},';
            }
        }

        //Script JS
        echo '
            <script>
                $(document).ready(function() {
                    $("#listagem").DataTable({
                        "responsive": true,
                        "language": {
                            "emptyTable": "Nenhum registro encontrado",
                            "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                            "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                            "infoFiltered": "(Filtrados de _MAX_ registros)",
                            "infoThousands": ".",
                            "loadingRecords": "Carregando...",
                            "processing": "Processando...",
                            "zeroRecords": "Nenhum registro encontrado",
                            "search": "",
                            "searchPlaceholder": "Pesquisar",
                            "paginate": {
                                "next": "Próximo",
                                "previous": "Anterior",
                                "first": "Primeiro",
                                "last": "Último"
                            },
                            "lengthMenu": "Exibir _MENU_ registros",
                        },
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": "' . URL . '/' . $controller->controller . '/list",
                            "type": "POST"
                        },
                        "columns": [
                        ' . $columns . '
                        ' . $acoesScript . '
                        ]
                    });
                });
            </script>
        ';
    }

    public function getValue($slug)
    {
        return !$this->dados['cadastrado'] ? (($this->dados['objeto']->$slug) ?? (($_POST[$slug]) ?? "")) : "";
    }

    public function textField($fieldName, $slug)
    {
        $value = $this->getValue($slug);
        echo '
            <label for="' . $slug . '"' . ((array_search($slug, $this->requiredFields) !== false) ? 'class="required"' : "") . '>' . $fieldName . '</label>
            <input type="text" class="form-control' . ((((array_search($slug, $this->dados['camposVazios']) !== false)) || ((array_search($slug, $this->dados['camposInvalidos']) !== false))) ? " error" : "") . '" id="' . $slug . '" name="' . $slug . '" value="' . $value . '">
            ' . $this->errorsField($slug) . '
        ';
    }

    public function passwordField($fieldName, $slug)
    {
        $value = $this->getValue($slug);
        echo '
            <label for="' . $slug . '"' . ((array_search($slug, $this->requiredFields) !== false) ? 'class="required"' : "") . '>' . $fieldName . '</label>
            <input type="password" class="form-control' . ((((array_search($slug, $this->dados['camposVazios']) !== false)) || ((array_search($slug, $this->dados['camposInvalidos']) !== false))) ? " error" : "") . '" id="' . $slug . '" name="' . $slug . '" value="' . $value . '">
            ' . $this->errorsField($slug) . '
        ';
    }

    public function dateField($fieldName, $slug)
    {
        $value = $this->getValue($slug);
        echo '
            <label for="' . $slug . '"' . ((array_search($slug, $this->requiredFields) !== false) ? 'class="required"' : "") . '>' . $fieldName . '</label>
            <input type="date" class="form-control' . ((((array_search($slug, $this->dados['camposVazios']) !== false)) || ((array_search($slug, $this->dados['camposInvalidos']) !== false))) ? " error" : "") . '" id="' . $slug . '" name="' . $slug . '" value="' . $value . '">
            ' . $this->errorsField($slug) . '
        ';
    }

    public function checkbox($fieldName, $slug)
    {
        $value = $this->getValue($slug);
        echo '
            <div class="form-check">
              <input type="hidden" value="0" name="' . $slug . '">
              <input class="form-check-input" type="checkbox" value="1" name="' . $slug . '" id="' . $slug . '" ' . (($value == 1) ? "checked" : "") . '>
              <label class="form-check-label" for="' . $slug . '">
                ' . $fieldName . '
              </label>
            </div>
            ' . $this->errorsField($slug) . '
        ';
    }

    public function selectField($fieldName, $slug, $model, $printColumn, $controller)
    {
        $value = $this->getValue($slug);
        $objeto = $model->getOne($value);

        echo '
            <label for="selectInput"' . ((array_search($slug, $this->requiredFields) !== false) ? 'class="required"' : "") . '>' . $fieldName . '</label>
            <div class="input-group">
                <input type="hidden" class="form-control" controller="' . $controller . '" id="' . $slug . '" name="' . $slug . '" value="' . $value . '">
                <input type="text" class="form-control selectInput' . ((((array_search($slug, $this->dados['camposVazios']) !== false)) || ((array_search($slug, $this->dados['camposInvalidos']) !== false))) ? " error" : "") . '" value="' . (!$this->dados['cadastrado'] ? (($objeto->$printColumn) ?? (($_POST[$slug]) ?? "")) : "") . '" ' . (($objeto) ? "disabled" : "") . '>
                <span class="input-group-addon" style="' . (($objeto) ? "" : "display: none;") . '">
                    <button type="button" class="fa fa-trash removeOption"></button>
                </span>
            </div>
            ' . $this->errorsField($slug) . '
        ';
    }

    public function errorsField($slug)
    {
        return '<div class="text-danger">
        <small>' . ((array_search($slug, $this->dados['camposVazios']) !== false) ? "Campo obrigatório" : "") . '</small>
        <small>' . ((array_search($slug, $this->dados['camposInvalidos']) !== false) ? "Campo inválido" : "") . '</small>
        </div>';
    }
}
