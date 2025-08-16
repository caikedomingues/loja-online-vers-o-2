

<?php
    
    class Pessoas{

        /*atributos da classe*/

        private string $nome;

        private string $cpf;

        private string $senha;

        private string $email;

        private float $saldo_compra;


        /*Getters e setters da classe */

        public function setNome(string $nome){

            $this->nome = $nome;
        }

        public function getNome(){

            return $this->nome;
        }


        public function setCpf(string $cpf){

            $this->cpf = $cpf;
        }

        public function getCpf(){

            return $this->cpf;
        }

        public function setSenha(string $senha){

            $this->senha = $senha;
        }

        public function getSenha(){

            return $this->senha;
        }

        public function setEmail(string $email){

            $this->email = $email;

        }

        public function getEmail(){

            return $this->email;
        }

        public function setSaldoCompra(float $saldo_compra){

            $this->saldo_compra = $saldo_compra;

        }



        public function getSaldoCompra(){

            return $this->saldo_compra;
        }

    }

?>