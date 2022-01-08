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
    use Testes\Projetos\PHP\CRUD\Model\Estado;
    use Testes\Projetos\PHP\CRUD\Model\EstadoDAO;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoDAO;
    use Testes\Projetos\PHP\CRUD\Model\Telefone;
    use Testes\Projetos\PHP\CRUD\Model\TelefoneDAO;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoCliente;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoClienteDAO;
    use Testes\Projetos\PHP\CRUD\Model\TipoTelefoneDAO;
    use Testes\Projetos\PHP\CRUD\Model\ClienteTelefone;
    use Testes\Projetos\PHP\CRUD\Model\ClienteTelefoneDAO;
    use Testes\Projetos\PHP\CRUD\Model\DDD;
    use Testes\Projetos\PHP\CRUD\Model\DDD_DAO;

    if (isset($_POST['nome']) && $_POST['sobrenome']!= '' && $_POST['sex']!= '') {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING) . ' ' . filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
        $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);

        $connection = Connection::getConnection();
        $new_cliente = new Clientes();
        $new_cliente_dao =  new ClientesDAO($connection);

        $new_cliente->setName($nome);
        $sex_id = $new_cliente_dao->getSexID($sex);
        $new_cliente->setSex($sex_id);
        $new_cliente_dao->addNewClient($new_cliente);
        $new_client_id = $new_cliente_dao->getMaxId();

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
        $new_endereco_cliente->setIDCliente($new_client_id);
        $new_endereco_clienteDAO->add($new_endereco_cliente);

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
        $new_cliente_telefone->setIDCliente($new_client_id);
        $new_clientetelefone_dao->add($new_cliente_telefone);
        
        if ($email) {
            $new_email->setAddress($email);
            if ($new_email_dao->checkEmail($new_email)) {
                $_SESSION['flash'] = 'Email em uso'; 
            } else {
                $new_email->setClienteID($new_client_id);
                $new_email_dao->add($new_email);
            };
        };

        header('location: ../View/crud.php');
        exit;
    };

?>