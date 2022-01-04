<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
    use PDO;

    class User{
        private int $id;
        private string $name, $userName, $password;

        public function setID(int $val)
        {
            $this->id = $val;
        }

        public function setName(string $val)
        {
            $this->name = $val;
        }

        public function setUserName(string $val)
        {
            $this->userName = $val;
        }

        public function setPassword(string $val)
        {
            $this->password = $val;
        }

        public function getID()
        {
            return $this->id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getUserName()
        {
            return $this->userName;
        }

        public function getPassword()
        {
            return $this->password;
        }
    };

    class UserDAO
    {
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function addUser(User $u)
        {
            $sql = "INSERT INTO users(username, password, name) VALUES(:username, :password, :name)";
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':username', $u->getUserName());
            $insert->bindValue(':password', $u->getPassword());
            $insert->bindValue(':name', $u->getName());
            $insert->execute();
        }

        public function getUserByID(User $u)
        {
            $sql = 'select * from users where id = :id';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $u->getID());
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getUserByName(User $u)
        {
            $sql = 'select * from users where name = :name';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':name', $u->getName());
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getLastAddedUser()
        {
            $sql = 'select max(id) as id from users';
            $select = $this->pdo->prepare($sql);
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC)['id'];
            return $result;
        }

        public function getAll()
        {
            $sql = 'select * from users';
            $select = $this->pdo->prepare($sql);
            $select->execute();
            $result = $select->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    };
?>