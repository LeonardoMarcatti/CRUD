<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

use PDO;

class Token
    {
        private int $id, $user_id, $used;
        private string $hash, $expire_in;

        public function setID(int $val)
        {
            $this->id = $val;
        }

        public function setUserID(int $val)
        {
            $this->user_id = $val;
        }

        public function setUsed(int $val)
        {
            $this->used = $val;
        }

        public function setHash(string $val)
        {
            $this->hash = $val;
        }

        public function setExpireIn(string $val)
        {
            $this->expire_in = $val;
        }

        public function getID()
        {
            return $this->id;
        }

        public function getUserID()
        {
            return $this->user_id;
        }

        public function getUsed()
        {
            return $this->used;
        }

        public function getHash()
        {
            return $this->hash;
        }

        public function getExpireIn()
        {
            return $this->expire_in;
        }
    };

    class TokenDAO 
    {
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function insertToken(Token $t)
        {
            $sql = 'insert into users_token(user_id, hash, expire_in) values(:userID, :hash, :expire_in)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':userID', $t->getUserID());
            $insert->bindValue(':hash', $t->getHash());
            $insert->bindValue(':expire_in', $t->getExpireIn());
            $insert->execute();
        }

        public function getInfo(Token $t)
        {
            $sql = 'select * from users_token where hash = :hash and used = 0 and expire_in > now()';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':hash', $t->getHash());
            $select->execute();
            if ($select->rowCount() == 1) {
                $result = $select->fetch(PDO::FETCH_ASSOC);

                $token = new Token;
                $token->setUserID($result['user_id']);
                $token->setHash($result['hash']);
                $token->setExpireIn($result['expire_in']);
                $token->setID($result['id']);

                return $token;
            };

            return false;
        }

        public function updateTokenStatus(Token $t)
        {
            $sql = 'update users_token set used = 1 where id = :id';
            $update = $this->pdo->prepare($sql);
            $update->bindValue(':id', $t->getID());
            $update->execute();
        }
    }
    
    

?>