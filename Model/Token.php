<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

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
    }