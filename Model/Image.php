<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
    use PDO;

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
    };

    class ImageDAO
    {
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function addImage(Image $i)
        {
            $sql = 'insert into image(path, id_user) values(:path, :iduser)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':path', $i->getPath());
            $insert->bindValue(':iduser', $i->getUserID());
            $insert->execute();
        }

        public function getUserImage(Image $i){
            $sql = "select u.id, i.path as image, u.name as name from image i join users u on u.id = i.id_user where u.id = :id";
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $i->getUserID());
            $select->execute();
            $photo = $select->fetch(PDO::FETCH_ASSOC);
            return $photo;    
        }
    }
    
    

?>