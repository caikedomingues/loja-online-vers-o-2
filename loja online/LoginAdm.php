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

                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                ?>

                <h2>Login Administrador</h2>
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <label for="cpf_adm">Cpf</label>
                <input type="text" name="cpf_adm" required class="input-form" autocomplete="off"><br>

                <label for="senha_adm">Senha</label>
                <input type="password" name="senha_adm" required class="input-form" autocomplete="off"><br>

                <input type="submit" value="Entrar" class="botao">
            </form>
            
            <p><a href="mailto:caike.dom@gmail.com">Esqueceu a senha ou teve problemas de login? Envie um email para o administrador.</a></p>
            <?php
            
            
                if(!empty($dados)){

                    include 'BancoDeDados.php';

                    session_start();

                    $banco = new BancoDeDados();

                    $adm = $banco->loginAdm($dados);

                    if($adm){

                        $_SESSION['cpf_adm'] = $adm['cpf_adm'];

                        echo "<script>alert('Seja bem-vindo'); window.location.href='TelaPrincipalAdm.php';</script>";

                    }else{

                        echo "<script>alert('administrador não encontrado')</script>";
                    }
                }
            
            ?>
        </section>
    </body>
</html>