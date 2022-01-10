<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    include_once '../Model/Clientes.php';
    include_once '../Config/Connection.php';

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\Clientes;
    use Testes\Projetos\PHP\CRUD\Model\ClientesDAO;

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $connection = Connection::getConnection();
    $dao = new ClientesDAO($connection);
    $client_info = $dao->getDetails($id);

?>