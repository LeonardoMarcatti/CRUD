<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    spl_autoload_register(
        function ($class)
        {
            $pathToClass = explode('\\', $class);
            $class = end($pathToClass);

            if (file_exists(str_replace('Controller', 'Model/', __DIR__) . $class . '.php')) {
                require_once str_replace('Controller', 'Model/', __DIR__) . $class . '.php';
            } else {
                require_once str_replace('Controller', 'Config/', __DIR__) . $class . '.php';
            };
        }
    );

    use Testes\Projetos\PHP\CRUD\Model\Token;
    use Testes\Projetos\PHP\CRUD\Model\TokenDAO;
    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\User;
    use Testes\Projetos\PHP\CRUD\Model\UserDAO;

    if (!empty($_GET['token'])) {
        $hash = \filter_input(\INPUT_GET, 'token', \FILTER_UNSAFE_RAW);

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
            $pass = \password_hash(\filter_input(\INPUT_POST, 'pass', \FILTER_UNSAFE_RAW), \PASSWORD_BCRYPT);
            $user->setPassword($pass);

            $user_dao = new UserDAO($connection);
            $user_dao->updateUserPassword($user);

            $token->setID($token_info->getID());
            $token_dao->updateTokenStatus($token);

            \session_start();
            $_SESSION['flashMensagem'] = 'Password updated successfully!';

            \header('location: index.php');
            exit;
        };


    } else{
        \header('location: index.php');
        exit;
    };

?>