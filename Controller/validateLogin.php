<?php

namespace Testes\Projetos\PHP\CRUD\Controller;

spl_autoload_register(
   function ($class) {
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

if (isset($_POST['username']) && isset($_POST['password'])) {
   $username = filter_input(INPUT_POST, 'username', FILTER_UNSAFE_RAW);
   $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

   $connection = Connection::getConnection();
   $user = new User;
   $userDAO = new UserDAO($connection);
   $all = $userDAO->getAll();

   foreach ($all as $key => $value) {
      if (password_verify($password, $value['password']) && password_verify($username, $value['username'])) {
         $name = $value['name'];
         $user->setName($name);
         session_start();
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
};

echo "<h3>Senha e/ou email errados.<br>Tente Novamente.</h3>";
echo "<h4><a href=\"../View/index.php\">Clique aqui para volar</a></h4>";
