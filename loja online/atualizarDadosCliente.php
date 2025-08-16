<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/atualizarCadastroCliente.css">
        <title>Sistemas de compras</title>
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
                        <li class="atualizarDadosCliente"><a href="#">Atualizar Dados</a></li>
                        <li><a href="atualizarSenhaCliente.php">Atualizar Senha</a></li>
                        <li><a href="sairCliente.php">Sair</a></li>
                    </ul>
            </nav>
            <h1>Menu Principal</h1>
       </header>

       <section>

            <?php

                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                $fotos = $_FILES['fotos']??null;
            ?>

            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">

                <label for="nome">Novo nome</label><br>
                <input type="text" name="nome" required class="input-form" autocomplete="off"><br>

                <label for="email">Novo email</label><br>
                <input type="text" name="email" required class="input-form" autocomplete="off"><br>

                <label for="fotos">Nova foto de perfil</label><br>
                <input type="file" name="fotos" required class="input-file" autocomplete="off"><br>

                <label for="saldo_compra">Novo valor para compras</label><br>
                <input type="number" step="0.005" name="saldo_compra" required class="input-form" autocomplete="off"><br>

                <input type="submit" value="atualizar cadastro" class="botao">
            </form>
        
            <?php
            
              if(!empty($dados)){

                include 'BancoDeDados.php';

                $atualizacao = new BancoDeDados();

                $atualizacao->atualizarCadastroCliente($dados, $fotos);
              }
            
            ?>
       </section>

    </body>
</html>