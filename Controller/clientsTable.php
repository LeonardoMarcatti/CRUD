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

    use Testes\Projetos\PHP\CRUD\Model\Clientes;
    use Testes\Projetos\PHP\CRUD\Model\ClientesDAO;
    use Testes\Projetos\PHP\CRUD\Config\Connection;

    $connection = Connection::getConnection();
    $client = new Clientes;
    $clientDAO = new ClientesDAO($connection);

    if (!empty($_POST['id']) && $_POST['id'] != '') {
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $client->setID(intval($id));
        $result = $clientDAO->getClientByID($client);

    } elseif (!empty($_POST['name']) && $_POST['name'] != ''){
        $name = \filter_input(\INPUT_POST, 'name', \FILTER_UNSAFE_RAW);
        $client->setName($name);
        $result = $clientDAO->getClientByName($client);
    } else{
        $result = $clientDAO->findAll();
    };

    echo \json_encode($result);
?>