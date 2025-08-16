
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet"  href="estilo/telaPrincipalCliente.css">
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
                        <li class="inicio"><a href="#">Inicio</a></li>
                        <li><a href="telaProdutos.php">Produtos</a></li><!--menu finalizado-->
                        <li><a href="Carrinho.php">Seu carrinho de compras</a></li><!--Menu finalizado-->
                        <li><a href="atualizarDadosCliente.php">Atualizar Dados</a></li><!--menu finalizado-->
                        <li><a href="atualizarSenhaCliente.php">Atualizar Senha</a></li>
                        <li><a href="sairCliente.php">Sair</a></li>
                    </ul>
            </nav>
            <h1>Menu Principal</h1>
       </header>
       
        <section>
            <?php

                include 'BancoDeDados.php';

                $ficha = new BancoDeDados();

                $ficha->telaCliente();
            
            ?>
        </section>
    </body>
</html>