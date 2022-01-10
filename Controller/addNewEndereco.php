<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    require_once '../Model/Clientes.php';
    require_once '../Model/Endereco.php';
    require_once '../Config/Connection.php';

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\Endereco;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoDAO;
    use Testes\Projetos\PHP\CRUD\Model\Bairro;
    use Testes\Projetos\PHP\CRUD\Model\BairroDAO;
    use Testes\Projetos\PHP\CRUD\Model\Cidade;
    use Testes\Projetos\PHP\CRUD\Model\CidadeDAO;
    use Testes\Projetos\PHP\CRUD\Model\EstadoDAO;
    use Testes\Projetos\PHP\CRUD\Model\TipoLogradouroDAO;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoCliente;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoClienteDAO;

    $id = filter_input(INPUT_GET, 'idcliente', FILTER_SANITIZE_NUMBER_INT);

    $connection = Connection::getConnection();
    $tipoLogradouro_dao = new TipoLogradouroDAO($connection);
    $estados_dao = new EstadoDAO($connection);

    $new_endereco = new Endereco();
    $new_endereco_dao = new EnderecoDAO($connection);

    $new_bairro = new Bairro();
    $new_bairro_dao = new BairroDAO($connection);

    $new_cidade = new Cidade();
    $new_cidade_dao = new CidadeDAO($connection);

    $new_endereco_cliente = new EnderecoCliente();
    $new_endereco_clienteDAO = new EnderecoClienteDAO($connection);

    $new_endereco_cliente->setIDCliente($id);

    $listaLogradouros = $tipoLogradouro_dao->getAllLogradouros();
    $listaestados = $estados_dao->getAllEstados();

    if (!empty($_POST['logradouro']) && !empty($_POST['endereco']) && !empty($_POST['numero']) && !empty($_POST['bairro']) && !empty($_POST['cidade']) && !empty($_POST['estado'])) {

        $logradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_NUMBER_INT);
        $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
        $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
        $complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
        $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
        $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_NUMBER_INT);

        $id_bairro = $new_bairro_dao->checkBairro($bairro);

        if ($id_bairro) {
            $new_endereco->setBairro($id_bairro);
        } else {
            $new_bairro->setName($bairro);
            $new_bairro_dao->addNewBairro($new_bairro);
            $id_bairro = $new_bairro_dao->checkBairro($bairro);
            $new_endereco->setBairro($id_bairro);
        };

        $id_cidade = $new_cidade_dao->checkCidade($cidade);

        if ($id_cidade) {
            $new_endereco->setCidade($id_cidade);
        } else {            
            $new_cidade->setName($cidade);
            $new_cidade_dao->addNewCidade($new_cidade);
            $id_cidade = $new_cidade_dao->checkCidade($cidade);
            $new_endereco->setCidade($id_cidade);
        };

        $new_endereco->setTipo($logradouro);
        $new_endereco->setEndereco($endereco);
        $new_endereco->setnumero($numero);
        $new_endereco->setComplement($complemento);
        $new_endereco->setEstado($estado);

        $id_endereco = $new_endereco_dao->checkEndereco($new_endereco);

        if (!$id_endereco) {
            $new_endereco_dao->addNewEndereco($new_endereco);
            $id_endereco = $new_endereco_dao->checkEndereco($new_endereco);
        };
        
        $new_endereco_cliente->setIDEndereco($id_endereco);
        $new_endereco_clienteDAO->add($new_endereco_cliente);

        \header('location: ../View/details.php?id=' . $id);
        exit;
    };

?>