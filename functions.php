<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: login.php');
        exit;
    };

    require_once 'conection.php';
    include_once('classes/endereco.php');
    include_once('classes/telefone.php');
    include_once('classes/clientes.php');
    include_once('classes/email.php');

    use CRUD\classes\Email;
    use CRUD\classes\EmailDAO;
    use CRUD\classes\Clientes;
    use CRUD\classes\ClientesDAO;
    use CRUD\classes\ClienteTelefoneDAO;
    use CRUD\classes\Cidade;
    use CRUD\classes\CidadeDAO;
    use CRUD\classes\Endereco;
    use CRUD\classes\EnderecoDAO;
    use CRUD\classes\Bairro;
    use CRUD\classes\BairroDAO;
    use CRUD\classes\EnderecoCliente;
    use CRUD\classes\EnderecoClienteDAO;
    use CRUD\classes\DDD;
    use CRUD\classes\DDD_DAO;
    use CRUD\classes\Telefone;
    use CRUD\classes\TelefoneDAO;
    use CRUD\classes\ClienteTelefone;
    

    $idendereco_atual = filter_input(INPUT_GET, 'idendereco', FILTER_SANITIZE_NUMBER_INT);
    $idcliente = filter_input(INPUT_GET, 'idcliente', FILTER_SANITIZE_NUMBER_INT);
    $id_tel_atual = filter_input(INPUT_GET, 'idtel', FILTER_SANITIZE_NUMBER_INT);
    $idemail_atual = filter_input(INPUT_GET, 'idemail', FILTER_SANITIZE_NUMBER_INT);
    $del_id = filter_input(INPUT_GET, 'del', FILTER_VALIDATE_INT);

    if (!empty($_POST['delete_id'])) {
        $del = $_POST['delete_id'];
        $del_dao = new ClientesDAO($conection);
        $del_cliente = new Clientes();
        $del_cliente->setID($del);
        $del_dao->delete($del_cliente);
        header("location: crud.php");
        exit;
    };

    if (!empty($_POST['logradouro']) && $_POST['endereco'] != '' && $_POST['numero'] != '' && $_POST['bairro'] != '' && $_POST['cidade'] != '' && $_POST['estado'] != '') {

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
        $new_endereco_dao = new EnderecoDAO($conection);

        $new_bairro = new Bairro();
        $new_bairro_dao = new BairroDAO($conection);

        $new_cidade = new Cidade();
        $new_cidade_dao = new CidadeDAO($conection);

        $new_endereco_clienteDAO = new EnderecoClienteDAO($conection);
        $new_endereco_cliente = new EnderecoCliente();

        $new_email = new Email();
        $new_email_dao = new EmailDAO($conection);

        $new_ddd_dao = new DDD_DAO($conection);
        $newddd = new DDD();

        $newtelefone = new Telefone();

        $new_telefone_dao = new TelefoneDAO($conection);
        $new_clientetelefone_dao = new ClienteTelefoneDAO($conection);

        $new_cliente_telefone = new ClienteTelefone();

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

        $id_email = '';
        if($email != ''){
            $new_email->setEndereco($email);
            $id_email = $new_email_dao->checkEmail($new_email);
            if ($id_email) {
                $_SESSION['flash_details'] = 'Email em uso!'; 
            };            
            header('location: details.php?cod=' . $idcliente);
            exit;
        };
        
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

        if ($idcliente) {
            $new_endereco_cliente->setIDCliente($idcliente);
            if (!$email) {
                $new_email_dao->delete($idemail_atual);
            } elseif ($idemail_atual && !$id_email) {
                $new_email->setClienteID($idcliente);
                $new_email_dao->update($new_email);
            } elseif (!$idemail_atual && !$id_email) {
                $new_email->setClienteID($idcliente);
                $new_email_dao->add($new_email);
            };            

            if ($idendereco_atual) {
                $new_endereco_clienteDAO->update($new_endereco_cliente, $idendereco_atual);

                if ($id_tel_atual != $checked_fone) {
                    $new_cliente_telefone->setIDCliente($idcliente);
                    $new_clientetelefone_dao->update($new_cliente_telefone, $id_tel_atual);
                };
                header('location: details.php?cod=' . $idcliente);
                exit;
            } else {
                $new_endereco_clienteDAO->add($new_endereco_cliente);
                header('location: details.php?cod=' . $idcliente);
                exit;
            };
        };
         
        if ($_POST['nome'] != '' && $_POST['sobrenome']!= '' && $_POST['sex']!= '') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING) . ' ' . filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);

            $new_cliente = new Clientes();
            $new_cliente_dao =  new ClientesDAO($conection);

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

    function GetUserImage(){
        global $conection;
        $current_user = $_SESSION['user'];
        $sql = "select caminho from users u join image i on u.id = i.iduser where u.nome_de_usuario = :current_user";
        $path = $conection->prepare($sql);
        $path->bindValue(':current_user', $current_user);
        $path->execute();
        $foto = $path->fetch(PDO::FETCH_ASSOC)['caminho'];
        if ($foto) {
            return $foto;
        } else {
            return false;
        };        
    };

    function GetUserImageTitle(){
        global $conection;
        $current_user = $_SESSION['user'];
        $sql = "select nome from users u join image i on u.id = i.iduser where u.nome_de_usuario = :current_user";
        $alt = $conection->prepare($sql);
        $alt->bindParam(':current_user', $current_user);
        $alt->execute();
        if ($alt) {
            return $alt->fetch(PDO::FETCH_ASSOC)['nome'];
        } else {
            return false;
        };        
    };

    function getDetails($val){
        global $conection;
        $query = "select * from v_tudo where id = :cod";
        $result = $conection->prepare($query);
        $result->bindParam(':cod', $val);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    };

    function GetValue($value){
        global $conection, $idcliente, $idendereco_atual, $del_id;
        
        if ($idcliente) {
            $sql = "select * from v_tudo where id = :value";
            $result = $conection->prepare($sql);
            $result->bindParam(':value', $idcliente);
        } elseif($del_id){
            $sql = "select * from v_tudo where id = :value";
            $result = $conection->prepare($sql);
            $result->bindParam(':value', $del_id);
        }else {            
            $sql = "select * from v_tudo where id_endereco = :value";
            $result = $conection->prepare($sql);
            $result->bindParam(':value', $idendereco_atual);
        };

        $result->execute(); 
        $row = $result->fetch(PDO::FETCH_ASSOC)[$value];
        return $row;
    };
?>