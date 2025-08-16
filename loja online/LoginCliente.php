<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/login.css">
        <title>Sistema de compras</title>
    </head>

    <body>
        <section>

            <?php
                /*Captura dos dados */
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            
            ?>

            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" required class="input-form" autocomplete="off"><br>

                <label for="senha">Senha</label>
                <input type="password" name="senha" required class="input-form" autocomplete="off"><br>

                <input type="submit" value="Entrar" class="botao-entrar"><br>
            </form>

            <p><a href="cadastroCliente.php">Não tem uma conta?Clique aqui</a></p>
            <p><a href="EsquecerSenhaCliente.php">Esqueci a senha</a></p>

            <?php

                /*Antes de instanciar os objetos e chamar os metodos */
                if(!empty($dados)){

                    include 'BancoDeDados.php';
                    /*Antes de iniciar o processo é necessário criar uma sessão */
                    session_start();

                    /*instancia dos objetos */
                    $banco_dados = new BancoDeDados();
                    /*Atribuição do objeto e da chamada do metodo em uma variável local */
                    $usuario = $banco_dados->loginCliente($dados);

                    /*se o usuário receber os valores do metodo login cliente, vamos
                    atribir como valor da sessão o cpf do cliente, e realizar a transição para
                    a próxima página */
                    if($usuario){

                    $_SESSION['cpf'] = $usuario['cpf'];

                      echo "<script>alert('Seja Bem vindo'); window.location.href='TelaPrincipalCliente.php';</script>";

                    }else{

                        /*Caso a variável usuário não receba informações, o sistema não ira realizar o login */
                        echo "<script>alert('usuário não encontrado')</script>";
                    }
                }
            
            ?>
        </section>
    </body>
</html>
