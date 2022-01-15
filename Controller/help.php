<?php
    namespace Testes\Projetos\PHP\CRUD\View;
  
    require_once '../Config/Connection.php';
    include_once '../Model/Endereco.php';
    include_once '../Model/Telefone.php';
    include_once '../Model/Image.php';
    include_once '../Model/User.php';
    include_once '../Model/Clientes.php';

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\TipoLogradouroDAO;
    use Testes\Projetos\PHP\CRUD\Model\EstadoDAO;
    use Testes\Projetos\PHP\CRUD\Model\TipoTelefoneDAO;
    use Testes\Projetos\PHP\CRUD\Model\User;
    use Testes\Projetos\PHP\CRUD\Model\UserDAO;
    use Testes\Projetos\PHP\CRUD\Model\Image;
    use Testes\Projetos\PHP\CRUD\Model\ImageDAO;
    use Testes\Projetos\PHP\CRUD\Model\Clientes;
    use Testes\Projetos\PHP\CRUD\Model\ClientesDAO;

    $connection = Connection::getConnection();
    $tipo_log = new TipoLogradouroDAO($connection);
    $tipo = $tipo_log->getAllLogradouros();

    $estados = new EstadoDAO($connection);
    $lista_estados = $estados->getAllEstados();

    $telefone = new TipoTelefoneDAO($connection);
    $lista_tipos_telefone = $telefone->getAllTipoTelefones();

    $user = new User;
    $user->setName($_SESSION['user']);

    $userDAO = new UserDAO($connection);
    $user_info = $userDAO->getUserByName($user);

    $image = new Image;
    $image->setUserID($user_info->getID());

    $imageDAO = new ImageDAO($connection);
    $image_info = $imageDAO->getUserImage($image);

    $client = new Clientes;
    $clientDAO = new ClientesDAO($connection);

?>