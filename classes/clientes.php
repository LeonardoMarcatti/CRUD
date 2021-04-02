<?php
    namespace CRUD\classes;

    interface DAO{
        public function add(clientes $c);
        public function findAll();
    }

    class Clientes{
        private $id;
        private $nome;
        private $sexo;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getNome(){
            return $this->nome;
        }

        public function setSexo($sexo){
            $this->sexo = $sexo;
        }

        public function getSexo(){
            return $this->sexo;
        }
    }

    class ClientesDAO implements DAO{
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function findAll(){
            $array = [];
            $sql = 'select id, nome, sexo from cliente';
            $result = $this->pdo->prepare($sql);
            $result->execute();
            foreach ($result as $key => $value) {
               $u = new Clientes();
               $u->setID($value['id']);
               $u->setNome($value['nome']);
               $u->setSexo($value['sexo']);
               $array[] = $u;
            };
            return $array;
        }

        public function add(Clientes $c){
            $sql = 'insert into cliente(nome, sexo) values(:nome, :sexo)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindParam(':nome', $c->getNome());
            $insert->bindParam(':sexo', $c->getSexo());
            $insert->execute();

            $c->setID($this->pdo->lastInsertId());
        }

        public function getSexID($sex){
            $sql = 'select id from sexo where genero = :genero';
            $result = $this->pdo->prepare($sql);
            $result->bindParam(':genero', $sex);
            $result->execute();
            $id = $result->fetch()['id'];
            return $id;
        }

        public function delete(Clientes $c){
            $sql = 'delete from cliente_telefone where id_cliente = :id; delete from endereco_cliente where id_cliente = :id; delete from email where cliente_id = :id; delete from cliente where id = :id';
            $delete = $this->pdo->prepare($sql);
            $delete->bindParam(':id', $c->getID());
            $delete->execute();
        }

        public function getMaxId(){
            $sql = "select max(id) as 'id' from cliente";
            $result = $this->pdo->prepare($sql);
            $result->execute();
            $id = $result->fetch()['id'];
            return $id;
        }
    }
?>