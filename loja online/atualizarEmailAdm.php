<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/atualizarEmailAdm.css">
        <title>Sistemas de compras</title>
    </head>

    <header>
             <nav class="menu">
                    <input type="checkbox" class="menu-faketrigger">
                    <div class="menu-lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <ul>
                        <li><a href="telaPrincipalAdm.php">inicio</a></li>
                        <li><a href="cadastroProdutos.php">Cadastro de produtos</a></li><!--Menu finalizado-->
                        <li class="atualizarEmailAdm"><a href="#">Atualizar Email</a></li>
                        <li><a href="atualizarSenhaAdm.php">AtualizarSenha</a></li>
                        <li><a href="atualizarSenhaAdm.php">Atualizar Senha</a></li>
                        <li><a href="EsquecerSenhaAdm.php">Recupere a senha de um administrador</a></li>
                        <li><a href="cadastroAdm.php">Cadastre um novo administrador</a></li><!--Menu finalizado-->
                        <li><a href="atualizarEstoque.php">atualizar estoque</a></li>
                        <li><a href="apagarProduto.php">Apagar produto do sistema</a></li>
                        <li><a href="pesquisarProduto.php">Informações dos produtos</li></a>
                        <li><a href="atualizarPreco.php">Atualize o preço dos produtos</li></a>
                        <li><a href="calcularDesconto.php">Calculadora de Desconto</li></a>
                        <li><a href="sairAdm.php">Sair</li></a>
                    </ul>
            </nav>
            <h1>Menu Principal</h1>
      </header>

      <section>
        <?php

            $dados_email = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        ?>

        <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
            <label for="novo_email">Novo email</label><br>
            <input type="text" name="novo_email" required class="input-form" autocomplete="off"><br>

            <input type="submit" value="Atualizar Email" class="botao">
        </form>

        <?php

           if(!empty($dados_email)){

                include 'BancoDeDados.php';

                $atualizar_email = new BancoDeDados();

                $atualizar_email->atualizarEmailAdm($dados_email);
           }
        ?>
      </section>
</html>