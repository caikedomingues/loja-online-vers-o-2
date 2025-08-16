

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE=edge">
        <link rel="stylesheet" href="estilo/cadastroCliente.css">
        <title>Sistema de compra</title>
    </head>
    
    <body>
        <section>
            <?php

                /*Captura dos valores do formulário */
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                /*Captura das informações das fotos escolhidas pelo usuário */
                $fotos = $_FILES['fotos']??null;
            ?>

            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <label for="nome">Nome</label><br>
                <input type="text" name="nome" required class="input-form" autocomplete="off"><br>

                <label for="cpf">CPF<label><br>
                <input type="text" name="cpf" required class="input-form" autocomplete="off"><br>

                <label for="senha">Crie uma senha</label><br>
                <input type="text" name="senha" required class="input-form" autocomplete="off"><br>

                <label for="conf_senha">Confirme a sua senha</label><br>
                <input type="text" name="conf_senha" required class="input-form" autocomplete="off"><br>

                <label for="email">Seu Email</label><br>
                <input type="text" name="email" required class="input-form" autocomplete="off"><br>

                <label for="fotos">Escolha uma foto de perfil</label><br>
                <input type="file" name="fotos" required autocomplete="off" class="input-file"><br>

                <label for="saldo_compra">Valor que você possui em dinheiro</label><br>
                <input type="number" step="0.0005" name="saldo_compra" class="input-form" required autocomplete="off"><br>

                <input type="submit" value="cadastrar" class="botao">
            </form>

            </p><a href="loginCliente.php">Voltar a tela de login</a></p>
            
            <?php

                /*Antes de cadastrar os dados vamos verificar se todos os campos estão
                preenchidos */
                if(!empty($dados)){

                    /*instancia e chamada dos metodos */
                    include 'BancoDeDados.php';

                    $cadastro = new BancoDeDados();

                    $cadastro->cadastrarCliente($dados, $fotos);
                }
            
            ?>
        </section>
    </body>
</html>