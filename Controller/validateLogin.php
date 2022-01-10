<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    require_once '../Config/Connection.php';
    require_once '../Model/User.php';

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\UserDAO;
    
    session_start();

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $connection = Connection::getConnection();
        $userDAO = new UserDAO($connection);
        $all = $userDAO->getAll();

        foreach ($all as $key => $value) {
            if (password_verify($password, $value['password']) && password_verify($username, $value['username'])) {
                $_SESSION['user'] = $value['name'];
                header('location: ../View/crud.php');
                exit;
            };
        };

        header('location: ../View/login.php');
        exit;
    };
?>