<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    class DDD_DAO{
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function addDDD(DDD $d){
        $sql = 'insert into ddd(number) values(:numero)';
        $insert = $this->pdo->prepare($sql);
        $insert->bindValue(':numero', $d->getNumero());
        $insert->execute();
        }

        public function checkDDD(DDD $d){
        $sql = 'select id from ddd where number = :numero';
        $result = $this->pdo->prepare($sql);
        $result->bindValue(':numero', $d->getNumero());
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result->fetch()['id'];
        } else {
            return false;
        };
        }
    }