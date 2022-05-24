<?php
  namespace Testes\Projetos\PHP\CRUD\Model;

    class ClienteTelefone{
        private int $idcliente;
        private int $idtelefone;

        public function setIDCliente($idcliente){
        $this->idcliente = $idcliente;
        }

        public function getIDCliente(){
        return $this->idcliente;
        }

        public function setIDTelefone($idtelefone){
        $this->idtelefone = $idtelefone;
        }

        public function getIDTelefone(){
        return $this->idtelefone;
        }
    }