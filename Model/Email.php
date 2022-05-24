<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    class Email{
        private int $id, $client_id;
        private string $address;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setAddress($address){
            $this->address = $address;
        }

        public function getAddress(){
            return $this->address;
        }

        public function setClienteID($client_id){
            $this->client_id = $client_id;
        }

        public function getClienteID(){
            return $this->client_id;
        }
    }