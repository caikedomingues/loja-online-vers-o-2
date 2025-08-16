

<?php

    class Produtos{

        /* Atributos da classe*/

        private string $codigo_produto;

        private string $nome_produto;

        private float $preco_produto;

        private string $descricao_produto;

        private string $prazo_entrega;

        private int $quantidade_produto;

        /*getters e setters */

        public function setCodigoProdutos(string $codigo_produto){

            $this->codigo_produto = $codigo_produto;

        }


        public function getCodigoProdutos(){

            return $this->codigo_produto;
        }


        public function setNomeProduto(string $nome_produto){

            $this->nome_produto = $nome_produto;
        }

        public function getNomeProduto(){

            return $this->nome_produto;
        }


        public function setPrecoProduto(float $preco_produto){

            $this->preco_produto = $preco_produto;
        }

        public function getPrecoProduto(){

            return $this->preco_produto;
        }

        public function setDescricaoProduto(string $descricao_produto){

            $this->descricao_produto = $descricao_produto;
        }

        public function getDescricaoProduto(){

            return $this->descricao_produto;
        }

        public function setPrazoEntrega(string $prazo_entrega){

            $this->prazo_entrega = $prazo_entrega;
        }

        public function getPrazoEntrega(){

            return $this->prazo_entrega;
        }

        public function setQuantidade(int $quantidade_produto){

            $this->quantidade_produto = $quantidade_produto;
        }

        public function getQuantidade(){

            return $this->quantidade_produto;
        }

    }

?>