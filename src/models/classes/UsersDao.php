<?php
namespace src\models\classes;

class UsersDao{

    public function create(Users $u){

        $sql = 'INSERT INTO `users`( `user`, `pass`, `email`) VALUES (?,?,?)';

        $stmt = Conexao::getConn()->prepare($sql);

        $stmt->bindValue(1, $u->getNome());
        $stmt->bindValue(2, $u->getSenha());
        $stmt->bindValue(3, $u->getEmail());

        $stmt->execute();

    }

    public function read(){

        $sql = 'SELECT * FROM `users` ';

        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0):
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        else:

            return null;

        endif;
    }
    public function update(Users $u){

    }
    public function delete($id){

    }
}