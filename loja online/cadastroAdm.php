<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/cadastroAdm.css">
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
                        <li><a href="cadastroProdutos.php">Cadastro de produtos</a></li><!--Menu finalizado-->
                        <li><a href="atualizarSenhaAdm.php">AtualizarSenha</a></li>
                        <li><a href="atualizarEmailAdm.php">Atualizar Email</a></li>
                        <li class="cadastroAdm"><a href="#">Cadastre um novo administrador</a></li>
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
            ?>

            <h2>Cadastro Administrador</h2>

            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <label for="cpf_adm">CPF</label><br>
                <input type="text" name="cpf_adm" required class="input-form" autocomplete="off"><br>
                
                <label for="email_adm">Email</label><br>
                <input type="text" name="email_adm" required class="input-form" autocomplete="off"><br>

                <label for="senha_adm">Crie uma Senha</label><br>
                <input type="text" name="senha_adm" required class="input-form" autocomplete="off"><br>

                <label for="nova-senha-adm">Confirme a sua nova senha</label>
                <input type="text" name="nova-senha-adm" required class="input-form" autocomplete="off"><br>

                <input type="submit" value="Entrar" class="botao">
            
            </form>

            <?php
                
                /*Verifica se os campos possuem valor ou foram preenchidos */
                if(!empty($dados)){

                    include 'BancoDeDados.php';

                    $inserir = new BancoDeDados();

                    $inserir->cadastrarAdm($dados);
            
                }
            ?>

        </section>
    </body>
</html>