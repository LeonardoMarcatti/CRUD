<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
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
    }