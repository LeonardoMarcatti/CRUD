<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    use PDO;

    class TipoLogradouroDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function getAllLogradouros(){
            $sql = 'select * from tipo_logradouro';
            $select = $this->pdo->prepare($sql);
            $select->execute();
            $log = array();
            foreach ($select as $key => $value) {
                $tipo = new TipoLogradouro();
                $tipo->setID($value['id']);
                $tipo->setName($value['name']);
                $log[] = $tipo;
            };
            return $log;
        }
    }