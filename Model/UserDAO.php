<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    use PDO;

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

        public function updateUserPassword(User $u)
        {
            $sql = 'update users set password = :password where id = :id';
            $update = $this->pdo->prepare($sql);
            $update->bindValue(':password', $u->getPassword());
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
        
        public function getUserByEmail(User $u)
        {
            $sql = 'select * from users where email = :email';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':email', $u->getEmail());
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
    }