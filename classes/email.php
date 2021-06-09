<?php
    namespace CRUD\classes;
    
    class Email{
        private int $id;
        private string $endereco;
        private int $cliente_id;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setEndereco($endereco){
            $this->endereco = $endereco;
        }

        public function getEndereco(){
            return $this->endereco;
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
            $sql = 'select id from email where endereco = :endereco';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':endereco', $e->getEndereco());
            $result->execute();
            if ($result->rowCount() > 0) {
                return $result->fetch()['id'];
            } else {
                return false;
            };
        }

        public function add(Email $e){
            $sql = 'insert into email(endereco, cliente_id) values(:endereco, :cliente_id)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':endereco', $e->getEndereco());
            $insert->bindValue(':cliente_id', $e->getClienteID());
            $insert->execute();
            $e->setID($this->pdo->lastInsertId());
        }

        public function update(Email $e){
            $sql = 'update email set endereco = :endereco where cliente_id = :id';
            $update = $this->pdo->prepare($sql);
            $update->bindValue(':endereco', $e->getEndereco());
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