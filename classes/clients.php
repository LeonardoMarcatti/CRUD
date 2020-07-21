<?php

    interface UserDAO{
        public function add(User $u);
        public function findAll();
        public function findByID($id);
        public function update(User $u);
        public function delete();
    }

    class User{
        private int $id;
        private string $nome;
        private string $email;
        private int $idade;

        public function setID(int $val){
            $this->id = trim($val);
        }

        public function getID(){
            return $this->id;
        }

        public function setNome(string $val){
            $this->nome =  strtoupper(trim($val));
        }

        public function getNome(){
            return $this->nome;
        }

        public function setIdade(int $val){
            $this->idade = $val;
        }

        public function getIdade(){
            return $this->idade;
        }

        public function setEmail(string $val){
            $this->email = strtolower(trim($val));
        }

        public function getEmail(){
            return $this->email;
        }
    }

    class UserDaoMysql implements UserDAO{
        private $pdo;

        public function __construct(PDO $driver){
            $this->pdo = $driver;
        }

        public function add(User $u){

        }

        public function findAll(){
            $array = [];
            $sql = $this->pdo->query('select * from v_tudo');
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $key => $value) {
               $u = new User();
               $u->setID($value['id']);
               $u->setNome($value['nome']);
               $array[] = $u;
            };
            return $array;
        }

        public function findByID($id){

        }

        public function update(User $u){

        }

        public function delete(){

        }
    };
?>