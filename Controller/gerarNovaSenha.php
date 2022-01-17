<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    require_once '../Config/Connection.php';
    require_once '../Model/Token.php';
    require_once '../Model/User.php';

    use Testes\Projetos\PHP\CRUD\Model\Token;
    use Testes\Projetos\PHP\CRUD\Model\TokenDAO;
    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\User;
    use Testes\Projetos\PHP\CRUD\Model\UserDAO;

    if (!empty($_GET['token'])) {
        $hash = \filter_input(\INPUT_GET, 'token', \FILTER_SANITIZE_STRING);

        $connection = Connection::getConnection();
        $token = new Token;
        $token_dao = new TokenDAO($connection);

        $token->setHash($hash);
        $token_info = $token_dao->getInfo($token);

        if ($token_info) {
            $user = new User;
            $user->setID($token_info->getUserID());
        };

        if (!empty($_POST['pass'])) {
            $pass = \password_hash(\filter_input(\INPUT_POST, 'pass', \FILTER_SANITIZE_STRING), \PASSWORD_BCRYPT);
            $user->setPassword($pass);

            $user_dao = new UserDAO($connection);
            $user_dao->updateUserPassword($user);

            $token->setID($token_info->getID());
            $token_dao->updateTokenStatus($token);

            \header('location: login.php');
            exit;

        };


    } else{
        \header('location: login.php');
        exit;
    };

?>