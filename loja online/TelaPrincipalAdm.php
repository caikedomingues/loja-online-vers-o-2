
<!DOCTYPE html>
</html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/telaPrincipalAdm.css">
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
                        <li class="inicio"><a href="#">inicio</a></li>
                        <li><a href="cadastroProdutos.php">Cadastro de produtos</a></li><!--Menu finalizado-->
                        <li><a href="atualizarSenhaAdm.php">AtualizarSenha</a></li>
                        <li><a href="atualizarEmailAdm.php">Atualizar Email</a></li>
                        <li><a href="EsquecerSenhaAdm.php">Recupere a senha de um administrador</a></li>
                        <li><a href="cadastroAdm.php">Cadastre um novo administrador</a></li><!--Menu finalizado-->
                        <li><a href="atualizarEstoque.php">atualizar estoque</a></li><!--Menu finalizado-->
                        <li><a href="apagarProduto.php">Apagar produto do sistema</a></li><!--Menu finalizado-->
                        <li><a href="pesquisarProduto.php">Informações dos produtos</li></a><!--Menu finalizado-->
                        <li><a href="atualizarPreco.php">Atualize o preço dos produtos</li></a><!--Menu finalizado-->
                        <li><a href="calcularDesconto.php">Calculadora de Desconto</li></a><!--Menu finalizado-->
                        <li><a href="sairAdm.php">Sair</li></a>
                    </ul>
            </nav>
            <h1>Menu Principal</h1>
      </header>

      <section>

            <?php

                include 'BancoDeDados.php';

                $informacoes_adm = new BancoDeDados();

                $informacoes_adm->telaAdm();
            ?>
      </section>
    </body>
</html>