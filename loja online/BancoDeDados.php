
<?php

    class BancoDeDados{

        /*Metodo que ira se conectar ao banco de dados
        e permitir que o usuário grave e manipule informações */
        private function conexaoBanco(){

            try{

                /*Variável que ira conter a instancia do pdo que recebe como parametro
                o endereço para o banco de dados no mysql */
                $conexao = new PDO('mysql:host=localhost;port=3306;dbname=loja','root','');

                /*Retorno da conexão */
                return $conexao;

            }catch(PDOException $erro){

                /*Se a conexao falhar, vamos informar ao usuário o erro ocorrido. */
                echo "<script>alert('não foi possivel se conectar ao banco de dados: $erro')</script>";
            }
        }

                                                                    /*METODOS PARA CLIENTES */
        /*Metodo que ira cadastrar os clientes no sistema */
        public function cadastrarCliente(array $dados, array $fotos){
            /*Chamada do metodo que ira se conectar ao banco de dados */
            $conexao = $this->conexaoBanco();

            /*Selecao dos dados para verificar se os dados ja existem no sistema */
            $selecao_cliente = $conexao->query("SELECT '".$dados['cpf']."' FROM pessoas WHERE cpf='".$dados['cpf']."'");

            /*Contagem das linhas encontradas */
            $quantidade_linhas = $selecao_cliente->rowCount();

            /*Verificação da quantidade de linhas encontradas */
            if($quantidade_linhas > 0){

                /*Se ja existir um registro, vamos informar ao usuário que o cadastro
                já existe. */
                echo "<script> alert('Esse cliente já existe no sistema')</script>";

            }else{

                /*Se o registro não existir, vamos iniciar o processo de
                cadastro do usuário */

                /*Antes de tudo vamos acessar a pasta que contem a classe
                que será utilizada nesse metodo */
                require_once('classes/Pessoas.php');
                
                /*Instanciasdo objeto */
                $pessoas = new Pessoas();   

                /*chamadas dos metodos setters */

                $pessoas->setNome($dados['nome']);

                $pessoas->setCpf($dados['cpf']);

                $pessoas->setSenha($dados['senha']);

                $pessoas->setEmail($dados['email']);

                /*Na parte das imagens dos clientes, vamos usar o metodo move_uploaded_file
                que ira mover o caminho da imagem pra pasta do nosso projeto */

                /*Caminho da imagem */
                $caminho_imagem = "imagens/".$fotos['name'];

                /*Metodo que ira mover o caminho para a pasta do nosso projeto */
                move_uploaded_file($fotos["tmp_name"], $caminho_imagem);

                $pessoas->setSaldoCompra($dados['saldo_compra']);

                /*Chamadas dos metodos getters */

                $nome_pessoa = $pessoas->getNome();

                $cpf_pessoa = $pessoas->getCpf();

                /*Antes de criar a senha criptografada, vamos verificar se os campos
                "crie a sua senha" e "confirme a sua senha" possuem valores iguais */
                if($pessoas->getSenha() != $dados['conf_senha']){

                    /*Se os campos forem diferentes vamos interromper a execução do metodo e
                    informar ao usuário sobre a falha na inserção */
                    echo "<script>alert('os campos confirme a senha e senha devem ser iguais')</script>";

                    die;
                }

                /*criptografia da senha informada pelo usuário*/
                $senha_pessoa = password_hash($pessoas->getSenha(), PASSWORD_DEFAULT);

                /*Para facilitar a verificação do email vamos excluir os espaços
                em brancos do email */
                $email_pessoa = trim($pessoas->getEmail());

                $saldo_compra_pessoa = $pessoas->getSaldoCompra();

                /*Verificações dos dados antes do cadastro no banco */

                /*verificação da quantidade de  digitos do cpf */
                if(strlen($cpf_pessoa) > 11){

                    /*Se o tamanho for menor que 11 digitos, vamos encerrar a execução do metodo
                    e informar o usuário sobre o erro.  */
                    echo "<script>alert('O cpf deve conter 11 digitos ou menos')</script>";

                    die;
                }

                /*Na verificação do email, vamos usar o filtro_var com parametro FILTER_VALIDATE_EMAIL
                que basicamente verifica se uma string possui o formato basico de um endereço de email 
                como:
                A presença de um caractere @ que separa o nome do usuário do domínio.
                A presença de um domínio válido.
                A presença de um ponto . após o domínio (o ".com")  */
                if(!filter_var($email_pessoa, FILTER_VALIDATE_EMAIL)){

                    /*Se o endereço não for válido, vamos inforrmar o usuário sobre o erro e 
                    encerrar a execução do metodo */
                    echo "<script>alert('por favor digite um email válido')</script>";

                    die;
                }

                /*Inserção dos dados no banco de dados*/
                $insercao_pessoa = $conexao->query("INSERT INTO pessoas(nome, cpf, senha, email, foto, saldo_compra) VALUES('".$nome_pessoa."', '".$cpf_pessoa."','".$senha_pessoa."', '".$email_pessoa."', '".$caminho_imagem."', '".$saldo_compra_pessoa."')");
                echo "<script>alert('Dados cadastrados com sucesso')</script>";
            }
        }


        /*Metodo que ira  enviar o email para o usuário caso ele esqueça a senha*/
        public function enviarEmailCliente(array $email){
            /*chamada para o banco de dados */
            $conexao = $this->conexaoBanco();

            session_start();

            /*Consulta no banco de dados para verificar se o email existe*/
            $selecao_email = $conexao->query("SELECT '".$email['email']."' FROM pessoas WHERE email='".$email['email']."' ");

            /*quantidade de linhas encontradas*/
            $quantidade_linhas = $selecao_email->rowCount();

            /*Se o email for encontrado, vamos iniciar o processo de envio do email*/
            if($quantidade_linhas > 0){

                /*Vamos importar a pasta que contém a classe que será utilizada no metodo*/
                require_once('classes/Pessoas.php');    

                /*Instancia do objeto que será utilizado */
                $pessoas = new Pessoas();

                /*chamada dos metodos setters */
                $pessoas->setEmail($email['email']);

                /*chamada dos metodos getters */
                $pessoas->getEmail();

                /*Criação da variável que ira armazenar a senha temporaria do usuário */
                $senha_temporaria = '';

                /*For que ira gerar 4 numeros aleatórios através
                do metodo rand */
                for($i = 0; $i < 4; $i++){

                    /* vamos concatenar/juntar cada numero á variável senha temporaria
                    com o intuito de formar uma senha de 4 digitos*/
                    $senha_temporaria .= rand(0,9);//Gera números aleatórios entre 0 e 9
                }

                /*Vamos usar uma sessão para armazenar a senha e verificar no login se a senha temporaria
                esta correta*/
                $_SESSION['senha_temporaria'] = $senha_temporaria;

                $destinatario = $pessoas->getEmail(); //quem ira receber o email
                $assunto = 'Recuperação de senha';//titulo/assunto do email
                $mensagem = 'Por favor copie e cole a senha para logar e depois crie uma nova senha de acesso: '.$senha_temporaria;//conteudo da mensagem do email
                $remetente = 'From: caike.dom@gmail.com';//quem ira enviar o email.

                /*Por ultimo, vamos usar o metodo mail para enviar os emails  */
                if(mail($destinatario, $assunto, $mensagem, $remetente)){

                    /*Se o processo de envio funcionar, vamos imprimir uma mensagem informando o envio
                    da mensagem. */
                    echo "<script>alert('email enviado, verifique sua caixa de email')</script>";

                }else{

                    /*Se não der certo, vamos informar o usuário sobre a falha */
                    echo "<script>alert('Falha ao enviar o email')</script>";
                }
                
            }else{

                /*Se o email não existir no sistema, vamos informar que ele não existe */
                echo "<script>alert('O seu email não está no banco de dados')</script>";
            }
        }

        /*Metodo que ira permitir que o usuário do tipo cliente acesse o sistema */
        public function loginCliente(array $dados){
                
                /*Chamada do metodo para se conectar ao banco de dados */ 
                $conexao = $this->conexaoBanco();

                /*consulta do cpf informado pelo usuário */
                $selecao_pessoa = $conexao->query("SELECT * FROM pessoas WHERE cpf='".$dados['cpf']."'");

                /*contagem das linhas encontradas */
                $quantidade_linhas_pessoa = $selecao_pessoa->rowCount();

                if($quantidade_linhas_pessoa > 0){

                    /*Se o cpf existir  vamos iniciar o processo de verificação da senha*/

                    /*primeiro, vamos transformar a coluna da senha em um array associativo */
                    $coluna_senha = $selecao_pessoa->fetch(PDO::FETCH_ASSOC);

                    /*Agora vamos realizar algumas validações para ver se a senha informada condiz com as informações
                    passadas pelo usuário */
                    if(password_verify($dados['senha'], $coluna_senha['senha']) || $dados['senha'] == $_SESSION['senha_temporaria']){

                        /*Se o password_verify for verdadeiro ou o hash passado para o usuário através do email (caso o usuário
                        esqueça a senha) seja igual ao hash armazenado no banco de dados, vamos retornar os dados para armazenar 
                        em uma sessão */
                        return $dados;

                    }

                }else{

                    /*Caso o cpf não seja encontrado vamos encerrar o metodo e imprimir a mensagem de usuario
                    não encontrado */
                    echo "<script>alert('usuário não encontrado')</script>";
                    die;
                }
        }


        /*Metodo que irá mostrar os dados do usuário que logou no sistema */
        public function telaCliente(){

            /*Antes do processo, vamos iniciar uma sessão */
            session_start();

            /*chamada para a conexao com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*vamos atribuir a sessão em uma variável local */
            $cpf_pessoa = $_SESSION['cpf'];

            /*antes de iniciar o processo de impressão do usuário, vamos verificar
            se a sessão foi iniciada */
            if(isset($cpf_pessoa)){

                /*consulta dos dados no banco de dados */
                $selecao_pessoa = $conexao->query("SELECT * FROM pessoas WHERE cpf='".$cpf_pessoa."'");

                /*Transformando as colunas em arrays associativos */
                $coluna_pessoa = $selecao_pessoa->fetch(PDO::FETCH_ASSOC);

                /*impressão dos dados do cliente logado */
                echo "<p>nome: ".$coluna_pessoa['nome']."</p>";

                echo "<p> Email: ".$coluna_pessoa['email']."</p>";

                echo "<p> saldo para compra: ".$coluna_pessoa['saldo_compra']."</p>";

                echo "<p>foto de perfil</p>";

                echo "<img src='".$coluna_pessoa['foto']."' alt='foto de perfil' class='imagem-perfil'>";


            }else{

                /*caso a sessão não seja inicializada, vamos imprimir essa mensagem */
                echo "<script>alert('Erro ao carregar as informações')</script>";
            }
        }


        /*metodo que ira apresentar as informações do produto */
        public function mostrarProdutos(){

            /*Antes de iniciar o processo vamos iniciar a sessão */
            session_start();

            /*chamada para a conexão com o banco de dados */
            $conexao = $this->conexaoBanco();
            
            /*Atribuição da sessão em uma variável local. */
            $cpf_pessoa = $_SESSION['cpf'];

            /*antes de iniciar o processo, vamos verificar se a sessão foi iniciada */
            if(isset($cpf_pessoa)){

                /*Seleção dos dados no banco de dados */
                $selecao_produtos = $conexao->query("SELECT * FROM produtos");

                /*Vamos usar o metodo fetchAll que transforma todas as linhas do banco
                em um array associativo */
                $coluna_produtos = $selecao_produtos->fetchAll(PDO::FETCH_ASSOC);
 
                /*Agora vamos percorrer o banco de dados, criando uma sessão de informações 
                para cada produto */

               foreach($coluna_produtos as $coluna){
                /*Nesse trecho, vamos criar uma sessão e um botão para cada produto*/
                 echo "<section>";
                 /*Criação do formulário */
                 echo "<form action='' method='post'>";
                 /*Input que será utilizado, o value nesse trecho é muito importante, pois ele será
                 parametro do post(superglobal que pode ser utilizada em qualquer parte do código) para
                 realizar consltas e auxiliar na inserção dos dados. */
                 echo "<input type='hidden' name='nome_produto' value='".$coluna['nome_produto']."'>";

                    /*Impressão dos produtos cadastrados no sistema */
                    echo "<p>nome do produto: ".$coluna['nome_produto']."</p>";

                    echo "<p>preço do produto: ".$coluna['preco_produto']."</p>";

                    echo "<p>descricao do produto: ".$coluna['descricao_produto']."</p>";

                    echo "<p> prazo de entrega: ".$coluna['prazo_entrega']."</p>";

                    echo "<p>Imagem do produto</p>";
                    
                    echo "<img src='".$coluna['imagem_produto']."' alt='foto do produto' class='imagem-perfil'>";

                    echo "<input type='submit' name='adicionar_carrinho' value='Adicionar ao carrinho'>";
                 echo "</form>";
                    
                 echo "</section>";
               }


            }else{

                /*Caso a sessão não seja iniciada, vamos imprimir essa mensagem */
                echo "<script>alert('Erro no sistema, tente novamente mais tarde')</script>";
            }

        }

        /*Metodo que irá processar a escolha e adicionar o produto no carrinho de compras do usuário */
        public function processaSelecao(){
            
            /*Inicio da sessão */
            session_start();

            /*Atribuição da sessão a uma variável local */
            $cpf_pessoa = $_SESSION['cpf'];

            /*Chamada do metodo para conexão com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*Antes de iniciar o processo de insercao, vamos verificar se o botão foi
             acionado e se o value possui valor. Para acessar os campos do form
             e  o nome do botão, vamos usar a superglobal $_POST*/
            if(isset($_POST['adicionar_carrinho']) && isset($_POST['nome_produto'])){

                /*Variável post que ira conter o nome do form que será 
                utilizado*/
                $nome_produto = $_POST['nome_produto'];

                /*Selecao dos produtos selecionados pelo usuário*/
                $selecao_produto = $conexao->query("SELECT * FROM produtos WHERE nome_produto ='".$nome_produto."' ");

                /*Transformando os produtos selecionados em arrays associativos */
                $coluna_produto_selecionado = $selecao_produto->fetch(PDO::FETCH_ASSOC);

                /*Antes de inserir produtos no carrinho, vamos verificar se a consulta foi bem sucedida*/
                if($coluna_produto_selecionado){

                    /*Após realizar a consulta, vamos verificar se há produtos no estoque  */
                    if($coluna_produto_selecionado['quantidade_produto'] <= 0){

                        /*Caso o estoque esteja vázio, vamos imprimir uma mensagem e atribuir 0
                        na coluna de quantidade de produtos */
                        echo "<script>alert('produto esgotado')</script>";

                        $atualizar_quantidade_produto = $conexao->query("UPDATE produtos set quantidade_produto = 0 WHERE nome_produto = '".$nome_produto."'");

                    }else{

                        /*Caso haja produtos no estoque, vamos inserir o produto no carrinho */
                          /*Inserção dos produtos no carrinho */
                         $insercao_carrinho = $conexao->query("INSERT INTO carrinho (codigo_produto_adquirido,nome_produto_adquirido, preco_produto_adquirido, prazo_entrega_produto_adquirido, dono_carrinho, imagem_produto_adquirido) VALUES ('".$coluna_produto_selecionado['codigo_produto']."','".$coluna_produto_selecionado['nome_produto']."', '".$coluna_produto_selecionado['preco_produto']."', '".$coluna_produto_selecionado['prazo_entrega']."', '".$cpf_pessoa."', '".$coluna_produto_selecionado['imagem_produto']."')");

                        /*mensagem de aviso sobre a inserção */
                         echo "<script>alert('produto adicionado ao carrinho')</script>";
                    }
                  

                }else{

                    /*Mensagem que será exibida caso o sistema não adicione o produto no carrinho */
                    echo "<script>alert('Não foi possivel adicionar o produto no carrinho. Tente novamente mais tarde')</script>";
                }
              
            }


        }

        /*Metodo que irá mostrar os produtos adicionados no carrinho pelo
        usuário */
        public function mostrarCarrinho(){

            /*inicio da sessão */
            session_start();

            /*Vamos atribuir a sessão em uma variável local */
            $cpf_pessoa = $_SESSION['cpf'];

            /*Chamada da conexão com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*Antes de iniciar todo o processo, vamos verificar se a sessão foi 
            iniciada */
            if(isset($cpf_pessoa)){
                
                /*Vamos selecionar os dados dos produtos adicionados no carrinho */
                $selecao_carrinho = $conexao->query("SELECT * FROM carrinho WHERE dono_carrinho = '".$cpf_pessoa."'");

                /*Vamos transformar os valores encontrados em colunas */
                $coluna_carrinho = $selecao_carrinho->fetchAll(PDO::FETCH_ASSOC);

                /*Vamos fazer um for que ira percorrer o banco de dados
                e criar uma sessão para cada produto adicionado */
                foreach($coluna_carrinho as $coluna){

                    /*Criação da sessão onde cada form terá um botão para o usuário remover os produtos
                    do carrinho */
                    echo "<section>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='nome_produto_adquirido' value='".$coluna['nome_produto_adquirido']."'>";
                    echo "<p>Código do produto: ".$coluna['codigo_produto_adquirido']."</p>";
                    echo "<p>nome do produto: ".$coluna['nome_produto_adquirido']."</p>";
                    echo "<p>preço do produto: ".$coluna['preco_produto_adquirido']."</p>";
                    echo "<p>prazo de entrega: ".$coluna['prazo_entrega_produto_adquirido']."</p>";
                    echo "<img src='".$coluna['imagem_produto_adquirido']."' alt='foto do produto' class='imagem-perfil'>";
                    echo "<input type='submit' name='limpar_carrinho' value='Remover do carrinho'>";
                    echo "</form>";
                    echo "</section>";
                }

                echo "<section>";
                echo "<form action='' method='post'>";
                echo "<input type='submit' name='comprar' value='Comprar Produtos' class='botao'>";
                echo "</section>";
            }else{

                /*Mensagem que será emitida caso a sessão não seja inicializada */
                echo "<script>alert('Erro no sistema, por favor, tente novamente mais tarde')</script>";
            }
        }

        /*Metodo que ira remover o item escolhido pelo usuário */
        public function limparCarrinho(){

            /*inicio da sessão */
            session_start();

            /*atribuição da sessão em uma variável local */
            $cpf_pessoa = $_SESSION['cpf'];

            /*Chamada da conexão com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*Antes de iniciar o processo, vamos verificar se o botão de 
            remover item foi selecionado. */
            if(isset($_POST['limpar_carrinho'])){

                /*Atribuição do nome do form em uma variável local */
                $nome_produto_adquirido = $_POST['nome_produto_adquirido'];

                /*selecao dos produtos adicionados no carrinho */
                $selecao_carrinho = $conexao->query("SELECT * FROM carrinho WHERE dono_carrinho = '".$cpf_pessoa."' AND nome_produto_adquirido='".$nome_produto_adquirido."'");

                /*Transformando os produtos adicionados em colunas */
                $coluna_carrinho = $selecao_carrinho->fetchAll(PDO::FETCH_ASSOC);

                /*Antes de realizar o processo de exclusão, vamos verificar se os dados
                foram selecionados / retornados */
                if($coluna_carrinho){
                    
                    /*Exxlusão do item escolhido */
                    $limpar_carrinho = $conexao->query("DELETE FROM carrinho WHERE dono_carrinho = '".$cpf_pessoa."' AND nome_produto_adquirido = '".$nome_produto_adquirido."'");

                    /*Mensagem da exclusão */
                    echo "<script>alert('Item removido do carrinho')</script>";

                }else{

                    /*mensagem que será exibida caso a exclusão não funcione */
                    echo "<script>alert('não foi possivel remover o produto do carrinho')</script>";
                }


            }
        }

        /*metodo que irá realizar a compra dos produtos do usuário */
        public function comprarProdutos(){

            /*Como nos outros metodos ja vamos ter uma sessão iniciada, nessa etapa do código
            não vamos precisar iniciar a sessão novamente */

            /*atribuição da sessão em uma variável local */
            $cpf_pessoa = $_SESSION['cpf'];

            /*Chamada da conexao com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*antes de iniciar o processo, vamos verificar se o botão de compra
            foi acionado */
            if(isset($_POST['comprar'])){

                /*Vamos selecionar os dados dos produtos adicionados no carrinho */
                $selecao_carrinho = $conexao->query("SELECT * FROM carrinho WHERE dono_carrinho='".$cpf_pessoa."'");

                /*Vamos selecionar os dados do usuário logado no sistema */
                $selecao_pessoa = $conexao->query("SELECT * FROM pessoas WHERE cpf='".$cpf_pessoa."'");

                /*Transformando os produtos adicionados em colunas */
                $coluna_carrinho = $selecao_carrinho->fetchAll(PDO::FETCH_ASSOC);

                /*Transformando os dados do usuário em colunas */
                $coluna_pessoa = $selecao_pessoa->fetch(PDO::FETCH_ASSOC);

                /*Variável que ira conter o total de compras do usuário que terá
                como valor inicial o valor 0. */
                $total = 0;

                /*Para calcular o total vamos percorrer a coluna do carrinho 
                somando os valores da coluna de preços dos produtos adicionados
                no carrinho */
                foreach($coluna_carrinho as $coluna){

                        $total = $total + $coluna['preco_produto_adquirido']; 
                    }
                   
                /*Antes de realizar o ato da compra vamos verificar se o total
                da compra é maior que o saldo de compra do usuário */
                if($total > $coluna_pessoa['saldo_compra']){

                        /*Se o saldo for menor que o  total de compras, vamos interromper a 
                        compra e imprimir uma mensagem */
                        echo "<script>alert('Saldo insuficiente para a compra')</script>";

                }else{

                        /*Se o saldo for suficiente, vamos iniciar o processo de compra do produto */

                        /*Vamos debitar da conta do usuário o valor da conta */
                        $atualizar_pessoa = $conexao->query("UPDATE pessoas set saldo_compra = saldo_compra - '".$total."' WHERE cpf='".$cpf_pessoa."'");

                        /*Depois, vamos percorrer a coluna do carrinho e tirar a quantidade necessária de produtos 
                        do estoque */
                        foreach($coluna_carrinho as $coluna){

                            $atulizar_produto = $conexao->query("UPDATE produtos set quantidade_produto = quantidade_produto - 1 WHERE codigo_produto = '".$coluna['codigo_produto_adquirido']."'");
                            
                        }
                        /*Após a finalização da etapa de compras, vamos iniciar o processo de envio
                        de emails */

                        $destinatario = $coluna_pessoa['email'];//Email do usuário que ira receber a mensagem
                        $assunto = "Suas compras no sistema";//Titulo/assunto do email
                        /*Mensagem que ira conter as informações da compra do usuário*/$mensagem = "<html>
                                  <body>
                                  <p>Obrigado pela preferencia</p>
                                  Total: ".$total." reais </p>";
                        /*será necessário percorrer a coluna do carrinho
                        para pegar os dados de cada produto adicionado nele */
                        foreach($coluna_carrinho as $coluna){
                        /*impressão das informações da compra */
                        $mensagem.="<p>Código do produto: " . $coluna['codigo_produto_adquirido']."</p>".
                       "<p>Nome do produto: " . $coluna['nome_produto_adquirido']."</p>".
                        "<p>Preço do produto: " . $coluna['preco_produto_adquirido']."</p>";
                        "<p>Prazo de entrega: " . $coluna['prazo_entrega_produto_adquirido']."</p>";
                        }

                        $mensagem.="</body></html>";
                        
                        $remetente = 'caike.dom@gmail.com';//Quem ira enviar as mensagens para o usuário
                        
                        /*O conteudo da variável conversao_html terá como finalidade configurar
                        o texto da mensagem no formato da linguagem de marcação html */
                        $conversao_html = "MIME-Version: 1.0" . "\r\n";/*serve para que os clientes de emails fiquem cientes sobre o conteudo MIME, que pode ser em formato de textos simples, html e anexos */

                        /*serve para especificar o conjunto de caracteres utilizado no email. Esse trecho é importante para garantir que a mensagem seja renderizada ou interpretada como html. */
                        $conversao_html .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                        /*Define o endereço do remetente */
                        $conversao_html .= "From: " . $remetente . "\r\n";

                        /*Chamada do metodo com seus parametros */
                        mail($destinatario, $assunto, $mensagem, $conversao_html);

                        /*Impressão das mensagens que irão informar sobre o sucesso da realização da compra */
                        echo "<script>alert('Compra realizada com sucesso, por favor verifique a sua caixa de email')</script>";

                        echo "<script>alert('Total da compra: {$total}')</script>";

                        /*Após a compra, vamos limpar o carrinho do usuário para realizar futuramente o cáculo do valor da compra de maneira correta. */
                        $limpar_carrinho = $conexao->query("DELETE FROM carrinho WHERE dono_carrinho = '".$cpf_pessoa."'");

                    
                    }
            }

        }


        /*metodo que ira atualizar os dados do usuário*/
        public function atualizarCadastroCliente(array $dados, array $fotos){

            /*Inicio da sessão */
            session_start();

            /*atribuição da sessão e uma variável local */
            $cpf_pessoa = $_SESSION['cpf']; 

            /*Chamada do metodo de conexao */
            $conexao = $this->conexaoBanco();

            /*Antes de iniciar o processo, vamos verificar se a sessão foi iniciada */
            if(isset($cpf_pessoa)){

                /*Import da pasta que contém a classe que será utilizada no
                método */
                require_once('classes/Pessoas.php');

                /*instancia do objeto */
                $pessoa = new Pessoas();
    
                /*chamada dos metodos setters */
                $pessoa->setNome($dados['nome']);
    
                $pessoa->setEmail($dados['email']);
    
                $pessoa->setSaldoCompra($dados['saldo_compra']);

                /*chamada dos metodos getters */

                $nome_pessoa = $pessoa->getNome();

                $email_pessoa = $pessoa->getEmail();

                /*verificação do endereço de email usando o filtro
                filter_var */
                if(!filter_var($email_pessoa, FILTER_VALIDATE_EMAIL)){

                    /*Se o endereço for inválido, vamos imprimir uma mensagem e encerrar
                    a execução do metodo */
                    echo "<script>alert('Por favor digite um email válido')</script>";

                    die;
                }

                $saldo_compra_pessoa = $pessoa->getSaldoCompra();

                /*Processo de envio das fotos para o banco de dados */
                $caminho_foto = "imagens/".$fotos['name'];

                move_uploaded_file($fotos["tmp_name"], $caminho_foto);

                /*Atualização dos dados */
                $atualizar_nome_pessoa = $conexao->query("UPDATE pessoas set nome='".$nome_pessoa."' WHERE cpf='".$cpf_pessoa."'");

                $atualizar_email_senha = $conexao->query("UPDATE pessoas set email='".$email_pessoa."' WHERE cpf='".$cpf_pessoa."'");

                $atualizar_foto_pessoa = $conexao->query("UPDATE pessoas set foto='".$caminho_foto."' WHERE cpf='".$cpf_pessoa."'");

                $atualizar_saldo_pessoa = $conexao->query("UPDATE pessoas set saldo_compra='".$saldo_compra_pessoa."' WHERE cpf='".$cpf_pessoa."'");

                /*Mensagem que indica o sucesso da atualização dos dados */
                echo "<script>alert('Dados atualizados com sucesso')</script>";


            }else{

                /*Caso a sessão não tenha sido inicializada, vamos imprimir essa mensagem */
                echo "<script>alert('Não foi possivel carregar a página, tente novamente mais tarde')</script>";
            }
        }

        /*Metodo responsável por atualizar as senhas do cliente */
        public function atualizarSenhaCliente(array $dados_senha){

            /*Inicio da sessão */
            session_start();

            /*Chamada da conexão com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*Atribuição da sessão em uma variável local */
            $cpf = $_SESSION['cpf'];

            /*Antes de iniciar o processo de atualização de senha,
            vamos verificar se a sessão foi iniciada */
            if(isset($cpf)){

                /*Import da classe que vamos utilizar no metodo */
                require_once 'classes/Pessoas.php';

                /*Instancia do objeto */
                $pessoa = new Pessoas();

                /*Chamada dos metodos setters */

                $pessoa->setSenha($dados_senha['nova_senha']);

                /*Verificação dos campos nova senha e confirme nova senha */
                if($pessoa->getSenha() != $dados_senha['confirme_nova_senha']){

                    /*Se os campos possuirem valores diferentes, vamos imprimir uma mensagem e encerrar
                    a execução do metodo */
                    echo "<script>alert('Os campos nova senha e confirme nova senha devem ser iguais')</script>";

                    die;
                }

                /*Criptografia da nova senha */
                $nova_senha_pessoa = password_hash($pessoa->getSenha(), PASSWORD_DEFAULT);

                /*Atualização da senha */
                $atualizar_senha = $conexao->query("UPDATE pessoas SET senha = '".$nova_senha_pessoa."' WHERE cpf='".$cpf."'");

                /*Mensagem que ira indicar que atualização foi realizada com sucesso */
                echo "<script>alert('Senha atualizada com sucesso')</script>";

            }else{

                /*Se a sessão não for inicializada vamos imprimir essa mensagem */
                echo "<script>alert('Não foi possivel carregar a página, tennte novamente mais tarde')</script>";
            }
        }
                                                        /*METODOS PARA ADMINISTRADORES */
        /*metodo que ira permitir que o administrador realize login no sistema */
       public function loginAdm(array $dados){

            /*Chamada do metodo que ira se conectar ao banco de dados */
            $conexao = $this->conexaoBanco();

            /*Consulta dos dados informados pelo usuário */
            $selecao_adm = $conexao->query("SELECT * FROM administradores WHERE cpf_adm='".$dados['cpf_adm']."'");

            /*quantidade de linhas encontradas */
            $quantidade_linhas_adm = $selecao_adm->rowCount();

            if($quantidade_linhas_adm > 0){

                /*Se o cpf for encontrado, vamos verificar a senha */
                $coluna_senha_adm = $selecao_adm->fetch(PDO::FETCH_ASSOC);

                if(password_verify($dados['senha_adm'], $coluna_senha_adm['senha_adm']) || $dados['senha_adm'] == $_SESSION['senha_temporaria_adm']){

                    /*Se o password_verify for verdadeiro ou o hash passado para o administrador através do email (caso o administrador
                    esqueça a senha) seja igual ao hash armazenado no banco de dados, vamos retornar os dados para armazenar 
                    em uma sessão */
                    return $dados;

                }

            }else{

                /*Se o cpf do adiministrador não for encontrado, vamos informar ao usuário */
                echo "<script>alert('Administrador não encontrado')</script>";
            }
       }

       /*Metodo que ira enviar a senha do administrador via email */
       public function enviarEmailAdm(array $email_adm){

            session_start();

            /*Chamada para o metodo que ira se conectar ao banco de dados */
            $conexao = $this->conexaoBanco();
            /*consultado do email informado pelo usuário */
            $selecao_email_adm = $conexao->query("SELECT * FROM administradores WHERE email_adm = '".$email_adm['email_adm']."'");

            /*Quantidade de linhas encontradas */
            $quantidade_linhas_email = $selecao_email_adm->rowCount();

            if($quantidade_linhas_email > 0){

                /*Se o email for encontrado, vamos iniciar o processo de
                envio de email */

                /*Import da pasta que ira conter a classe que será utilizada
                no metodo */
                require_once('classes/Administradores.php');

                /*Instancia do objeto */
                $adm = new Administradores();

                /*Getters e setters da classes */
                $adm->setEmailAdm($email_adm['email_adm']);

                $email = $adm->getEmailAdm();

                $senha_temporaria_adm= '';

                for($i = 0; $i < 4; $i++){

                    $senha_temporaria_adm.= rand(0,9);
                }

                $_SESSION['senha_temporaria_adm'] = $senha_temporaria_adm;

               /*Atributos do email */ 
                $destinatario = $email; //quem vai receber o email
                $assunto ='recuperação da senha';//titulo/ assunto do email
                $mensagem = 'Copie e cole esse código e ao entrar altere a sua senha: '.$senha_temporaria_adm;//mensagem que ira conter a senha do usuário
                $remetente = 'From: caike.dom@gmail.com';//quem envio o email para o administrador

                /*Vamos verificar se o metodo mail realizou o envio do email */
                if(mail($destinatario, $assunto, $mensagem, $remetente)){

                    /*Se o email for bem sucedido, apresentaremos essa mensagem */
                    echo "<script>alert('Email enviado, por favor verifique a sua caixa de mensagens')</script>";

                }else{

                    /*Se o email falhar, apresentaremos essa mensagem */
                    echo "<script>alert('Falha ao enviar o email, tente novamente')</script>";
                }

            }else{
                /*Se o email não for encontrado, vamos apresentar essa mensagem */
                echo "<script>alert('email não encontrado no sistema')</script>";
            }

       }

       /*Metodo que ira mostrar as informações do adm logado */
       public function telaAdm(){

            /*Antes de iniciar qualquer processo, vamos criar uma sessão */
            session_start();
            /*Chamada do metodo que ira se conectar ao banco de dados */
            $conexao = $this->conexaoBanco();

            /*Vamos atribuir a sessão em uma variável local */
            $cpf_adm = $_SESSION['cpf_adm'];

            /*Antes de iniciar o processo de impressão dos dadoss, vamos verificar
            se a sessão foi inicializada */
            if(isset($cpf_adm)){

                /*Consulta dos dados no banco de dados */
                $selecao_adm = $conexao->query("SELECT * FROM administradores WHERE cpf_adm='".$cpf_adm."'");

                /*transformando as colunas em um array associativo */
                $colunas_adm = $selecao_adm->fetch(PDO::FETCH_ASSOC);

                /*impressão dos dados do administrador logado */
                echo "<p>Cpf do administrador: ".$colunas_adm['cpf_adm']."</p>";

                echo "<p>Email do administrador: ".$colunas_adm['email_adm']."</p>";

            }else{
                /*se a sessão não for iniciada, vamos imprimir essa mensagem  */
                echo "<script>alert('alert não foi possivel carregar as informações do administrador')</script>";
            }



       }

       /*Metodo responsavel por atualizar a senha de administradores */
       public function atualizarSenhaAdm(array $dados_senha){

            /*Antes de tudo, vamos iniciar a sessão */
            session_start();

            /*Chamada da conexão com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*Atribuição da sessão a uma variável local */
            $cpf_adm = $_SESSION['cpf_adm'];

            /*Antes de iniciar a atualização de senha, vamos verificar
            se a sessão foi iniciada */
            if(isset($cpf_adm)){

                /*import da classe que será utilizada no metodo */
                require_once 'classes/Administradores.php';

                /*Instancia do objeto */
                $adm = new Administradores();

                /*chamada dos metodos setters */

                $adm->setSenhaAdm($dados_senha['nova_senha']);

                /*Antes de atualizar, vamos verificar se os campos nova senha e confirme
                nova senha são iguais */
                if($adm->getSenhaAdm() != $dados_senha['confirme_nova_senha']){

                    /*Se os campos forem iguais vamos apresentar uma mensagem e encerrar a execução do metodo */
                    echo "<script>alert('Os campos nova senha e confirme a sua senha devem ser iguais')</script>";

                    die;
                }

                /*Criptografia da nova senha */
                $nova_senha_adm = password_hash($dados_senha['nova_senha'], PASSWORD_DEFAULT);

                /*Atualização da senha */
                $atualizar_senha_adm = $conexao->query("UPDATE administradores SET senha_adm = '".$nova_senha_adm."' WHERE cpf_adm='".$cpf_adm."'");

                /*Mensagem indicando a atualização da senha */
                echo "<script>alert('Senha atualizada com sucesso')</script>";
            }
       }

       /*Metodo responsável por atualizar o email dos administradores */
       public function atualizarEmailAdm(array $dados_email){

            /*Inicio da sessão */
            session_start();

            /*Chamada da conexão com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*Atribuição da sessão a uma variável local */
            $cpf_adm = $_SESSION['cpf_adm'];

            /*Antes de iniciar a atualização, temos que verificar se 
            a sessão foi iniciada */
            if(isset($cpf_adm)){

                /*Atualização do email do adm */
                $atualizar_email_adm = $conexao->query("UPDATE administradores SET email_adm = '".$dados_email['novo_email']."' WHERE cpf_adm='".$cpf_adm."'");

                /*Mensagem indicando o sucesso da atualização */
                echo "<script>alert('email atualizado com sucesso')</script>";

            }else{  

                /*Mensagem que será apresentada se a sessão não for iniciada */
                echo "<script>alert('Erro ao carregar a página')</script>";
            }
       }

       /*metodo que ira cadastrar produtos no sistema */
       public function cadastrarProduto(array $dados, array $fotos){

            /*antes de iniciar o processo de cadastro de produtos, vamos
            criar uma sessão */
            session_start();

            /*chamada da conexao com o banco de dados */
            $conexao = $this->conexaoBanco();

            /**atribuição da sessão em uma variável local */
            $cpf_adm = $_SESSION['cpf_adm'];

            /*Antes de iniciar o processo de cadastro dos produtos, vamos verificar
            se a sessão foi iniciada */
            if(isset($cpf_adm)){
                
               /*Primeiro vamos consultar o codigo informado pelo usuário */ 
                $selecao_produto = $conexao->query("SELECT * FROM produtos WHERE codigo_produto ='".$dados['codigo_produto']."'");

                /*contagem das linhas encontradas */
                $quantidade_linhas = $selecao_produto->rowCount();

                /*Se o código ja existir no sistema vamos imprimir uma mensagem e 
                encerrar o processo de cadastro */
                if($quantidade_linhas > 0){

                    echo "<script>alert('esse codigo já pertence a um produto, por favor digite um novo código')</script>";

                }else{

                    /*se o codigo não existir, vamos iniciar o processo de cadastro do produto */

                    /*Vamos importar a pasta que ira conter a classe que iremos utilizar no metodo */
                   require_once('classes/Produtos.php');

                   /*instancia da classe */
                   $produtos = new Produtos();

                   /*chamadas dos metodos setters */

                   $produtos->setCodigoProdutos($dados['codigo_produto']);
                   $produtos->setQuantidade($dados['quantidade_produto']);
                   $produtos->setNomeProduto($dados['nome_produto']);
                   $produtos->setPrecoProduto($dados['preco_produto']);
                   $produtos->setDescricaoProduto($dados['descricao_produto']);
                   $produtos->setPrazoEntrega($dados['prazo_entrega']);

                   /*preparação do envio de fotos */
                   /*caminho da imagem dos produtos que serão ofertados */
                   $caminho_imagens = "ImagensProdutos/".$fotos['name'];

                   /*metodo que ira mover o caminho da pasta do servidor para a pasta 
                   do nosso projeto */
                   move_uploaded_file($fotos["tmp_name"], $caminho_imagens);

                   /*chamada dos metodos getters */

                   $codigo_produto = $produtos->getCodigoProduto();

                   $quantidade_produto = $produtos->getQuantidade();

                   $nome_produto = $produtos->getNomeProduto();

                   $preco_produto = $produtos->getPrecoProduto();

                   $descricao_produto = $produtos->getDescricaoProduto();

                   $prazo_entrega = $produtos->getPrazoEntrega();

                   /*Antes de inserir os dados, vamos verificar a quantidade de digitos
                   do codigo do produto */
                   if(strlen($codigo_produto) > 4){

                        /*Se o codigo do produto tiver mais que 4 digitos, vamos imprimir uma 
                        mensagem e encerrar a execução do metodo */
                        echo "<script>alert('o codigo deve conter 4 digitos ou menos')</script>";

                        die;
                   }

                   /*inserção dos dados do produto */
                   $insercao_produto = $conexao->query("INSERT INTO produtos(codigo_produto, quantidade_produto, nome_produto, preco_produto, descricao_produto, prazo_entrega, imagem_produto) VALUES('".$codigo_produto."', '".$quantidade_produto."', '".$nome_produto."', '".$preco_produto."', '".$descricao_produto."', '".$prazo_entrega."', '".$caminho_imagens."')");

                   echo "<script>alert('Produto cadastrado com sucesso')</script>";

                }
                
            }else{
                /*Se a sessão não for iniciada, vamos imprimir essa mensagem. */
                echo "<script>alert('Erro ao carregar a página de cadastros, por favor, tente novamente mais tarde')</script>";
            }
       }

       /*metodo que ira cadastrar novos administradores */
       public function cadastrarAdm(array $dados){

        /*inicio da sessão */
        session_start();

        /*chamada da conexão com o banco de dados */
        $conexao = $this->conexaoBanco();

        /*Atribuição da sessão em uma variável local */
        $cpf_adm = $_SESSION['cpf_adm'];

        /*Antes de iniciar o processo de inserção, vamos verificar se a sessão foi iniciada */
        if(isset($cpf_adm)){

            /*Selecao/consulta dos cpfs de administradores */
            $selecao_adm = $conexao->query("SELECT cpf_adm FROM administradores WHERE cpf_adm='".$dados['cpf_adm']."'");

            /*Contagem das linhas encontradas */
            $quantidade_linhas_adm = $selecao_adm->rowCount();

            /*Antes de inserir os dados vamos verificar se as informações ja inseridas
            no sistema ja existem */
            if($quantidade_linhas_adm > 0){

                /*Se o registro ja existir, vamos imprimir essa mensagem */
                echo "<script>alert('Esse administradorjá existe no sistema')</script>";

            }else{

                /*Caso não exista, vamos iniciar o processo de inserçao dos dados */

                /*Import da pasta que contém a classe que será utilizada no metodo */
                require_once('classes/Administradores.php');

                /*Instancia do objeto  */
                $adm = new Administradores();
    
                /*chamada dos metodos setters */
    
                $adm->setCpfAdm($dados['cpf_adm']);
    
                $adm->setEmailAdm($dados['email_adm']);
    
                $adm->setSenhaAdm($dados['senha_adm']);
    
                /*chamada do metodos getters */
    
                $cpf_administrador = $adm->getCpfAdm();
    
                $email_administrador = $adm->getEmailAdm();
                
                /*Verificação se os campos senha e confirme senha são
                iguais */
                if($adm->getSenhaAdm() != $dados['nova-senha-adm']){
                    
                    /*Se os campos senha e confirme a sua senha forem diferentes,
                    vamos imprimir a mensagem e encerrar a execução do metodo */
                    echo "<script>alert('Os campos senha e confirme a sua senha devem ser iguais')</script>";
    
                    die;
                }
                
                /*Criptografia da senha do usuário */
                $senha_administrador = password_hash($adm->getSenhaAdm(), PASSWORD_DEFAULT);
                
                /*Verificação da quantidade de digitos que o campo cpf possui */
                if(strlen($cpf_administrador) > 11){
                    
                    /*Se o campo do cpf possuir mais de 11 digitos, vamos imprimir essa mensagem e
                    e encerrar a execução do metodo */
                    echo "<script>alert('o cpf deve conter 11 digitos ou menos')</script>";
    
                    die;
                }
                
                /*Vamos verificar se o endereço do email informado é um endereço válido
                usando o filter_var */
                if(!filter_var($email_administrador, FILTER_VALIDATE_EMAIL)){
                    
                    /* o endereço for inválido, vamos imprimir essa mensagem e encerrar 
                    a execução do metodo*/
                    echo "<script>alert('por favor digite um email válido')</script>";
    
                    die;
                }
                
                /*Inserção do novo administrador no banco de dados */
                $insercao_administrador = $conexao->query("INSERT INTO administradores(cpf_adm, email_adm, senha_adm) VALUES('".$cpf_administrador."', '".$email_administrador."', '".$senha_administrador."')");
                
                /*Mensagem que ira indicar que o processo de inserção foi inserido com sucesso */
                echo "<script>alert('Novo administrador adicionado no sistema')</script>";
            }

           
        }else{

            /*mensagem que ira ser exibida se a sessão não for iniciada */
            echo "<script>alert('erro ao carregar a página, por favor, tente novamente mais tarde')</script>";
        }

       }

       /*metodo que ira atualizar o estoque dos produtos cadastrados no sistema */
       public function atualizarEstoque(array $dados){

            /*Inicio da sessão */
            session_start();

            /*Chamada do metodo que ira se conectar ao banco de dados */
            $conexao = $this->conexaoBanco();

            /*Atribuição da sessão em uma variável local */
            $cpf_adm = $_SESSION['cpf_adm'];

            /*Antes de iniciar o processo de atualização, devemos verificar se a sessão foi iniciada */
            if(isset($cpf_adm)){

                /*import da pasta que contem a classe que será utilizada no
                metodo */
                require_once ('classes/Produtos.php');

                /*instancia do objeto */
                $produtos = new Produtos();

                /*chamada dos metodos getters */

                $produtos->setQuantidade($dados['quantidade_produto']);

                $produtos->setCodigoProdutos($dados['codigo_produto']);

                /*chamada dos metodos getters */
                $codigo_produto = $produtos->getCodigoProdutos();

                $quantidade_produto = $produtos->getQuantidade();

                /*Selecao dos dados para verificar se o código informado pelo usuário existe no sistema */
                $selecao_produto = $conexao->query("SELECT codigo_produto, nome_produto FROM produtos WHERE codigo_produto='".$codigo_produto."'");

                /*Contagem das linhas encontradas */
                $quantidade_linhas_produto = $selecao_produto->rowCount();

                /*transformando os dados encontrados em arrays associativos */
                $coluna_produtos = $selecao_produto->fetch(PDO::FETCH_ASSOC);

                /*Antes de realizar o processo vamos verificar se o codigo existe no sistema */
                if($quantidade_linhas_produto > 0){

                    /*atualização do estoque no banco de dados */
                    $atualizar_estoque = $conexao->query("UPDATE produtos SET quantidade_produto = quantidade_produto + '".$quantidade_produto."' WHERE  codigo_produto = '".$codigo_produto."'");

                    /*Mensagens que indicam a realização da atualização */
                    echo "<script>alert('estoque do produto {$coluna_produtos['nome_produto']} atualizado')</script>";

                    echo "<script>alert('quantidade adicionada estoque: {$dados['quantidade_produto']}')</script>";

                }else{

                    /*Caso o produto não exista no sistema, vamos imprimir essa mensagem */
                    echo "<script>alert('Esse produto não existe no sistema')</script>";
                }
                
            }else{

                /*SE a sessão não for iniciada, vamos imprimir essa mensagem. */
                echo "<script>alert('Erro ao carregar a página, por favor tente novamente mais tarde')</script>";
            }
       }

       /*metodo para apagar o produto do sistema */
        public function apagarProduto(array $dados){

            /*Inicio da sessão */
            session_start();

            /*Chamada do metodo para a conexao com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*atribuição da sessão em uma variável local */
            $cpf_adm = $_SESSION['cpf_adm'];
            
            /*Antes de iniciar o processo de exclusão, vamos verificar
            se a sessão foi iniciada */
            if(isset($cpf_adm)){
                
                /*import da pasta que contem a classe que iremos utilizar no
                metodo */
               require_once('classes/Produtos.php');

               /*Instancia do objeto */
               $produtos = new Produtos();

               /*chamada dos metodos setters */

               $produtos->setCodigoProdutos($dados['codigo_produto']);

               /*Chamada do metodo getter */
               $codigo_produto = $produtos->getCodigoProdutos();

               /*Consulta do codigo informado pelo usuário */
               $selecao_produtos = $conexao->query("SELECT codigo_produto FROM produtos WHERE codigo_produto = '".$codigo_produto."'");

               /*Contagem das linhas encontradas */
               $quantidade_linhas = $selecao_produtos->rowCount();

               /*Transformando a coluna de produtos em array associativo */
               $coluna_produtos = $selecao_produtos->fetch(PDO::FETCH_ASSOC);

               /*Antes de excluir o produto, vamos verificar se o produto existe no
               sistema */
               if($quantidade_linhas > 0){

                    /*Se o produto existir vamos imprimir uma mensagem e excluir o produto */    
                    echo "<script>alert('produto excluido')</script>";
                    $excluir_produto = $conexao->query("DELETE FROM produtos WHERE codigo_produto='".$codigo_produto."'");

               }else{

                    /*Se o produto não for encontrado, vamos imprimir essa mensagem */
                    echo "<script>alert('não é possivel excluir um produto que não existe no sistema')</script>";
               }

            }else{

                /*Se a sessão não for carregada, vamos imprimir essa mensagem */
                echo "<script>alert('Erro ao carregar a página, tente novamente mais tarde')</script>";
            }
        }

        /*metodo que irá pesquisar as informações do produto */
        public function pesquisarProduto(array $dados){

            /*inicio da sessão */
            session_start();

            /*chamada do metodo que ira se conectar ao banco de dados */
            $conexao = $this->conexaoBanco();

            /*Atribuição da sessão em uma variável local */
            $cpf_adm = $_SESSION['cpf_adm'];

            /*Antes de iniciar o processo de pesquisa, vamos verificar se 
            a sessão foi iniciada. */
            if(isset($cpf_adm)){

                /*import da pasta que contem a classe que iremos utilizar no metodo */
                require_once('classes/Produtos.php');

                /*instancia do objetos */
                $produtos = new Produtos();

                /*chamada do metodo setter */
                $produtos->setNomeProduto($dados['nome_produto']);

                /*chamada do metodo getter */
                $nome_produto = $produtos->getNomeProduto();

                /*Consulta do nome informado pelo usuário */
                $selecao_produto = $conexao->query("SELECT * FROM produtos WHERE nome_produto = '".$nome_produto."'");

                /*Contagem das linhas encontradas */
                $quantidade_linhas_produto = $selecao_produto->rowCount();

                /*transformando as colunas em arrays associativos */
                $coluna_produtos = $selecao_produto->fetchAll(PDO::FETCH_ASSOC);

                /*Antes de iniciar o processo de impressão dos dados, vamos 
                verificar se o produto existe no sistema */
                if($quantidade_linhas_produto > 0){

                    /*SE o produto for encontrado, vamos iniciar o processo
                    de impressão das informações */
                    echo "<script>alert('produto encontrado')</script>";

                    echo "<p><strong>Informações do produto</strong></p>";

                    /*Vamos percorrer a coluna de produtos e imprimir as informações
                    da coluna */
                    foreach($coluna_produtos as $coluna_produtos){

                        /*Impressão dos resultados */
                        echo "<p>Codigo do produto: ".$coluna_produtos['codigo_produto']."</p>";

                        echo "<p>Quantidade no estoque: ".$coluna_produtos['quantidade_produto']."</p>";

                        echo "<p>Nome do produto: ".$coluna_produtos['nome_produto']."</p>";

                        echo "<p>preço do produto: ".$coluna_produtos['preco_produto']."</p>";

                        echo "<p>descrição do produto: ".$coluna_produtos['descricao_produto']."</p>";

                        echo "<p>Prazo de entrega do produto: ".$coluna_produtos['prazo_entrega']."</p>";

                        echo "<img src='".$coluna_produtos['imagem_produto']."' alt='foto do produto' class='imagem-perfil'>";


                    }

                }else{

                    /*Se o rpoduto não for encontrado, vamos imprimir essa mensagem */
                    echo "<script>alert('produto não encontrado no sistema')</script>";

                }

            }else{

                /*Se a sessãop não for iniciada, vamos imprimir essa mensagem. */
                echo "<script>alert('Erro ao carregar a página, por favor tente novamente mais tarde')</script>";
            }
        }


        /*Metodo que ira atualizar ou modificar o preço dos produtos cadastrados */
        public function atualizarPreco($dados){

            /*Inicio da sessão */
            session_start();

            /*atribuição da sessão em uma variável local */
            $cpf_adm = $_SESSION['cpf_adm'];

            /*Chamada do metodo de conexão com o banco de dados */
            $conexao = $this->conexaoBanco();

            /*Antes de iniciar o metodo, vamos verificar se a sessão foi iniciada */
            if(isset($cpf_adm)){

                /*Se a sessão for iniciada vamos iniciar o processo de atualização */
                require_once('classes/Produtos.php');

                /*instancia do objeto */
                $produtos = new Produtos();

                /*chamada dos metodos setters */
                $produtos->setCodigoProdutos($dados['codigo_produto']);

                $produtos->setPrecoProduto($dados['preco_produto']);

                /*chamada dos metodos getters */
                $codigo_produto = $produtos->getCodigoProdutos();

                $novo_preco_produto = $produtos->getPrecoProduto();

                /*Consulta do codigo informado pelo usuário */
                $selecao_produtos = $conexao->query("SELECT codigo_produto, nome_produto FROM produtos WHERE codigo_produto = '".$codigo_produto."'");

                /*contagem das linhas encontradas */
                $quantidade_linhas_produtos = $selecao_produtos->rowCount();

                /*Transformando as colunas em um array associativo */
                $coluna_produtos = $selecao_produtos->fetch(PDO::FETCH_ASSOC);

                /*Antes de atualizar o preco, vamos verificar se o produto existe no sistema */
                if($quantidade_linhas_produtos > 0){

                    /*Mensagem com o intuito de informar o usuário sobre a atualização */
                    echo "<script>alert('preco do produto produto {$coluna_produtos['nome_produto']} atualizado com sucesso')</script>";

                    /*Atualização do preço do produto */
                    $atualizar_preco = $conexao->query("UPDATE produtos set preco_produto = '".$novo_preco_produto."' WHERE codigo_produto = '".$codigo_produto."'");

                }else{

                    /*se o rpoduto não for encontrado, vamos imprimir essa mensagem */
                    echo "<script>alert('produto não encontrado no sistema')</script>";
                }

            }else{

                /*Se a sessão não for iniciada, vamos imprimir essa mensagem */
                echo "<script>alert('Erro ao carregar a página, por favor tente novamente mais tarde')</script>";
            }
        }


        /*metodo que ira calcular o desconto de um determinado produto */
        public function calcularDesconto($dados){

           /*Calculo da porcentagem */
           $calc_desconto = ($dados['preco'] * $dados['desconto']) / 100;

           /*subtraindo o valor da porcentagem do preço atual do produto */
           $preco_com_desconto = $dados['preco'] - $calc_desconto;
        
            /*impressão das mensagens que irão conter os resultados */
            echo "<script>alert('preço do produto com desconto: {$preco_com_desconto}')</script>";

            echo "<script>alert('preço sem desconto: {$dados['preco']}')</script>";

            echo "<script>alert('porcentagem do desconto: {$dados['desconto']}%')</script>";
        }

    }

?>