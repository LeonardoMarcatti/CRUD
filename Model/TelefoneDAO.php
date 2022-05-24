<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    class TelefoneDAO{
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function checkTelefone(Telefone $t){
        $sql = 'select id from telefone where number = :number and ddd = :ddd and tipo = :tipo';
        $result = $this->pdo->prepare($sql);
        $result->bindValue(':number', $t->getNumber());
        $result->bindValue(':ddd', $t->getDDD());
        $result->bindValue(':tipo', $t->getTipo());
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result->fetch()['id'];
        } else {
            return false;
        };
        }

        public function add(Telefone $t){
        $sql = 'insert into telefone(number, ddd, tipo) values(:number, :ddd, :tipo)';
        $insert = $this->pdo->prepare($sql);
        $insert->bindValue(':number', $t->getNumber());
        $insert->bindValue(':ddd', $t->getDDD());
        $insert->bindValue(':tipo', $t->getTipo());
        $insert->execute();
        }
      
    }