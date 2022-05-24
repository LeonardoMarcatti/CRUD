<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    class TipoTelefoneDAO{
        private $pdo;

        public function __construct(\PDO $conection){
        $this->pdo = $conection;
        }

        public function getAllTipoTelefones(){
        $lista = array();
        $sql = 'select * from tipo_telefone order by id asc';
        $result = $this->pdo->prepare($sql);
        $result->execute();
        foreach ($result as $key => $value) {
            $lista[] = $value;
        };
        return $lista;
        }
    }