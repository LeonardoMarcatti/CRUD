<?php
  namespace Testes\Projetos\PHP\CRUD\Model;
    class Telefone{
        private int $id, $ddd;
        private string $number, $tipo;

        public function setID($id){
        $this->id = $id;
        }

        public function getID(){
        return $this->id;
        }

        public function setNumber($number){
        $this->number = $number;
        }

        public function getNumber(){
        return $this->number;
        }

        public function setDDD($ddd){
        $this->ddd = $ddd;
        }

        public function getDDD(){
        return $this->ddd;
        }

        public function setTipo($tipo){
        $this->tipo = $tipo;
        }

        public function getTipo(){
        return $this->tipo;
        }
    }