<?php
require_once('../models/page/header.php'); 
require_once('../../vendor/autoload.php');

use \src\models\classes\UsersDao;
use \src\models\classes\Conexao;

// se acabou de realizar um cadastro
if(isset($_GET['sucesso'])):

    echo "<script>alert('Email cadastrado com sucesso')</script>";

endif;
//Se tentou logar
if(isset($_POST['login'])):
    // inputs
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    //validação, se preencheu o formulário
    if($nome === "" || $senha === ""):
        //se não
        echo "<script>alert('Preencha os campos antes de enviar')</script>";

    else:
        // se sim
        // instancia do users dao src/models/classes
        $userDao = new UsersDao();
        //passa todos usuarios cadastrados para listaUsers
        $listaUsers = $userDao->read();
        //criptografa a senha
        $senha = sha1($senha);
        //procura o usuario no banco de dados
        foreach($listaUsers as $user):
            if($nome === $user['user']):
                // se existe passa a senha e o id dele para pariaveis
                $verificaSenha = $user['pass'];
                $id = $user['id'];
                break;
            endif;
        endforeach;
        //se o usuario existe
        if(!isset($verificaSenha)):

            echo "<script>alert('Ususário não existe')</script>";

        else:
            //se a senha digitada condiz com a do bd
            if(!password_verify($senha , $verificaSenha)):

                echo "<script>alert('Senha errada')</script>";

            else:
                //se condiz inicia uma sessão e redireciona para a próxima pagina
                session_start();

                $_SESSION['login'] = $id;

            endif;

        endif;

    endif;

endif;

?>
    
<div class="container">
    <div class="login-header">
        <img src="../images/site/kazuma.png">
        <h2>Bem vindo a otakulegacy</h2>
    </div>
    <form class="login-form" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
    <div class="form-input">
        <label>Nome:</label>
        <input class="form-input" type="text" name="nome">
    </div>
    <div class="form-input">
        <label>Senha:</label>
        <input class="form-input" type="password" name="senha">
    </div>
    <div class="form-submit">
        <button class="btn" type="submit" name="login">Entrar</button>
        <marquee><a href="../cadastro">Não tem uma conta? <strong>cadastre-se</strong></a></marquee>
    </div>
    </form>
    
</div>

<?php
require_once('../models/page/footer.php');
?>
