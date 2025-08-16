


<?php

    /*inicio da sessão */
    session_start();

    /*atribuição da sessão em uma variável local */
    $cpf_pessoa = $_SESSION['cpf'];

    /*Antes de iniciar o processo vamos verificar se a 
    sessão foi iniciada corretamente */
    if(isset($cpf_pessoa)){

        /*Impressão da mensagem e transição para a página de login de clientes */
        echo "<script>alert('você saiu do sistema, obrigado por utilizar'); window.location.href='index.php'</script>";

        /*Encerramento da sessão */
        session_abort();

        /*comando que evita a execução de comandos adicionais */
        exit;

    }else{

        /*Caso a sessão não tenha sido iniciada, vamos imprimir essa mensagem */
        echo "<script>alert('Erro ao sair do sistema')</script>";
    }

?>