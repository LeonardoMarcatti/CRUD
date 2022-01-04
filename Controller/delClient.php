<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    include_once '../Model/Clientes.php';
    include_once '../Config/Connection.php';

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
       $id = \filter_input(\INPUT_POST, 'del', \FILTER_SANITIZE_NUMBER_INT);

       $dao->delete($client);
       \header('location: crud.php');
       exit;
    };

?>