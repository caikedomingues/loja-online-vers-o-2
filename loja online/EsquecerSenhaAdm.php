

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/EsquecerSenhaAdm.css">
        <title>Sistema de compras</title>
    </head>

    <body>

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
                        <li class="EsquecerSenhaAdm"><a href="#">Recupere a senha de um administrador</a></li>
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
            
                $email_adm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            ?>

            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <label for="email_adm">Informe o email de administrador que foi cadastrado</label><br>
                <input type="text" name="email_adm" required class="input-form" autocomplete="off"><br>

                <input type="submit" value= "enviar email" class="botao">
            </form>

            <?php
                /**Se o form estiver preenchido, vamos instaciar o banco de dados
                 * e chamar o metodo de envio do email.
                 */
                if(!empty($email_adm)){

                    include 'BancoDeDados.php';

                    $email = new BancoDeDados;

                    $email->enviarEmailAdm($email_adm);
                }
            ?>
        </section>
    </body>
</html>