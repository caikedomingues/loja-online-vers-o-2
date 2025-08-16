
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/Telaprodutos.css">
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
                        <li><a href="telaPrincipalCliente.php">Inicio</a></li>
                        <li class="telaProdutos"><a href="#">Produtos</a></li>
                        <li><a href="Carrinho.php">Seu carrinho de compras</a></li>
                        <li><a href="atualizarDadosCliente.php">Atualizar Dados</a></li>
                        <li><a href="atualizarSenhaCliente.php">Atualizar Senha</a></li>
                        <li><a href="sairCliente.php">Sair</a></li>
                    </ul>
            </nav>
            <h1>Menu Principal</h1>
       </header>

       

            <?php

                include 'BancoDeDados.php';

                $produtos = new BancoDeDados();
                
                $produtos->processaSelecao();
                
                $produtos->mostrarProdutos();

                

            ?>

       
    </body>
</html>