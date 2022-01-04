<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
    use PDO;

    class Image
    {
        private int $id, $userID;
        private string $name;

        public function setID(int $val)
        {
            $this->id = $val;
        }

        public function setUserID(int $val)
        {
            $this->userID = $val;
        }

        public function setName(string $val)
        {
            $this->name = $val;
        }

        public function getName()
        {
            return $this->name;
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
            $sql = 'insert into image(name, iduser) values(:name, :iduser)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':name', $i->getName());
            $insert->bindValue(':iduser', $i->getUserID());
            $insert->execute();
        }

        public function getUserImage(Image $i){
            $sql = "select u.id, i.name as image, u.name as name from image i join users u on u.id = i.iduser where u.id = :id";
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $i->getUserID());
            $select->execute();
            $photo = $select->fetch(PDO::FETCH_ASSOC);
            return $photo;    
        }
    }
    
    

?>