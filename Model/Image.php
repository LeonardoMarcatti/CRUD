<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
    class Image
    {
        private int $id, $userID;
        private string $path;

        public function setID(int $val)
        {
            $this->id = $val;
        }

        public function setUserID(int $val)
        {
            $this->userID = $val;
        }

        public function setPath(string $val)
        {
            $this->path = $val;
        }

        public function getPath()
        {
            return $this->path;
        }

        public function getID()
        {
            return $this->id;
        }

        public function getUserID()
        {
            return $this->userID;
        }
    }