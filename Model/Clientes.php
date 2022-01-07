<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
    use PDO;

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
    };

    class ClientesDAO
    {
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function findAll(){
            $sql = 'select id, name, sex from client';
            $select = $this->pdo->prepare($sql);
            $select->execute();
            $result = $select->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getClientByName(Clientes $c)
        {
            $sql = 'select id, name from cliente where name = :name';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':name', $c->getName());
            $select->execute();
            $result = $select->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getClientByID(Clientes $c)
        {
            $sql = 'select id, name from client where id = :id';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $c->getID());
            $select->execute();
            $result = $select->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function addNewClient(Clientes $c){
            $sql = 'insert into client(name, sex) values(:name, :sex)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':name', $c->getname());
            $insert->bindValue(':sex', $c->getSex());
            $insert->execute();

            $c->setID($this->pdo->lastInsertId());
        }

        public function getSexID($sex){
            $sql = 'select id from sex where gender = :gender';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':gender', $sex);
            $result->execute();
            $id = $result->fetch(PDO::FETCH_ASSOC)['id'];
            return $id;
        }

        public function delete(Clientes $c){
            $sql = 'delete from client_telefone where id_cliente = :id; delete from endereco_client where id_cliente = :id; delete from email where cliente_id = :id; delete from client where id = :id';
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(':id', $c->getID());
            $delete->execute();
        }

        public function getMaxId(){
            $sql = "select max(id) as 'id' from client";
            $result = $this->pdo->prepare($sql);
            $result->execute();
            $id = $result->fetch()['id'];
            return $id;
        }

        public function getDetails($id){
            $query = "select * from v_tudo where id=:cod";
            $result = $this->pdo->prepare($query);
            $result->bindParam(':cod', $id);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
    };
?>