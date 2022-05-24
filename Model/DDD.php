<?php
  namespace Testes\Projetos\PHP\CRUD\Model;

    class DDD{
        private int $id;
        private string $numero;

        public function setID($id){
        $this->id = $id;
        }

        public function getID(){
        return $this->id;
        }

        public function setNumero($numero){
        $this->numero = $numero;
        }

        public function getNumero(){
        return $this->numero;
        }
    }