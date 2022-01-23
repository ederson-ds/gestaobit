<?php

namespace App\models;

use App\libraries\Model;
use \R;

class PermissoesModel extends Model
{

  public $fieldsName = ['Usuário', 'Tela', 'Cadastrar', 'Editar', 'Excluir'];
  public $fields = ['usuario_id', 'telas_id', 'cadastrar', 'editar', 'excluir'];
  public $table = "permissoes";

  public function save($dados)
  {
    if (!$dados['camposInvalidos'] && !$dados['camposVazios']) {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data[$this->table] = R::load($this->table, $this->id);
        $data[$this->table]->login = R::load("login", $_SESSION['login_id']);
        $achou = false;
        foreach ($_POST as $key => $campo) {
          foreach ($this->fields as $field) {
            if ($key == $field) {
              if ($this->endsWith($field, "_id") && $campo) {
                $controller = substr($field, 0, -3);
                if ($controller == "usuario") {
                  $data[$this->table]->usuario_id = $campo;
                } else {
                  $data[$this->table]->$controller = R::load($controller, $campo);
                }
              } else if ($campo) {
                $data[$this->table]->$key = $campo;
              }
              $achou = true;
            }
          }
        }
        if ($achou) {
          R::store($data[$this->table]);
          return true;
        }
      }
    }
    return false;
  }

  public function list($column, $order, $searchValue = "", $start, $length)
  {
    if (is_numeric(substr($searchValue, 0, 2))) {
      $dia = substr($searchValue, 0, 2);
      if (is_numeric(substr($searchValue, 3, 2))) {
        $mes = substr($searchValue, 3, 2);
        if (is_numeric(substr($searchValue, 6, 4))) {
          $ano = substr($searchValue, 6, 4);
        }
      }
    }
    if ($column == "login_id")
      $column = "l.email";
    elseif ($column == "telas_id")
      $column = "t.nome";
    elseif ($column == "cadastrar")
      $column = "c.cadastrar";
    elseif ($column == "editar")
      $column = "c.editar";
    elseif ($column == "excluir")
      $column = "c.excluir";
    else
      $column = "l.email";

    //filtro
    $filter = "";
    $filter .= " AND (l.email ILIKE '%$searchValue%'";

    $filter .= " OR (";
    $filter .= " t.nome ILIKE '%$searchValue%'";
    /*
    if (isset($dia)) {
      $filter .= " OR (";
      $filter .= " EXTRACT(DAY FROM vencimento) = " . $dia;
      if (isset($mes)) {
        $filter .= " AND EXTRACT(MONTH FROM vencimento) = " . $mes;
        if (isset($ano)) {
          $filter .= " AND EXTRACT(YEAR FROM vencimento) = " . $ano;
        }
      }
      $filter .= ")";
    }*/
    $filter .= ")";
    $filter .= ")";


    $sql = "
    SELECT c.id, l.email as usuario_id, cadastrar, editar, excluir, t.controller, t.nome as telas_id, tpai.nome as telapainome FROM permissoes c
	  INNER JOIN login l ON l.id = c.usuario_id 
    INNER JOIN telas t ON c.telas_id = t.id
    INNER JOIN telas tpai ON t.menupai_id = tpai.id
    WHERE c.login_id = " . $_SESSION['login_id'] . " AND usuario_id <> " . $_SESSION['login_id'] . "$filter ORDER BY $column $order LIMIT $length OFFSET $start
    ";
    return R::getAll($sql);
  }

  public function verificaMesmoUsuarioETela($dados, $usuario_id, $telas_id) {
    $object = R::findOne($this->table, 'usuario_id = ? AND telas_id = ?', [$usuario_id, $telas_id]);
    if($object) {
      array_push($dados, "usuario_id");
    }
    return $dados;
  }

  public function numRows()
  {
    return R::count($this->table, "login_id = ? AND usuario_id <> ?", [$_SESSION['login_id'], $_SESSION['login_id']]);
  }
}
