<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    require_once '../Config/Connection.php';
    require_once '../Model/User.php';
    require_once '../Model/Token.php';

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

            echo "<a href=\"../View/redefinir.php?token=$hash\">Redefinir Senha</a>";
            exit;
        };
    };
?>