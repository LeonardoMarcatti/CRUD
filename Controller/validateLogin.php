<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    require_once '../Config/Connection.php';
    require_once '../Model/User.php';

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\User;
    use Testes\Projetos\PHP\CRUD\Model\UserDAO;
    
    session_start();    

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $connection = Connection::getConnection();
        $user = new User;
        $userDAO = new UserDAO($connection);
        $all = $userDAO->getAll();

        foreach ($all as $key => $value) {
            if (password_verify($password, $value['password']) && password_verify($username, $value['username'])) {
                $name = $value['name'];
                $user->setName($name);
                $_SESSION['user'] = $name;

                $result = $userDAO->getUserByName($user);
                if ($result->getEmail()) {
                    header('location: ../View/crud.php');
                    exit;
                } else {
                    header('location: ../View/updateUser.php?id=' . $result->getID());
                    exit;
                };
            };
        };

        header('location: ../View/login.php');
        exit;
    };
?>