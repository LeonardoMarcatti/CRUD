<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    require_once '../Config/Connection.php';
    include_once '../Model/Endereco.php';
    include_once '../Model/Telefone.php';
    include_once '../Model/Clientes.php';
    include_once '../Model/Email.php';

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\Email;
    use Testes\Projetos\PHP\CRUD\Model\EmailDAO;
    use Testes\Projetos\PHP\CRUD\Model\Clientes;
    use Testes\Projetos\PHP\CRUD\Model\ClientesDAO;
    use Testes\Projetos\PHP\CRUD\Model\ClienteTelefoneDAO;
    use Testes\Projetos\PHP\CRUD\Model\Cidade;
    use Testes\Projetos\PHP\CRUD\Model\CidadeDAO;
    use Testes\Projetos\PHP\CRUD\Model\Endereco;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoDAO;
    use Testes\Projetos\PHP\CRUD\Model\Bairro;
    use Testes\Projetos\PHP\CRUD\Model\BairroDAO;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoCliente;
    use Testes\Projetos\PHP\CRUD\Model\EnderecoClienteDAO;
    use Testes\Projetos\PHP\CRUD\Model\DDD;
    use Testes\Projetos\PHP\CRUD\Model\DDD_DAO;
    use Testes\Projetos\PHP\CRUD\Model\Telefone;
    use Testes\Projetos\PHP\CRUD\Model\TelefoneDAO;
    use Testes\Projetos\PHP\CRUD\Model\ClienteTelefone;
    use PDO;

    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: login.php');
        exit;
    };
    
    $idendereco_atual = filter_input(INPUT_GET, 'idendereco', FILTER_SANITIZE_NUMBER_INT);
    $idcliente = filter_input(INPUT_GET, 'idcliente', FILTER_SANITIZE_NUMBER_INT);
    $id_tel_atual = filter_input(INPUT_GET, 'idtel', FILTER_SANITIZE_NUMBER_INT);
    $idemail_atual = filter_input(INPUT_GET, 'idemail', FILTER_SANITIZE_NUMBER_INT);
    $del_id = filter_input(INPUT_GET, 'del', FILTER_VALIDATE_INT);
    $connection = Connection::getConnection();

    if (!empty($_POST['delete_id'])) {
        $del = $_POST['delete_id'];
        $del_dao = new ClientesDAO($connection);
        $del_cliente = new Clientes();
        $del_cliente->setID($del);
        $del_dao->delete($del_cliente);
        header("location: crud.php");
        exit;
    };

    if (isset($_POST['logradouro']) && $_POST['endereco'] != '' && $_POST['numero'] != '' && $_POST['bairro'] != '' && $_POST['cidade'] != '' && $_POST['estado'] != '') {

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

        $new_endereco_clienteDAO = new EnderecoClienteDAO($connection);
        $new_endereco_cliente = new EnderecoCliente();

        $new_email = new Email();
        $new_email_dao = new EmailDAO($connection);

        $new_ddd_dao = new DDD_DAO($connection);
        $newddd = new DDD();

        $newtelefone = new Telefone();
        $new_telefone_dao = new TelefoneDAO($connection);

        $new_cliente_telefone = new ClienteTelefone();
        $new_clientetelefone_dao = new ClienteTelefoneDAO($connection);

        $id_bairro = $new_bairro_dao->checkBairro($bairro);
        
        if ($id_bairro) {
            $new_endereco->setBairro($id_bairro);
        } else {
            $new_bairro->setNome($bairro);
            $new_bairro_dao->add($new_bairro);
            $id_bairro = $new_bairro_dao->checkBairro($bairro);
            $new_endereco->setBairro($id_bairro);
        };
        
        $id_cidade = $new_cidade_dao->checkCidade($cidade);

        if ($id_cidade) {
            $new_endereco->setCidade($id_cidade);
        } else {            
            $new_cidade->setNome($cidade);
            $new_cidade_dao->add($new_cidade);
            $id_cidade = $new_cidade_dao->checkCidade($cidade);
            $new_endereco->setCidade($id_cidade);
        };
        
        $new_endereco->setTipo($logradouro);
        $new_endereco->setEndereco($endereco);
        $new_endereco->setnumero($numero);
        $new_endereco->setComplemento($complemento);
        $new_endereco->setEstado($estado);

        $id_endereco = $new_endereco_dao->checkEndereco($new_endereco); #Cheque de existencia de endereço

        if (!$id_endereco) {
            $new_endereco_dao->add($new_endereco);
            $id_endereco = $new_endereco_dao->checkEndereco($new_endereco);
        };

        $new_endereco_cliente->setIDEndereco($id_endereco);
        
        if ($ddd && $tel) {
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
            $newtelefone->setNumero($tel);
            $checked_fone = $new_telefone_dao->checkTelefone($newtelefone);

            if (!$checked_fone) {
                $new_telefone_dao->add($newtelefone);
                $checked_fone = $new_telefone_dao->checkTelefone($newtelefone);
            };
            $new_endereco_cliente->setIDEndereco($id_endereco);
            $new_cliente_telefone->setIDTelefone($checked_fone);
        };

        if ($idcliente && $idemail_atual) {
            $new_endereco_cliente->setIDCliente($idcliente);
            $new_email->setEndereco($email);
            $new_email->setClienteID($idcliente);
            $checked_email_id = $new_email_dao->checkEmail($new_email);
            if (!$email) {
                $new_email_dao->delete($idemail_atual);
            } elseif ($idemail_atual && !$checked_email_id) {
                $new_email_dao->update($new_email);
            } elseif (!$idemail_atual && !$checked_email_id) {
                $new_email->setClienteID($idcliente);
                $new_email_dao->add($new_email);
            } elseif ($idemail_atual && ($checked_email_id != $idemail_atual)) {
                $_SESSION['flash_details'] = 'Email em uso!';
            };            

            if ($idendereco_atual) {
                $new_endereco_clienteDAO->update($new_endereco_cliente, $idendereco_atual);

                if ($id_tel_atual != $checked_fone) {
                    $new_cliente_telefone->setIDCliente($idcliente);
                    $new_clientetelefone_dao->update($new_cliente_telefone, $id_tel_atual);
                };

            } else {
                $new_endereco_clienteDAO->add($new_endereco_cliente);
            };

            header('location: details.php?cod=' . $idcliente);
            exit;
        };

        if ($idcliente) {
            $new_endereco_cliente->setIDCliente($idcliente);
            $new_endereco_clienteDAO->add($new_endereco_cliente);
            header('location: details.php?cod=' . $idcliente);
            exit;
        };
         

        //Adição de novo cliente
        if (isset($_POST['nome']) && $_POST['sobrenome']!= '' && $_POST['sex']!= '') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING) . ' ' . filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);

            $new_cliente = new Clientes();
            $new_cliente_dao =  new ClientesDAO($connection);

            $new_cliente->setNome($nome);
            $sex_id = $new_cliente_dao->getSexID($sex);
            $new_cliente->setSexo($sex_id);
            $new_cliente_dao->add($new_cliente);
            $new_endereco_cliente->setIDCliente($new_cliente->getID());
            $new_endereco_clienteDAO->add($new_endereco_cliente);
            $new_cliente_telefone->setIDCliente($new_cliente->getID());
            $new_clientetelefone_dao->add($new_cliente_telefone);
            
            if ($email) {
                $new_email->setEndereco($email);
                if ($new_email_dao->checkEmail($new_email)) {
                    $_SESSION['flash'] = 'Email em uso'; 
                } else {
                    $new_email->setClienteID($new_cliente->getID());
                    $new_email_dao->add($new_email);
                };
                header('location: crud.php');
                exit;
            };
        };
    };

    function getDetails($val){
        global $connection;
        $query = "select * from v_tudo where id = :cod";
        $result = $connection->prepare($query);
        $result->bindParam(':cod', $val);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    };

    function GetValue($value){
        global $connection, $idcliente, $idendereco_atual, $del_id;
        
        if ($idcliente) {
            $sql = "select * from v_tudo where id = :value";
            $result = $connection->prepare($sql);
            $result->bindParam(':value', $idcliente);
        } elseif($del_id){
            $sql = "select * from v_tudo where id = :value";
            $result = $connection->prepare($sql);
            $result->bindParam(':value', $del_id);
        }else {            
            $sql = "select * from v_tudo where id_endereco = :value";
            $result = $connection->prepare($sql);
            $result->bindParam(':value', $idendereco_atual);
        };

        $result->execute(); 
        $row = $result->fetch(PDO::FETCH_ASSOC)[$value];
        return $row;
    };
?>