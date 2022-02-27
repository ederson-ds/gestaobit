<?php

namespace App\models;

use App\libraries\Model;
use \R;

class EmailsModel extends Model
{

  public $fieldsName = ['Email', 'Senha'];
  public $fields = ['email', 'senha'];
  public $table = "login";


  public function save($dados)
  {
    if (!$dados['camposInvalidos'] && !$dados['camposVazios'] && !$dados['erro']) {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data[$this->table] = R::load($this->table, $this->id);
        $data[$this->table]->login = R::load($this->table, $_SESSION['login_id']);
        $achou = false;
        foreach ($_POST as $key => $campo) {
          foreach ($this->fields as $field) {
            if ($key == $field) {
              if($this->endsWith($field, "_id") && $campo) {
                $controller = substr($field, 0, -3);
                $data[$this->table]->$controller = R::load($controller, $campo);
              } else if($campo) {
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
    if ($column == "email")
      $column = "c.email";
    elseif ($column == "senha")
      $column = "c.senha";

    //filtro
    $filter = " AND (";
    $filter .= " c.email ILIKE '%$searchValue%'";
    $filter .= " OR c.senha ILIKE '%$searchValue%'";
    $filter .= ")";

    $sql = "
    SELECT id, email, senha FROM $this->table c
    WHERE c.login_id = ".$_SESSION['login_id']."$filter ORDER BY $column $order LIMIT $length OFFSET $start
    ";
    return R::getAll($sql);
  }

  public function verificaMesmoEmail($dados, $id, $email) {
    $object = R::findOne($this->table, 'email = ? AND id != ?', [$email, $id]);
    if($object) {
      return "Email informado já existe";
    }
    return null;
  }
}
