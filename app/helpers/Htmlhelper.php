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

    public function datatable($controller)
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
            $cadastrar .= '<a href="' . URL . '/' . $controller->controller . '/create">Inserir novo</a>';
        }
        // Table
        echo '
            <table id="listagem" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        ' . $columnsName . '
                        ' . $acoes . '
                    </tr>
                </thead>
            </table>
            <hr>
            ' . $cadastrar;

        $acoesScript = "";
        if ($controller->tela->editar || $controller->tela->excluir) {
            $acoesScript .= '
                            {
                                "data": null,
                                "orderable": false,
                                "render": function ( data, type, row ) {
                                    var edit = `<a href="' . URL . '/' . $controller->controller . '/create/`+data.id+`" class="btn btn-secondary"><i class="fa fa-pencil" aria-hidden="true"></i></a>`;
                                    var excluir = ` <button type="button" class="btn btn-danger btnExcluir" data-id="`+data.id+`" data-controller="' . $controller->controller . '" data-bs-toggle="modal" data-bs-target="#excluirModal"><i class="fa fa-trash" aria-hidden="true"></i></button>`;
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
            $columns .= '{"data": "' . $field . '"},';
        }

        //Script JS
        echo '
            <script>
                $(document).ready(function() {
                    $("#listagem").DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
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

    public function getValue($slug) {
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
              <input class="form-check-input" type="checkbox" value="1" name="' . $slug . '" id="' . $slug . '" '.(($value == 1) ? "checked" : "").'>
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
                <input type="text" class="form-control selectInput' . ((((array_search($slug, $this->dados['camposVazios']) !== false)) || ((array_search($slug, $this->dados['camposInvalidos']) !== false))) ? " error" : "") . '" id="selectInput" value="' . (!$this->dados['cadastrado'] ? (($objeto->$printColumn) ?? (($_POST[$slug]) ?? "")) : "") . '" ' . (($objeto) ? "disabled" : "") . '>
                <span class="input-group-addon" style="' . (($objeto) ? "" : "display: none;") . '">
                    <button type="button" class="fa fa-trash removeOption" style="background:transparent;border: 1px solid #ced4da;width: 100%;height: 100%;"></button>
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
