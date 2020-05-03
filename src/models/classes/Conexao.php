<?php
namespace src\models\classes;

class Conexao{

    private static $instance;

    public static  function getConn() {
        if(!isset(self::$instance)){
            self::$instance = new \PDO('mysql:host=localhost;dbname=animes;charset=utf8','root','');
        }
        return self::$instance;
    }
}