
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
                /*Captura dos valores dos radios */
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            ?>
            <h2>Olá, escolha o seu tipo de usuário</h2>
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <label for="administrador">Administrador</label>
                <!--criação dos radios, é necessário que todos os radios tenham o mesmo name
                e contenham um value que ira direcionar os valores de cada radio-->
                <!--Observação: Cada radio deve ter o seu id próprio-->
                <input type="radio" id="administrador" name="usuario_tipo" class="input-form" value="administrador"><br>

                <label for="cliente">Cliente</label>
                <input type="radio" id="cliente" name="usuario_tipo" class="input-form" value="cliente"><br>

                <input type="submit" value="Login">
            </form>

            <?php

                /*Antes de chamar os metodos vamos verificar se os radios
                possuem algum valor selecionado */
                if(!empty($dados)){

                    /*Após verificar, vamos verificar o tipo de usuario
                    escolhido e realizar a transição para a página escolhida */
                    if($dados['usuario_tipo'] == 'administrador'){

                        header('Location:LoginAdm.php');
                        exit();

                    }else if($dados['usuario_tipo'] == 'cliente'){

                        header('Location:LoginCliente.php');
                        exit();

                    }
                }
            
            ?>
        </section>
    </body>