<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    use PDO;
    
    class EmailDAO
    {
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function checkEmail(Email $e){
            $sql = 'select * from email where address = :address';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':address', $e->getAddress());
            $select->execute();
            if ($select->rowCount() > 0) {
                $result = $select->fetch(PDO::FETCH_ASSOC);

                $email = new Email;
                $email->setID($result['id']);
                $email->setAddress($result['address']);
                $email->setClienteID($result['client_id']);
                return $email;
            } else {
                return false;
            };
        }

        public function add(Email $e){
            $sql = 'insert into email(address, client_id) values(:address, :client_id)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':address', $e->getAddress());
            $insert->bindValue(':client_id', $e->getClienteID());
            $insert->execute();
            $e->setID($this->pdo->lastInsertId());
        }

        public function update(Email $e){
            $sql = 'update email set address = :address where client_id = :id';
            $update = $this->pdo->prepare($sql);
            $update->bindValue(':address', $e->getAddress());
            $update->bindValue(':id', $e->getClienteID());
            $update->execute();
        }

        public function delete($id){
            $sql = 'delete from email where client_id = :id';
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(':id', $id);
            $delete->execute();
        }
    }