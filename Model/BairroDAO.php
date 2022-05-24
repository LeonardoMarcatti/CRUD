<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    use PDO;

    Class BairroDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function checkBairro($bairro){
            $sql = 'select id from bairro where name = :name';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':name', $bairro);
            $result->execute();
            if ($result->rowCount() > 0) {
                return $result->fetch(PDO::FETCH_ASSOC)['id'];
            } else {
                return false;
            };            
        }

        public function addNewBairro(Bairro $b){
            $sql = 'insert into bairro(name) values(:name)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':name', $b->getName());
            $insert->execute();
        }

        public function getAllBairros(){
            $sql = 'select * from bairro order by id asc';
            $result = $this->pdo->prepare($sql);
            $result->execute();
            $bairros = array();
            foreach ($result as $key => $value) {
                $bairro = new Bairro();
                $bairro->setID($value['id']);
                $bairro->setName($value['name']);
                $bairros[] = $bairro;
            };
            return $bairros;
        }
    }