

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <title>Sistema de compras</title>
        <link rel="stylesheet" href="estilo/estoque.css">
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
                        <li class="atualizarEstoque"><a href="#">atualizar estoque</a></li>
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

                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            ?>


            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <label for="codigo_produto">Informe o código do produto</label><br>
                <input type="text" name="codigo_produto" required class="input-form" autocommplete="off"><br>

                <label for="quantidade_produto">Quantidade que será acrescentado no estoque</label><br>
                <input type="number" name="quantidade_produto" required class="input-form" autocommplete="off"><br>

                <input type="submit" value="Atualizar estoque" class="botao">
            </form>

            <?php

                /*Antes de chamar os metodos vamos verificar se os campos
                foram preenchidos corretamente. */
                if(!empty($dados)){

                    include 'BancoDeDados.php';

                   $atualizar_estoque = new BancoDeDados();
                
                  $atualizar_estoque->atualizarEstoque($dados);
                }
            ?>
      </section>
    </body>
</html>