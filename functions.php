<?php
    require_once 'conection.php';

    if (!isset($_SESSION['user'])) {
        header('location: login.php');
        exit;
    };

    if ($_POST['delete_id'] != '') {
        excludeEnderecoCliente($cliente_id);
        excludeEmail($cliente_id);
        excludeClienteTelefone($cliente_id);
        excludeCliente($cliente_id);
        header("location: crud.php");
        exit;
    };

    if ($_POST['logradouro'] != '' && $_POST['endereco'] != '' && $_POST['numero'] != '' && $_POST['bairro'] != '' && $_POST['cidade'] != '' && $_POST['estado'] != '') {

        $logradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_NUMBER_INT);
        $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
        $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
        $complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
        $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
        $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_NUMBER_INT);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);


        if ($_GET['idcliente']) {
            $checked_endereco = checkEndereco($logradouro, $numero, $endereco, $complemento, CheckBairro($bairro), CheckCidade($cidade), $estado);
            if ($checked_endereco) {
                insereEnderecoCliente($idcliente, $checked_endereco);
            } else {
                insereEndereco($logradouro, $endereco, $numero, $complemento, $bairro, $cidade, $estado);
                $id_novo_endereco = checkEndereco($logradouro, $numero, $endereco, $complemento, CheckBairro($bairro), CheckCidade($cidade), $estado);
                insereEnderecoCliente($idcliente, $id_novo_endereco);
            }
            header("location: details.php?cod=" . $idcliente);
            exit;
        };

        if ($_POST['ddd'] != '' && $_POST['telefone'] != '' && $_POST['tipo_telefone'] != '') {

            $ddd = filter_input(INPUT_POST, 'ddd', FILTER_SANITIZE_NUMBER_INT);
            $tel = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
            $tipo = filter_input(INPUT_POST, 'tipo_telefone', FILTER_SANITIZE_NUMBER_INT);

            if ($_GET['codendereco'] && $_GET['id_cliente']) {
                $endereco_atual = $_GET['codendereco'];
                $checked_endereco = checkEndereco($logradouro, $numero, $endereco, $complemento, CheckBairro($bairro), CheckCidade($cidade), $estado);

                if ($checked_endereco) {
                    updateEnderecoCliente($id_cliente, $checked_endereco, $endereco_atual);
                } else {
                    insereEndereco($logradouro, $endereco, $numero, $complemento, $bairro, $cidade, $estado);
                    $id_novo_endereco = checkEndereco($logradouro, $numero, $endereco, $complemento, CheckBairro($bairro), CheckCidade($cidade), $estado);
                    updateEnderecoCliente($id_cliente, $id_novo_endereco, $endereco_atual);
                };
    
                if ($email != '') {
                    if(checkEmailId($id_cliente)) {
                       updateEmail($email, $id_cliente);
                    } else {
                        insereEmail($email, $id_cliente);
                    };                
                }

                if (checkDDD($ddd)) {
                    if (checkTelefone($ddd, $tel, $tipo)) {
                        $id = checkTelefone($ddd, $tel, $tipo);
                    }else{
                        $id_ddd = checkDDD($ddd);
                        insereTelefone($tel, $id_ddd, $tipo);
                        $id = checkTelefone($ddd, $tel, $tipo);
                    };
                 } else {
                     insereDDD($ddd);
                     $id_ddd = checkDDD($ddd);
                     insereTelefone($tel, $id_ddd, $tipo);
                     $id = checkTelefone($ddd, $tel, $tipo);
                 };
                 
                 updateClieteTelefone($id_cliente, $id);
                header("location: details.php?cod=" . $id_cliente);
                exit; 
            };            
        };
         
        
        if ($_POST['nome'] != '' && $_POST['sobrenome']!= '' && $_POST['sex']!= '') {

            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);
            $fullname = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING) . ' ' . filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);            
            insertCliente($fullname, $sex);
            $id_novo_cliente = $conection->query("select max(id) as 'id' from cliente")->fetch(PDO::FETCH_ASSOC)['id'];
            $id_endereco = checkEndereco($logradouro, $numero, $endereco, $complemento, CheckBairro($bairro), CheckCidade($cidade), $estado);

            if ($id_endereco) {
                insereEnderecoCliente($id_novo_cliente, $id_endereco);
            } else {
              insereEndereco($logradouro, $endereco, $numero, $complemento, $bairro, $cidade, $estado);
              $id_endereco = checkEndereco($logradouro, $numero, $endereco, $complemento, CheckBairro($bairro), CheckCidade($cidade), $estado);
              insereEnderecoCliente($id_novo_cliente, $id_endereco);
            };

            if (checkDDD($ddd)) {
                if (checkTelefone($ddd, $tel, $tipo)) {
                    $id = checkTelefone($ddd, $tel, $tipo);
                }else{
                    $id_ddd = checkDDD($ddd);
                    insereTelefone($tel, $id_ddd, $tipo);
                    $id = checkTelefone($ddd, $tel, $tipo);
                };
             } else {
                 insereDDD($ddd);
                 $id_ddd = checkDDD($ddd);
                 insereTelefone($tel, $id_ddd, $tipo);
                 $id = checkTelefone($ddd, $tel, $tipo);
             };

             insereClieteTelefone($id_novo_cliente, $id);

            if ($email == '') {
                false;
            }else{
                if (checkEmailId($email)) {
                   false;
                } else {
                   insereEmail($email, $id_novo_cliente);
                };                
            };
            header("location: crud.php");
            exit;
        }
    };   

    function listaTipoLogradouros(){
        global $conection;
        $sql = "select * from tipo_logradouro order by id asc";
        $result = $conection->prepare($sql);
        $result->execute();
        return $result;
    };

    function listaTipoTelefones(){
        global $conection;
        $sql = "select * from tipo_telefone order by id asc;";
        $result = $conection->prepare($sql);
        $result->execute();
        return $result;
    };
    
    function insertCliente($fullname, $sex){
        global $conection;
        if ($sex == 'M') {
            $sex = 1;
        } else {
            $sex = 2;
        };        
        $sql = ("insert into cliente(nome, sexo) values(:fullname, :sex)");
        $insert = $conection->prepare($sql);
        $insert->bindParam(':fullname', $fullname);
        $insert->bindParam(':sex', $sex);
        $insert->execute();
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

    function getEstados(){
        global $conection;
        $sql = 'select * from estado order by id asc';
        $result = $conection->prepare($sql);
        $result->execute();
        return $result;
    };

    function getDetails($val){
        global $conection;
        $query = "select * from v_tudo where id = :cod";
        $result = $conection->prepare($query);
        $result->bindParam(':cod', $val);
        $result->execute();
        return $result;
    };

    function GetValue($value){
        global $conection, $cliente_id, $cod_endereco;
        
        if ($cliente_id != '') {
            $sql = "select * from v_tudo where id = :value";
            $result = $conection->prepare($sql);
            $result->bindParam(':value', $cliente_id);
        } else {            
            $sql = "select * from v_tudo where id_endereco = :value";
            $result = $conection->prepare($sql);
            $result->bindParam(':value', $cod_endereco);
        };

        $result->execute(); 
        $row = $result->fetch(PDO::FETCH_ASSOC)[$value];
        return $row;
    };

    function CheckBairro($valor){
        global $conection;
        $sql = "select id from bairro where nome = :valor";
        $checked_bairro = $conection->prepare($sql);
        $checked_bairro->bindParam(':valor', $valor);
        $checked_bairro->execute();
        $id = $checked_bairro->fetch(PDO::FETCH_ASSOC)['id'];

        if (is_numeric($id)) {
            return $id;
        } else{
              return false;
        };
    };

    function InsereBairro($valor){
        global $conection;
        $sql = "insert into bairro(nome) value(:nome)";
        $insert = $conection->prepare($sql);
        $insert->bindParam(':nome', $valor);
        $insert->execute();
    };

    function CheckCidade($valor){
        global $conection;
        $sql = "select id from cidade where nome = :valor";
        $checked_cidade = $conection->prepare($sql);
        $checked_cidade->bindParam(':valor', $valor);
        $checked_cidade->execute();
        $id = $checked_cidade->fetch(PDO::FETCH_ASSOC)['id'];

        if (is_numeric($id)) {
            return $id;
        } else{
            return false;
        };
    };

    function InsereCidade($valor){
        global $conection;
        $sql = "insert into cidade(nome) value(:nome)";
        $insertion = $conection->prepare($sql);
        $insertion->bindParam(':nome', $valor);
        $insertion->execute();
    };

    function checkEndereco($t, $n, $l, $co, $b, $ci, $e){
        global $conection;
        $sql = "select id from endereco where tipo_logradouro = :tipo and numero = :numero and nome_logradouro = :logradouro and complemento = :complemento and bairro = :bairro and cidade = :cidade and estado = :estado";
        $result = $conection->prepare($sql);
        $result->bindParam(':tipo', $t);
        $result->bindParam(':numero', $n);
        $result->bindParam(':logradouro', $l);
        $result->bindParam(':complemento', $co);
        $result->bindParam(':bairro', $b);
        $result->bindParam(':cidade', $ci);
        $result->bindParam(':estado', $e);
        $result->execute();
        $id = $result->fetch(PDO::FETCH_ASSOC)['id'];
        if ($id) {
            return $id;
        } else {
           return false;
        };
    };

    function insereEndereco($tipo_logradouro, $endereco, $numero, $complemento, $bairro, $cidade, $estado){
        Global $conection;
        if (CheckBairro($bairro)) {
            $id_bairro = CheckBairro($bairro);
        } else {
            InsereBairro($bairro);
            $id_bairro = CheckBairro($bairro);
        };
        
        if (CheckCidade($cidade)) {
            $id_cidade = CheckCidade($cidade);
        } else {
            InsereCidade($cidade);
            $id_cidade = CheckCidade($cidade);
        };

        $sql = "insert into endereco(tipo_logradouro, nome_logradouro, numero, complemento, bairro, cidade, estado) values(:tipo, :endereco, :numero, :complemento, :bairro, :cidade, :estado)";

        $insert = $conection->prepare($sql);
        $insert->bindParam(':tipo', $tipo_logradouro);
        $insert->bindParam(':endereco', $endereco);
        $insert->bindParam(':numero', $numero);
        $insert->bindParam(':complemento', $complemento);
        $insert->bindParam(':bairro', $id_bairro);
        $insert->bindParam(':cidade', $id_cidade);
        $insert->bindParam(':estado', $estado);
        $insert->execute();
    };

    function checkEmailId($val){
        global $conection;
        $sql = "select id from email where cliente_id = :val";
        $result = $conection->prepare($sql);
        $result->bindParam(':val', $val);
        $result->execute();
        $id = $result->fetch(PDO::FETCH_ASSOC)['id'];
        return $id;
    };

    function updateEmail($endereco, $id_cliente){
        global $conection;
        $sql = "update email set endereco = :endereco where cliente_id = :id";
        $result = $conection->prepare($sql);
        $result->bindParam(':endereco', $endereco);
        $result->bindParam(':id', $id_cliente);
        $result->execute();
        $endereco = $result->fetch(PDO::FETCH_ASSOC)['endereco'];
        return $endereco;
    };

    function insereEmail($endereco, $id){
        global $conection;
        $sql = "insert into email(endereco, cliente_id) values(:endereco, :id)";
        $result = $conection->prepare($sql);
        $result->bindParam(':endereco', $endereco);
        $result->bindParam(':id', $id);
        $result->execute();
    };
    
    function insereEnderecoCliente($id_c, $id_e){
        global $conection;
        $sql = "insert into endereco_cliente(id_cliente, id_endereco) values (:id_c, :id_e)";
        $insert = $conection->prepare($sql);
        $insert->bindParam(':id_c', $id_c);
        $insert->bindParam(':id_e', $id_e);
        $insert->execute();
    };

    function insereClieteTelefone($c, $t){
        global $conection;
        $sql = "insert into cliente_telefone(id_cliente, id_telefone) values(:c, :t)";
        $insert = $conection->prepare($sql);
        $insert->bindParam(':c', $c);
        $insert->bindParam(':t', $t);
        $insert->execute();
    };

    function updateClieteTelefone($idcliente, $tel_novo){
        global $conection;
        $sql = "update cliente_telefone set id_telefone = :tel_novo where id_cliente = :cliente";
        $update = $conection->prepare($sql);
        $update->bindParam(':cliente', $idcliente);
        $update->bindParam(':tel_novo', $tel_novo);
        $update->execute();
    };

    function insereTelefone($numero, $ddd, $tipo){
        global $conection;
        $sql = "insert into telefone(numero, ddd, tipo) value(:numero, :ddd, :tipo)";
        $insertion = $conection->prepare($sql);
        $insertion->bindParam(':numero', $numero);
        $insertion->bindParam(':ddd', $ddd);
        $insertion->bindParam(':tipo', $tipo);
        $insertion->execute();
    };

    function checkTelefone($ddd, $numero, $tipo){
        global $conection;
        $cheked_ddd = checkDDD($ddd);
        if ($cheked_ddd) {
            $sql = "select * from telefone where ddd = :ddd and numero = :numero and tipo = :tipo";
            $checked = $conection->prepare($sql);
            $checked->bindParam(':numero', $numero);
            $checked->bindParam(':ddd', $cheked_ddd);
            $checked->bindParam(':tipo', $tipo);
            $checked->execute();
            $id = $checked->fetch(PDO::FETCH_ASSOC)['id'];
            if ($id) {
                return $id;
            } else {
                return false;
            };            
        } else {
            return false;
        };
    };

    function insereDDD($val){
        global $conection;
        $sql = "insert into ddd(numero) values(:ddd)";
        $insertion = $conection->prepare($sql);
        $insertion->bindParam(':ddd', $val);
        $insertion->execute();
    };

    function checkDDD($val){
        global $conection;
        $sql = "select id from ddd where numero = :ddd";
        $checked_ddd = $conection->prepare($sql);
        $checked_ddd->bindParam(':ddd', $val);
        $checked_ddd->execute();
        $result = $checked_ddd->fetch(PDO::FETCH_ASSOC)['id'];
        if ($result) {
            return $result;
        } else {
            return false;
        };        
    };

    function updateEnderecoCliente($cli, $end_novo, $end_antigo){
        global $conection;
        $sql = "update endereco_cliente set id_endereco = :end_novo where id_cliente = :cli and id_endereco = :end_antigo";
        $insert = $conection->prepare($sql);
        $insert->bindParam(':cli', $cli);
        $insert->bindParam(':end_novo', $end_novo);
        $insert->bindParam(':end_antigo', $end_antigo);
        $insert->execute();
    };

    function excludeCliente($id){
        global $conection;
        $sql = "delete from cliente where id = :id";
        $delete = $conection->prepare($sql);
        $delete->bindParam(':id', $id);
        $delete->execute();
    };

    function excludeEnderecoCliente($id){
        global $conection;
        $sql = "delete from endereco_cliente where id_cliente = :id";
        $delete = $conection->prepare($sql);
        $delete->bindParam(':id', $id);
        $delete->execute();
    };

    function excludeEmail($id){
        global $conection;
        $sql = "delete from email where cliente_id = :id";
        $delete = $conection->prepare($sql);
        $delete->bindParam(':id', $id);
        $delete->execute();
    };

    function excludeClienteTelefone($id){
        global $conection;
        $sql = "delete from cliente_telefone where id_cliente = :id";
        $delete = $conection->prepare($sql);
        $delete->bindParam(':id', $id);
        $delete->execute();
    };
?>