<?php
require_once('../models/page/header.php');
require_once('../../vendor/autoload.php');

use \hbattat\VerifyEmail;
use \src\models\classes\UsersDao;
use \src\models\classes\Users;


//se o cadastro foi realizado
if(isset($_POST['cadastro'])):
    //passa os inputs para variaveis
    $nome = $_POST['nome'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmar'];
    //verifica se preencheram todos
    if($nome == "" or $email == "" or $senha == "" or $confirmar == ""):

        echo "<script>alert('Preencha Todos os campos')</script>";

    else:
        // se sa senhas digitas são iguas
        if($senha !== $confirmar):

            echo "<script>alert('senhas não estão iguais')</script>";

        else:

            $verify = new VerifyEmail($email,'rodrigo.e2003@hotmail.com');
            // verifica se o email digitado existe
            if(!$verify->verify()):

                echo "<script>alert('Digite um email existente')</script>";

            else:

                $userDao = new UsersDao();
                //limpa a variavel nome de xss
                $erro = false;
                $nome = htmlspecialchars($nome);
                //prepara a senha com um hash
                $senha = password_hash(sha1($senha), PASSWORD_DEFAULT);
                //verifica se o usuário ou o email já foram casatrados
                $listaUsers = $userDao->read();
                if(isset($listaUsers)):
                    foreach($listaUsers as $usuario):
                        if($nome === $usuario['user'] || $email === $usuario['email']):
                            $erro=true;
                            break;
                        endif;
                    endforeach;
                endif;
                
                if($erro):

                    echo "<script>alert('Esse nome de usuário ou email já está casatrado')</script>";

                else:
                    //cria um objeto user
                    $user = new Users();

                    $user->setNome($nome);
                    $user->setSenha($senha);
                    $user->setEmail($email);
                    //cadastra ele no banco de dados
                    $userDao->create($user);
                    //redireciona para a página de login;
                    header('location:../login?sucesso=true');

                endif;
            endif;
        endif;
    endif;

endif;



?>
<div class="container">
    <div class="quadro sobre">
        <h2>
            Crie uma conta em otakulegacy!
        </h1>
        <p>
            Nós somos um site com o objetivo de proporcionar aos otakus uma maneira de registrar seus
            animes favoritos com uma descrição, também disponibilizamos o registro de waifus e lolis(cuidado
            com o FBI).
        </p>
        <img src="../images/site/niconico.gif">
    </div>
    <div class="quadro form">
        <form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
            <h2> Preencha os campos abaixo:</h2>
            <div class="form-group">
                <label>Nome:</label>
                <input type="text" name="nome">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email">
            </div>
            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="senha">
            </div>
            <div class="form-group">
                <label>Confirmar senha:</label>
                <input type="password" name="confirmar">
            </div>
            <div class="form-buttons">
                <button class="btn" type="submit" name="cadastro"> Cadastrar </button>
                <a class="btn" href="../login"> Sair </a>
            </div>
        </form>
    </div>
</div>
<?php
require_once('../models/page/footer.php');
?>