<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
    
    class Email{
        private int $id, $cliente_id;
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

        public function setClienteID($cliente_id){
            $this->cliente_id = $cliente_id;
        }

        public function getClienteID(){
            return $this->cliente_id;
        }
    };

    class EmailDAO{
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function checkEmail(Email $e){
            $sql = 'select id from email where address = :address';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':address', $e->getAddress());
            $result->execute();
            if ($result->rowCount() > 0) {
                return $result->fetch()['id'];
            } else {
                return false;
            };
        }

        public function add(Email $e){
            $sql = 'insert into email(address, cliente_id) values(:address, :cliente_id)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':address', $e->getAddress());
            $insert->bindValue(':cliente_id', $e->getClienteID());
            $insert->execute();
            $e->setID($this->pdo->lastInsertId());
        }

        public function update(Email $e){
            $sql = 'update email set address = :address where cliente_id = :id';
            $update = $this->pdo->prepare($sql);
            $update->bindValue(':address', $e->getAddress());
            $update->bindValue(':id', $e->getClienteID());
            $update->execute();
        }

        public function delete($id){
            $sql = 'delete from email where id = :id';
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(':id', $id);
            $delete->execute();
        }
    };

?>