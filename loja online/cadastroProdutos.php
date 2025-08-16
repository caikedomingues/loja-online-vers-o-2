<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/cadastroProdutos.css">
        <title>Sistema de compras</title>
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
                        <li class="cadastroProdutos"><a href="#">Cadastro de produtos</a></li>
                        <li><a href="atualizarSenhaAdm.php">AtualizarSenha</a></li>
                        <li><a href="atualizarEmailAdm.php">Atualizar Email</a></li>
                        <li><a href="EsquecerSenhaAdm.php">Recupere a senha de um administrador</a></li>
                        <li><a href="cadastroAdm.php">Cadastre um novo administrador</a></li>
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
        
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $fotos = $_FILES['fotos']??null;
        ?>

        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <label= for="codigo_produto">Codigo do produto</label><br>
            <input type="text" name="codigo_produto" required class="input-form" autocomplete="off"><br>

            <label for="quantidade_produto">Quantidade de produtos no estoque</label><br>
            <input type="number" name="quantidade_produto" class="input-form" required autocomplete="off"><br>

            <label for="nome_produto">Nome do produto</label><br>
            <input type="text" name="nome_produto" class="input-form" required autocomplete="off"><br>

            <label for="preco_produto">Preço do produto</label><br>
            <input type="number" step="0.005" name="preco_produto" class="input-form" required autocomplete="off"><br>

            <label for="descricao_produto">Descrição do produto</label><br>
            <input type="text" name="descricao_produto" required class="input-form" required autocomplete="off"><br>

            <label for="prazo_entrega">Prazo de entrega</label><br>
            <input type="text" name="prazo_entrega" class="input-form" required autocomplete="off"><br>

            <label for="fotos">Foto do produto</label><br>
            <input type="file" name="fotos" class="input-file" required autocomplete="off"><br>

            <input type="submit" value="cadastrar produto" class="botao">
        </form>

        <?php

            if(!empty($dados)){

                include 'BancoDeDados.php';

                $cadastro = new BancoDeDados();

                $cadastro->cadastrarProduto($dados,$fotos);
            }
        ?>
      </section>

    </body>
</html>
