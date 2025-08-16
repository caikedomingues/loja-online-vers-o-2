

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <title>Sistema de Compras</title>
        <link rel="stylesheet" href="estilo/pesquisarProduto.css">
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
                       <li><a href="telaPrincipalAdm.php">inicio</a></li>
                        <li><a href="cadastroProdutos.php">Cadastro de produtos</a></li><!--Menu finalizado-->
                        <li><a href="atualizarSenhaAdm.php">AtualizarSenha</a></li>
                        <li><a href="atualizarEmailAdm.php">Atualizar Email</a></li>
                        <li><a href="EsquecerSenhaAdm.php">Recupere a senha de um administrador</a></li>
                        <li><a href="cadastroAdm.php">Cadastre um novo administrador</a></li><!--Menu finalizado-->
                        <li><a href="atualizarEstoque.php">atualizar estoque</a></li><!--Menu finalizado-->
                        <li><a href="apagarProduto.php">Apagar produto do sistema</a></li><!--Menu finalizado-->
                        <li class="pesquisarProduto"><a href="#">Informações dos produtos</li></a>
                        <li><a href="atualizarPreco.php">Atualize o preço dos produtos</li></a>
                        <li><a href="calcularDesconto.php">Calculadora de Desconto</li></a>
                        <li><a href="sairAdm.php">Sair</li></a>
                    </ul>
            </nav>
            <h1>Menu Principal</h1>
      </header>

      <section>
        <?php
        
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        ?>

        <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
            <label for="nome_produto">Informe o nome do produto</label><br>
            <input type="text" name="nome_produto" required class="input-form" autocomplete="off"><br>

            <input type="submit" value="Pesquisar" class="botao">
        </form>

        <?php

         /*Antes de chamar os metodos vamos verificar se os forms
         foram preenchidos corretamente */
          if(!empty($dados)){

            include 'BancoDeDados.php';

            $pesquisa = new BancoDeDados();

            $pesquisa->pesquisarProduto($dados);
          }
        ?>
      </section>

    </body>
</html>