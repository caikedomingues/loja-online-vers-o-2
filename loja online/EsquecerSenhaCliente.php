
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
        <?php

            /*Filtro para capturar o email informado pelo usuário */
            $email = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        ?>

        <section>

            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <label for="email">Informe o email do seu cadastro</label><br>
                <input type="text" name="email" required class="input-form" autocomplete="off"><br>
                <input type="submit" value="Enviar">
            </form>
            <p><a href="loginCliente.php">Voltar para o login</a></p>
            <?php
            
                if(!empty($email)){

                    include 'BancoDeDados.php';

                    $enviar = new BancoDeDados();

                    $enviar->enviarEmailCliente($email);
                }
            ?>
        </section>
    </body>
</html>


 