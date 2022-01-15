<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    require_once '../Config/Connection.php';
    require_once '../Model/User.php';
    require_once '../Model/Image.php';

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\User;
    use Testes\Projetos\PHP\CRUD\Model\UserDAO;
    use Testes\Projetos\PHP\CRUD\Model\Image;
    use Testes\Projetos\PHP\CRUD\Model\ImageDAO;

    if (!empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['pass'])) {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $username = password_hash(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING), PASSWORD_BCRYPT);
        $pass = password_hash(filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING), PASSWORD_BCRYPT);
        $email = \filter_input(\INPUT_POST, 'email', \FILTER_SANITIZE_EMAIL);


        $connection = Connection::getConnection();
        $user = new User;
        $userDAO = new UserDAO($connection);
        $img = new Image;
        $imgDAO = new ImageDAO($connection);

        $user->setName($name);
        $user->setUserName($username);
        $user->setPassword($pass);
        $user->setEmail($email);
        $userDAO->addUser($user);

        $lastAddedID = $userDAO->getLastAddedUser();
        $photo = $_FILES['myfile']['name'];
        $code = codeGen();
        $name = $code . '_' . $photo;
        $img->setPath($name);
        $img->setUserID($lastAddedID);
        $imgDAO->addImage($img);

        Submit($_FILES['myfile'], $name);
        \header('Location: ../View/login.php');
        exit;
    };

    function codeGen(){
        $alfanum = 'ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
        $tamanho = 20;
        $cod = '';
        for ($i=0; $i < $tamanho; $i++) { 
            $char = substr($alfanum, rand(0, 36), 1);
            $cod .= $char;
        };
        return $cod;
    };

    function Submit($file, $name){
        $tmp = $file['tmp_name'];
        $local = '../img/users/';
        move_uploaded_file($tmp, "$local" . $name);
    };

?>