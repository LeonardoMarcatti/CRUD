<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
    class Clientes
    {
        private int $id, $sex;
        private string $name;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }

        public function setSex($sex){
            $this->sex = $sex;
        }

        public function getSex(){
            return $this->sex;
        }
    }