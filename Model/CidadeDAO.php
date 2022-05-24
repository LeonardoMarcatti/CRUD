<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    use PDO;
    
    class CidadeDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function checkCidade($name){
            $sql = 'select id from cidade where name = :name';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':name', $name);
            $result->execute();
            if ($result->rowCount() > 0) {
                return $result->fetch(PDO::FETCH_ASSOC)['id'];
            } else {
                return false;
            }; 
        }

        public function addNewCidade(Cidade $c){
            $sql = 'insert into cidade(name) values(:name)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':name', $c->getName());
            $insert->execute();
        }
    }