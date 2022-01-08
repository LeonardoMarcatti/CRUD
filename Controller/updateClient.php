<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    require_once '../Model/Clientes.php';
    require_once '../Model/Email.php';
    require_once '../Model/Endereco.php';
    require_once '../Model/Telefone.php';
    require_once '../Config/Connection.php';

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\Clientes;
    use Testes\Projetos\PHP\CRUD\Model\ClientesDAO;
    use Testes\Projetos\PHP\CRUD\Model\Email;
    use Testes\Projetos\PHP\CRUD\Model\EmailDAO;
    use Testes\Projetos\PHP\CRUD\Model\Endereco;
    use Testes\Projetos\PHP\CRUD\Model\Bairro;
    use Testes\Projetos\PHP\CRUD\Model\BairroDAO;
    use Testes\Projetos\PHP\CRUD\Model\Cidade;
    use Testes\Projetos\PHP\CRUD\Model\CidadeDAO;
    use Testes\Projetos\PHP\CRUD\Model\EstadoDAO;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoDAO;
    use Testes\Projetos\PHP\CRUD\Model\TipoLogradouroDAO;
    use Testes\Projetos\PHP\CRUD\Model\Telefone;
    use Testes\Projetos\PHP\CRUD\Model\TelefoneDAO;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoCliente;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoClienteDAO;
    use Testes\Projetos\PHP\CRUD\Model\TipoTelefoneDAO;
    use Testes\Projetos\PHP\CRUD\Model\ClienteTelefone;
    use Testes\Projetos\PHP\CRUD\Model\ClienteTelefoneDAO;
    use Testes\Projetos\PHP\CRUD\Model\DDD;
    use Testes\Projetos\PHP\CRUD\Model\DDD_DAO;

    $client_id = \filter_input(\INPUT_GET, 'idcliente', \FILTER_SANITIZE_NUMBER_INT);
    $current_address_id = \filter_input(\INPUT_GET, 'idendereco', \FILTER_SANITIZE_NUMBER_INT);
    $current_tel_id = \filter_input(\INPUT_GET, 'idtel', \FILTER_SANITIZE_NUMBER_INT);
    $current_email_id = \filter_input(\INPUT_GET, 'idemail', \FILTER_SANITIZE_NUMBER_INT);


    $connection = Connection::getConnection();

    $client = new Clientes;
    $client_dao = new ClientesDAO($connection);

    $tipoLogradouro_dao = new TipoLogradouroDAO($connection);
    $log_list = $tipoLogradouro_dao->getAllLogradouros();

    $address = new Endereco;
    $address->setID($current_address_id);

    $address_dao = new EnderecoDAO($connection);
    $current_address_details = $address_dao->getEnderecoDetails($address);

    $states_dao = new EstadoDAO($connection);
    $state_list = $states_dao->getAllEstados();
    $current_state_id = $current_address_details['id_estado'];

    $telefone_dao = new TipoTelefoneDAO($connection);
    $telefone_types = $telefone_dao->getAllTipoTelefones();

    if (!empty($_POST['logradouro']) && $_POST['endereco'] && $_POST['numero'] && $_POST['bairro'] && $_POST['cidade'] && $_POST['estado'] && $_POST['ddd'] && $_POST['telefone'] && $_POST['tipo_telefone']) {

        $logradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_NUMBER_INT);
        $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
        $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
        $complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
        $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
        $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_NUMBER_INT);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $ddd = filter_input(INPUT_POST, 'ddd', FILTER_SANITIZE_NUMBER_INT);
        $tel = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
        $tipo = filter_input(INPUT_POST, 'tipo_telefone', FILTER_SANITIZE_NUMBER_INT);

        $new_endereco = new Endereco();
        $new_endereco_dao = new EnderecoDAO($connection);

        $new_bairro = new Bairro();
        $new_bairro_dao = new BairroDAO($connection);

        $new_cidade = new Cidade();
        $new_cidade_dao = new CidadeDAO($connection);

        $new_endereco_cliente = new EnderecoCliente();
        $new_endereco_clienteDAO = new EnderecoClienteDAO($connection);
        
        $new_email = new Email();
        $new_email_dao = new EmailDAO($connection);

        $newddd = new DDD();
        $new_ddd_dao = new DDD_DAO($connection);
        
        $newtelefone = new Telefone();
        $new_telefone_dao = new TelefoneDAO($connection);

        $new_cliente_telefone = new ClienteTelefone();
        $new_clientetelefone_dao = new ClienteTelefoneDAO($connection);

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
        $new_endereco_cliente->setIDCliente($client_id);
        $new_endereco_clienteDAO->update($new_endereco_cliente, $current_address_id);

        $newddd->setNumero($ddd);
        $id_ddd = $new_ddd_dao->checkDDD($newddd);

        if ($id_ddd) {
            $newtelefone->setDDD($id_ddd);
        } else {
            $new_ddd_dao->addDDD($newddd);
            $id_ddd = $new_ddd_dao->checkDDD($newddd);
            $newtelefone->setDDD($id_ddd);
        };
        
        $newtelefone->setTipo($tipo);
        $newtelefone->setNumber($tel);
        $checked_fone = $new_telefone_dao->checkTelefone($newtelefone);

        if (!$checked_fone) {
            $new_telefone_dao->add($newtelefone);
            $checked_fone = $new_telefone_dao->checkTelefone($newtelefone);
        };

        $new_cliente_telefone->setIDTelefone($checked_fone);
        $new_cliente_telefone->setIDCliente($client_id);
        $new_clientetelefone_dao->update($new_cliente_telefone, $current_tel_id);
        
        if (!empty($email)) {
            $new_email->setAddress($email);
            $checked_email = $new_email_dao->checkEmail($new_email);
            if (!empty($checked_email)) {
                if ($checked_email->getClienteID() != $client_id) {
                    $_SESSION['flash'] = 'Email em uso'; 
                } else {
                    $new_email->setClienteID($client_id);
                    $new_email_dao->update($new_email);
                };
            } elseif($client_id && ($current_email_id != '')){
                $new_email->setClienteID($client_id);
                $new_email_dao->update($new_email);
                echo 'a';
            } else{
                $new_email->setClienteID($client_id);
                $new_email_dao->add($new_email);
                echo 'b';
            };
        }else{
            $new_email_dao->delete($client_id);
        };

        header('location: ../View/details.php?id=' . $client_id);
        exit;
    };

?>