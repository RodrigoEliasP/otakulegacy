<?php
namespace src\models\classes;

class Users{

    private $nome, $senha, $email, $image = null;

    public function setNome($n){
        $this->nome = $n;
    }
    public function getNome(){
        return $this->nome;
    }
    public function setSenha($s){
        $this->senha = $s;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function setEmail($e){
        $this->email = $e;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setImage($i){
        $this->image = $i;
    }
    public function getImage(){
        return $this->image;
    }
}