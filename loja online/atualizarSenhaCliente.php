

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <title>Sistema de compras</title>
        <link rel="stylesheet" href="estilo/AtualizarSenhaCliente.css">
    </head>

    <body>
    <header>
             <nav class="menu">
                    <input type="checkbox" class="menu-faketrigger">
                    <div class="menu-lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <ul>
                         <li><a href="telaPrincipalCliente.php">Inicio</a></li>
                        <li><a href="telaProdutos.php">Produtos</a></li>
                        <li><a href="Carrinho.php">Seu carrinho de compras</a></li>
                        <li><a href="atualizarDadosCliente.php">Atualizar Dados</a></li>
                        <li class="AtualizarSenhaCliente"><a href="#">Atualizar Senha</a></li>
                        <li><a href="sairCliente.php">Sair</a></li>
                    </ul>
            </nav>
            <h1>Menu Principal</h1>
       </header>

       <section>

            <?php

                $dados_senha = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            ?>

            <form action = "<?php $_SERVER['PHP_SELF']?>" method="post">
                <label for="nova_senha">Nova Senha</label><br>
                <input type="text" name="nova_senha"  required class="input-form" autocomplete="off"><br>

                <label for="confirme_nova_senha">Confirme a sua nova senha</label><br>
                <input type="text" name="confirme_nova_senha" required class="input-form" autocomplete="off"><br>

                <input type="submit" Value="Atualizar senha" class="botao">
            </form>

            <?php
            
                if(!empty($dados_senha)){

                    include 'BancoDeDados.php';
                    
                    $atualizar_senha = new BancoDeDados();

                    $atualizar_senha->atualizarSenhaCliente($dados_senha);
                }
            ?>
       </section>
    </body>
</html>