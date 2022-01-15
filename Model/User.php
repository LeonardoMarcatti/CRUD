<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
    use PDO;

    class User{
        private int $id;
        private string $name, $userName, $password, $email;

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

        public function setEmail(string $val)
        {
            $this->email = $val;
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

        public function getEmail()
        {
            return $this->email;
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
            $sql = "INSERT INTO users(username, password, name, email) VALUES(:username, :password, :name, :email)";
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':username', $u->getUserName());
            $insert->bindValue(':password', $u->getPassword());
            $insert->bindValue(':name', $u->getName());
            $insert->bindValue(':email', $u->getEmail());
            $insert->execute();
        }

        public function updateUser(User $u)
        {
            $sql = 'update users set name = :name, email = :email, password = :password where id = :id';
            $update = $this->pdo->prepare($sql);
            $update->bindValue(':password', $u->getPassword());
            $update->bindValue(':name', $u->getName());
            $update->bindValue(':email', $u->getEmail());
            $update->bindValue(':id', $u->getID());
            $update->execute();
        }

        public function getUserByID(User $u)
        {
            $sql = 'select * from users where id = :id';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $u->getID());
            $select->execute();
           
            if ($select->rowCount() == 1) {
                $result = $select->fetch(PDO::FETCH_ASSOC);

                $user = new User;
                $user->setID($result['id']);
                $user->setName($result['name']);
                $user->setEmail($result['email']);
                
                return $user;
            };
            
            return false;
        }

        public function getUserByName(User $u)
        {
            $sql = 'select * from users where name = :name';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':name', $u->getName());
            $select->execute();

            if ($select->rowCount() == 1) {
                $result = $select->fetch(PDO::FETCH_ASSOC);

                $user = new User;
                $user->setID($result['id']);
                $user->setName($result['name']);
                $user->setEmail($result['email']);
                
                return $user;
            };
            
            return false;
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