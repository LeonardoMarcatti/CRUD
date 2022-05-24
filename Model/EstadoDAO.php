<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    use PDO;

    class EstadoDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function getAllEstados(){
            $sql = 'select * from estado order by id asc';
            $result = $this->pdo->prepare($sql);
            $result->execute();
            $estados = array();
            foreach ($result as $key => $value) {
                $estado = new Estado();
                $estado->setID($value['id']);
                $estado->setName($value['name']);
                $estados[] = $estado;
            };
            return $estados;
        }
    }
