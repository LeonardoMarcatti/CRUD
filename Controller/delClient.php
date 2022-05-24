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
    use Testes\Projetos\PHP\CRUD\Model\Clientes;
    use Testes\Projetos\PHP\CRUD\Model\ClientesDAO;

    $del_id = filter_input(INPUT_GET, 'del', FILTER_VALIDATE_INT);
    
    $connection = Connection::getConnection();
    $client = new Clientes;
    $dao = new ClientesDAO($connection);

    $client->setID($del_id);
    $info = $dao->getClientByID($client);

    if (!empty($_POST['del'])) {
       $dao->delete($client);
       \header('location: crud.php');
       exit;
    };

?>