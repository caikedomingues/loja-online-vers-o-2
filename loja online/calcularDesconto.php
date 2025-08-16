
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <title>Sistema de compras</title>
        <link rel="stylesheet" href="estilo/calcularDesconto.css">
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
                        <li><a href="pesquisarProduto.php">Informações dos produtos</li></a><!--Menu finalizado-->
                        <li><a href="atualizarPreco.php">Atualize o preço dos produtos</li></a><!--Menu finalizado-->
                        <li class="calcularDesconto"><a href="#">Calculadora de Desconto</li></a><!--Menu finalizado-->
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
            <label for="preco">Informe o preço do produto que ira receber desconto</label><br>
            <input type="number" step="0.02" name="preco" required class="input-form"><br>

            <label for="desconto">Informe a porcentagem do desconto(apenas numeros)</label><br>
            <input type="number" step="0.02" name="desconto" required class="input-form"><br>

            <input type="submit" value="Calcular" class="botao">

            <p><strong>Aviso:</strong> A página apenas calcula o desconto do produto. Caso queira
             aplicar o desconto, atualize o preço no sistema na página "atualize</p>
             <p>o preço dos produtos".</p>
        </form>

        <?php

            /*Antes de chamar os metodos vamos verificar se os campos foram preenchidos corretamente*/
           if(!empty($dados)){

                include 'BancoDeDados.php';

                $desconto = new BancoDeDados();

                $desconto->calcularDesconto($dados);
           }
        
        ?>
       </section>
    </body>
</html>