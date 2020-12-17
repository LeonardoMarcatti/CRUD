<?php
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

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function checkEmail(Email $e){
            $sql = 'select id from email where endereco = :endereco';
            $result = $this->pdo->prepare($sql);
            $result->bindParam(':endereco', $e->getEndereco());
            $result->execute();
            $id = $result->fetch()['id'];
            return $id;
        }

        public function add(Email $e){
            $sql = 'insert into email(endereco, cliente_id) values(:endereco, :cliente_id)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindParam(':endereco', $e->getEndereco());
            $insert->bindParam(':cliente_id', $e->getClienteID());
            $insert->execute();
            $e->setID($this->pdo->lastInsertId());
        }

        public function update(Email $e){
            $sql = 'update email set endereco = :endereco where cliente_id = :id';
            $update = $this->pdo->prepare($sql);
            $update->bindParam(':endereco', $e->getEndereco());
            $update->bindParam(':id', $e->getClienteID());
            $update->execute();
        }

        public function delete($id){
            $sql = 'delete from email where id = :id';
            $delete = $this->pdo->prepare($sql);
            $delete->bindParam(':id', $id);
            $delete->execute();
        }
    };

?>