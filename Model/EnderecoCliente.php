<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    class EnderecoCliente{
        private int $idcliente, $idendereco;

        public function setIDCliente($idcliente){
            $this->idcliente = $idcliente;
        }

        public function getIDCliente(){
            return $this->idcliente;
        }

        public function setIDEndereco($idendereco){
            $this->idendereco = $idendereco;
        }

        public function getIDEndereco(){
            return $this->idendereco;
        }
    }