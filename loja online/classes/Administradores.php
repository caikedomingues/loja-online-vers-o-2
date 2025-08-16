

<?php

   class Administradores{

        /*atributos */
        private string $cpf_adm;

        private string $email_adm;

        private string $senha_adm;

        /*Getters e setters */
        public function setCpfAdm(string $cpf_adm){

            $this->cpf_adm = $cpf_adm;
        }

        public function getCpfAdm(){

            return $this->cpf_adm;
        }

        public function setEmailAdm(string $email_adm){
            $this->email_adm = $email_adm;
        }


        public function getEmailAdm(){

            return $this->email_adm;
        }


        public function setSenhaAdm(string $senha_adm){

            $this->senha_adm = $senha_adm;
        }

        public function getSenhaAdm(){

            return $this->senha_adm;
        }
   }
?>