<?php

namespace app\models;
use Yii;
use yii\base\model;

class FormAlunos extends model{

public $id_aluno;
public $nome;
public $apelidos;
public $classe;
public $nota_final;

public function rules()
 {
  return [
   ['id_aluno', 'integer', 'message' => 'Id incorrecto'],
   ['nome', 'required', 'message' => 'Campo requerido'],
   ['nome', 'match', 'pattern' => '/^[A-zÀ-ú\s]+$/i', 'message' => 'Sólo se aceptan letras'],
   ['nome', 'match', 'pattern' => '/^.{3,50}$/', 'message' => 'Mínimo 3 máximo 50 caracteres'],
   ['apelidos', 'required', 'message' => 'Campo requerido'],
   ['apelidos', 'match', 'pattern' => '/^[A-zÀ-ú\s\s]+$/i', 'message' => 'Sólo se aceptan letras'],
   ['apelidos', 'match', 'pattern' => '/^.{3,80}$/', 'message' => 'Mínimo 3 máximo 80 caracteres'],
   ['classe', 'required', 'message' => 'Campo requerido'],
   ['classe', 'integer', 'message' => 'Sólo números enteros'],
   ['nota_final', 'required', 'message' => 'Campo requerido'],
   ['nota_final', 'number', 'message' => 'Sólo números'],
  ];
 }
 
}