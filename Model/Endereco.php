<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    class Endereco{
        
        private int $id, $tipo, $numero, $bairro, $cidade, $estado;
        private string $endereco, $complement;
        
        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setTipo($tipo){
            $this->tipo = $tipo;
        }

        public function getTipo(){
           return $this->tipo;
        }

        public function setEndereco($endereco){
           $this->endereco = $endereco;
        }

        public function getEndereco(){
           return $this->endereco;
        }

        public function setnumero($numero){
            $this->numero = $numero;
        }

        public function getnumero(){
            return $this->numero;
        }

        public function setComplement($complement){
           $this->complement = $complement;
        }

        public function getComplement(){
            return $this->complement;
        }

        public function setBairro($bairro){
           $this->bairro = $bairro;
        }

        public function getBairro(){
           return $this->bairro;
        }

        public function setCidade($cidade){
            $this->cidade = $cidade;
        }

        public function getCidade(){
            return $this->cidade;
        }

        public function setEstado($estado){
            $this->estado = $estado;
        }

        public function getEstado(){
            return $this->estado;
        }
    }