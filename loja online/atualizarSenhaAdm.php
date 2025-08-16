

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/atualizarSenhaAdm.css">
        <title>Sistema de compras</title>
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
                        <li><a href="atualizarSenhaAdm.php">AtualizarSenha</a></li>
                        <li><a href="atualizarEmailAdm.php">Atualizar Email</a></li>
                        <li class="atualizarSenhaAdm"><a href="#">Atualizar Senha</a></li>
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
        
            $dados_senha = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        ?>

       <form action="<?php $_SERVER['PHP_SELF']?>" method="post">

            <label for="nova_senha">Nova Senha</label><br>
            <input type="text" name="nova_senha" required class="input-form" autocomplete="off"><br>

            <label for="confirme_nova_senha">Confirme a sua nova senha</label><br>
            <input type="text" name="confirme_nova_senha" required class="input-form" autocomplete="off"><br>

            <input type="submit" value="Atualizar Senha" class="botao">
       </form>

        <?php
        
           if(!empty($dados_senha)){

                include 'BancoDeDados.php';

                $atualizar_senha = new BancoDeDados();

                $atualizar_senha->atualizarSenhaAdm($dados_senha);
           }
        ?>
      </section>
</html>