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
            $sql = 'select id, name, sex from cliente';
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
            $sql = 'select id, name from cliente where id = :id';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $c->getID());
            $select->execute();
            $result = $select->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function add(Clientes $c){
            $sql = 'insert into cliente(name, namesex) values(:name, :namesex)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':name', $c->getname());
            $insert->bindValue(':namesex', $c->getSex());
            $insert->execute();

            $c->setID($this->pdo->lastInsertId());
        }

        public function getSexID($sex){
            $sql = 'select id from namesex where genero = :genero';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':genero', $sex);
            $result->execute();
            $id = $result->fetch()['id'];
            return $id;
        }

        public function delete(Clientes $c){
            $sql = 'delete from cliente_telefone where id_cliente = :id; delete from endereco_cliente where id_cliente = :id; delete from email where cliente_id = :id; delete from cliente where id = :id';
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(':id', $c->getID());
            $delete->execute();
        }

        public function getMaxId(){
            $sql = "select max(id) as 'id' from cliente";
            $result = $this->pdo->prepare($sql);
            $result->execute();
            $id = $result->fetch()['id'];
            return $id;
        }
    };
?>