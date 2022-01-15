<?php
     namespace Testes\Projetos\PHP\CRUD\Controller;

     require_once '../View/assets/session.php';
     require_once '../Config/Connection.php';
     require_once '../Model/User.php';

     use Testes\Projetos\PHP\CRUD\Config\Connection;
     use Testes\Projetos\PHP\CRUD\Model\User;
     use Testes\Projetos\PHP\CRUD\Model\UserDAO;

      if ($_GET['id']) {
      $id = \filter_input(\INPUT_GET, 'id', \FILTER_SANITIZE_NUMBER_INT);

      $connection = Connection::getConnection();
      $user = new User;
      $user_dao = new UserDAO($connection);

      $user->setID($id);
      $user_info = $user_dao->getUserByID($user);

      $_SESSION['user'] = $user_info->getName();
      
      } else {
         header('location: ../View/login.php');
         exit;
      };



     if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['pass'])) {
         $name = \filter_input(\INPUT_POST, 'name', \FILTER_SANITIZE_STRING);
         $email = \filter_input(\INPUT_POST, 'email', \FILTER_SANITIZE_EMAIL);
         $pass = password_hash(filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING), PASSWORD_BCRYPT);

         $user->setName($name);
         $user->setEmail($email);
         $user->setPassword($pass);

         $user_dao->updateUser($user);

         \header('location: ../View/crud.php');
         exit;
     };