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

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\User;
    use Testes\Projetos\PHP\CRUD\Model\UserDAO;
    use Testes\Projetos\PHP\CRUD\Model\Token;
    use Testes\Projetos\PHP\CRUD\Model\TokenDAO;

    if (!empty($_POST['email'])) {
        $email = \filter_input(\INPUT_POST, 'email', \FILTER_SANITIZE_EMAIL);

        $connection = Connection::getConnection();
        $user = new User;
        $user->setEmail($email);

        $user_dao = new UserDAO($connection);
        $user_info = $user_dao->getUserByEmail($user);

        if ($user_info) {
            $hash = md5($user_info->getEmail() . $user_info->getName() . time());
            
            $token = new Token;
            $token->setUserID($user_info->getID());
            $token->setHash($hash);
            $token->setExpireIn(date('Y-m-d H:i:s', \strtotime('+2 hours')));

            $token_dao = new TokenDAO($connection);
            $token_dao->insertToken($token);

            header('location: ../View/redefinir.php?token=' . $hash);
            exit;
        }else{
            \session_start();
            $_SESSION['flashError'] = 'Email not found!';
            header('location: ../View/index.php');
            exit;
        };
    };
?>