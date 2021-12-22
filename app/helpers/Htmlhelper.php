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
        if ($this->dados['sucessoMsg']) {
            echo '
            <div class="alert alert-success" role="alert">
                ' . $this->dados['sucessoMsg'] . '
            </div>
        ';
        }
    }

    public function textField($fieldName, $slug)
    {
        echo '
            <label for="' . $slug . '"' . ((array_search($slug, $this->requiredFields) !== false) ? 'class="required"' : "") . '>' . $fieldName . '</label>
            <input type="text" class="form-control" id="' . $slug . '" name="' . $slug . '" value="' . $this->dados['objeto']->$slug . '">
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
