<?php

namespace app\models;
use Yii;
use yii\base\model;

class ValidarFormularioAjax extends model{
    public $nome;
    public $email;
    
    public function rules(){
        return[
            ['nome','required','message' => 'Campo requerido'],
            ['nome', 'match', 'pattern' => "/^.{3,50}$/",'message'=>'Mínimo 3 e máximo 50 caracteres'],
            ['nome', 'match', 'pattern' => "/^[0-9a-z]+$/i",'message'=>'Só é aceito letras e números'],
            ['email','required','message' => 'Campo requerido'],
            ['email', 'match', 'pattern' => "/^.{5,80}$/",'message'=>'Mínimo 5 e máximo 80 caracteres'],
            ['email','email','message' => 'Formato inválido'],
            ['email','email_existe']
        ];
    }
    
    public function attributeLabels(){
        return [
            'nome' => 'Nome:',
            'email'=> 'Email',
        ];
    }
    
    public function email_existe($attribute, $params){
        $email = ["manuel@gmail.com","antonio@mail.com"];
        foreach($email as $val){
            if($this->email == $val){
                $this->addError($attribute,"O email seleconado existe");
                return true;
            } else{
                return false;
            }
        }
    }
}