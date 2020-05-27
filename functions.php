<?php
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    };

    $server = 'localhost';
    $db = 'CRUD';
    $user = 'root';
    $password = '';
    try {
        $conection = new PDO("mysql:host=$server; dbname=$db", "$user", "$password");
    } catch (Throwable $th) {
        echo 'Erro linha: ' . $th->getLine() . "<br>";
        echo ('Código: ' . $th->getMessage());
    };

    function GetUserImage(){
        global $conection;
        $current_user = $_SESSION['user'];
        $sql = "select u.id, nome, caminho, iduser from users u join image i on u.id = i.iduser where u.nome_de_usuario = '$current_user'";
        $path = $conection->query($sql)->fetch()['caminho'];
        return $path;
    };


    function GetUserImageTitle(){
        global $conection;
        $current_user = $_SESSION['user'];
        $sql = "select u.id, nome, caminho, iduser from users u join image i on u.id = i.iduser where u.nome_de_usuario = '$current_user'";
        $alt = $conection->query($sql)->fetch()['nome'];
        return $alt;
    };

    function GetValue($value){
        global $conection, $cliente_id, $idcliente, $cod_endereco;
        if (isset($cliente_id)) {
            $sql = "select * from v_tudo where id = $cliente_id";
        } elseif(isset($update_idcliente)) {
            $sql = "select * from v_tudo where id = $idcliente";
        } elseif(isset($cod_endereco)){
            $sql = "select * from v_tudo where id_endereco = $cod_endereco";
        }
       
        $result = $conection->query($sql);
        $row = $result->fetch()[$value];
        return $row;
    };

    function CheckBairro($valor){
        global $conection;
        $checked_bairro = $conection->query("select id from bairro where nome = '$valor'")->fetch()['id'];
        if (!$checked_bairro) {
            return false;
        } else{
            return $checked_bairro; 
        };
    };    

    function InsereBairro($valor){
        global $conection;
        $conection->query("insert into bairro(nome) value('$valor')");
    };

    function CheckCidade($valor){
        global $conection;
        $checked_cidade = $conection->query("select id from cidade where nome = '$valor'")->fetch()['id'];
        if (!$checked_cidade) {
            return false;
        } else{
            return $checked_cidade;
        };
    };

    function InsereCidade($valor){
        global $conection;
        $conection->query("insert into cidade(nome) value('$valor')");
    };

    function InsereTelefone($numero, $ddd, $tipo){
        global $conection;
        $sql = "insert into telefone(numero, ddd, tipo) value('$numero', $ddd, $tipo)";
        $conection->query($sql);
    };

    function CheckTelefone(){
        global $conection, $telefone_novo, $tipo_novo;
        $id_ddd_atual = Checkddd();
        if ($id_ddd_atual) {
            $sql = "select * from telefone where numero = '$telefone_novo' and ddd = $id_ddd_atual and tipo = $tipo_novo";
            $result = ($conection->query($sql))->fetch()['id'];
            if ($result) {
                return $result;
            } else {
                return false;
            };     
        } else {
           return false;
        };
    };

    function Insereddd(){
        global $conection, $ddd_novo;
        $sql = "insert into ddd(numero) values($ddd_novo)";
        $conection->exec($sql);
    };

    function Checkddd(){
        global $conection, $ddd_novo;
        $sql = "select id from ddd where numero = $ddd_novo";
        $result = ($conection->query($sql))->fetch()['id'];
        if ($result) {
            return $result;
        } else {
            return false;
        };
    };

    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $sql1 = "delete from endereco_cliente where id_cliente  = $id";
        $sql2 = "delete from cliente_telefone where id_cliente  = $id";
        $sql3 = "delete from email where cliente_id = $id";
        $sql4 = "delete from cliente where id = $id";

        $r1 = $conection->query($sql1);
        $r2 = $conection->query($sql2);
        $r3 = $conection->query($sql3);
        $r4 = $conection->query($sql4);

        if ($r1 && $r2 &&$r3 && $r4) {
            header('location: crud.php');
        };       
    };

    if (isset($_POST['logradouro'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'])){
        $logradouro = $_POST['logradouro'];
        $endereco = $_POST['endereco'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];

        if (isset($_POST['nome'], $_POST['sobre_nome'], $_POST['sex'], $_POST['ddd'], $_POST['telefone'], $_POST['tipo_telefone'], $_POST['email'] )) {
            $nome = $_POST['nome'] . ' ' . $_POST['sobre_nome'];
            $sex = $_POST['sex'];
            $ddd = $_POST['ddd'];
            $telefone = $_POST['telefone'];
            $tipo = $_POST['tipo_telefone'];
            $email = $_POST['email'];


            $sex_id =  $conection->query("select id from sexo where genero = '$sex'")->fetch()['id'];
            $conection->query("insert into cliente(nome, sexo) values('$nome', $sex_id)");
            $id_novo_cliente = $conection->query("select max(id) as 'id' from cliente")->fetch()['id'];
            $conection->query("insert into email(endereco, cliente_id) values('$email', $id_novo_cliente)");
            $check_ddd = $conection->query("select * from ddd where numero = $ddd")->fetch(PDO::FETCH_ASSOC)['id'];
            $check_telefone = $conection->query("select * from telefone where numero = '$telefone'")->fetch()['numero'];

            if ($check_ddd && $check_telefone) {
                $telefone_ddd = $conection->query("select t.id, t.numero, d.numero from telefone t join ddd d on t.ddd = d.id where t.numero = '$check_telefone' and d.id = $check_ddd")->fetch()['id'];
                if ($telefone_ddd) {
                    $conection->exec("insert into cliente_telefone(id_cliente, id_telefone) values($id_novo_cliente, $telefone_ddd)");
                }else{
                    $conection->exec("insert into telefone(numero, ddd, tipo) values('$check_telefone', $check_ddd , $tipo)");
                    $id_novo_telefone_ddd = $conection->query("select max(id) as 'id' from telefone")->fetch()['id'];
                    $conection->exec("insert into cliente_telefone(id_cliente, id_telefone) values($id_novo_cliente, $id_novo_telefone_ddd)");
                };
            } elseif (!$check_ddd && !$check_telefone) {
                $conection->query("insert into ddd(numero) values($ddd)");
                $id_novo_ddd = $conection->query("select max(id) as 'id' from ddd")->fetch()['id'];
                $conection->query("insert into telefone(numero, ddd, tipo) values('$telefone', $id_novo_ddd, $tipo)");
                $id_novo_telefone = $conection->query("select max(id) as 'id' from telefone")->fetch()['id'];
                $conection->query("insert into cliente_telefone(id_cliente, id_telefone) values($id_novo_cliente, $id_novo_telefone)");
            } elseif ($check_ddd && !$check_telefone) {
                $id_ddd_existente = $check_ddd;
                $conection->query("insert into telefone(numero, ddd, tipo) values('$telefone', $id_ddd_existente, $tipo)");
                $id_novo_telefone = $conection->query("select max(id) as 'id' from telefone")->fetch()['id'];
                $conection->exec("insert into cliente_telefone(id_cliente, id_telefone) values($id_novo_cliente, $id_novo_telefone)");
            } else{
                $conection->query("insert into ddd(numero) values($ddd)");
                $id_novo_ddd = $conection->query("select id from ddd where numero = $ddd")->fetch()['id'];
                $conection->query("insert into telefone(numero, ddd, tipo) values('$check_telefone', $id_novo_ddd, $tipo)");
                $id_novo_telefone = $conection->query("select max(id) as 'id' from telefone")->fetch()['id'];
                $conection->query("insert into cliente_telefone(id_cliente, id_telefone) values($id_novo_cliente, $id_novo_telefone)");
            };
        };
        for ($i=0; $i < count($complemento); $i++) {
            EnderecoCliente();
        };
    };

    function CheckEndereco(){
        global $conection, $i, $logradouro, $endereco, $numero, $complemento, $bairro, $cidade, $estado;
        
        if (empty($complemento[$i])) {
            $endereco_completo = "select e.id from endereco e join bairro b on e.bairro = b.id join cidade c on e.cidade = c.id join estado es on e.estado = es.id where e.tipo_logradouro = '$logradouro[$i]' and e.nome_logradouro = '$endereco[$i]' and e.numero = $numero[$i] and e.complemento is null and b.nome = '$bairro[$i]' and c.nome = '$cidade[$i]' and es.id = '$estado[$i]'";
        }
        else{
            $endereco_completo = "select e.id from endereco e join bairro b on e.bairro = b.id join cidade c on e.cidade = c.id join estado es on e.estado = es.id where e.tipo_logradouro = '$logradouro[$i]' and e.nome_logradouro = '$endereco[$i]' and e.numero = $numero[$i] and e.complemento = '$complemento[$i]' and b.nome = '$bairro[$i]' and c.nome = '$cidade[$i]' and es.id = '$estado[$i]'";
        };

        $id_resultado = $conection->query($endereco_completo)->fetch()['id'];
        return $id_resultado;
    };

    function EnderecoCliente(){
        global $conection, $id_novo_cliente, $idcliente;
        $checked_address = CheckEndereco();
        if (CheckEndereco()) {
            if (!empty($idcliente)) {
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($idcliente, $checked_address)");
            } else {
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($id_novo_cliente, $checked_address)");
            };
        } else{
            if (!empty($idcliente)) {
                InsereEndereco($idcliente);
            } else {
                InsereEndereco($id_novo_cliente);
            };
        };
    };

    function InsereEndereco($valor){
        global $conection, $endereco, $logradouro, $numero, $estado, $complemento, $bairro, $cidade, $i;
            if ($complemento[$i] && CheckBairro($bairro[$i]) && CheckCidade($cidade[$i])) {
                $b = CheckBairro($bairro[$i]);
                $c = CheckCidade($cidade[$i]);
                $conection->query("insert into endereco(nome_logradouro, complemento, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco[$i]', '$complemento[$i]', '$b', '$logradouro[$i]', '$c', '$estado[$i]', $numero[$i])");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($valor, $id_novo_endereco)");
            } elseif (!$complemento[$i] && !CheckBairro($bairro[$i]) && !CheckCidade($cidade[$i])) {
                InsereBairro($bairro[$i]);
                InsereCidade($cidade[$i]);
                $b = CheckBairro($bairro[$i]);
                $c = CheckCidade($cidade[$i]);
                $conection->query("insert into endereco(nome_logradouro, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco[$i]', '$b', '$logradouro[$i]', '$c', '$estado[$i]', $numero[$i])");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($valor, $id_novo_endereco)");

            } elseif ($complemento[$i] && !CheckBairro($bairro[$i]) && !CheckCidade($cidade[$i])) {
                InsereBairro($bairro[$i]);
                InsereCidade($cidade[$i]);
                $b = CheckBairro($bairro[$i]);
                $c = CheckCidade($cidade[$i]);
                $conection->query("insert into endereco(nome_logradouro, complemento, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco[$i]', '$complemento[$i]', '$b', '$logradouro[$i]', '$c', '$estado[$i]', $numero[$i])");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($valor, $id_novo_endereco)");
            } elseif ($complemento[$i] && CheckBairro($bairro[$i]) && !CheckCidade($cidade[$i])) {
                InsereCidade($cidade[$i]);
                $b = CheckBairro($bairro[$i]);
                $c = CheckCidade($cidade[$i]);
                $conection->query("insert into endereco(nome_logradouro, complemento, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco[$i]', '$complemento[$i]', '$b', '$logradouro[$i]', '$c', '$estado[$i]', $numero[$i])");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($valor, $id_novo_endereco)");
            } elseif ($complemento[$i] && !CheckBairro($bairro[$i]) && CheckCidade($cidade[$i])) {
                InsereBairro($bairro[$i]);
                $b = CheckBairro($bairro[$i]);
                $c = CheckCidade($cidade[$i]);
                $conection->query("insert into endereco(nome_logradouro, complemento, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco[$i]', '$complemento[$i]', '$b', '$logradouro[$i]', '$c', '$estado[$i]', $numero[$i])");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($valor, $id_novo_endereco)");
            } elseif (!$complemento[$i] && CheckBairro($bairro[$i]) && !CheckCidade($cidade[$i])) {
                InsereCidade($cidade[$i]);
                $b = CheckBairro($bairro[$i]);
                $c = CheckCidade($cidade[$i]);
                $conection->query("insert into endereco(nome_logradouro, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco[$i]', '$b', '$logradouro[$i]', '$c', '$estado[$i]', $numero[$i])");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($valor, $id_novo_endereco)");
            } elseif (!$complemento[$i] && !CheckBairro($bairro[$i]) && CheckCidade($cidade[$i])) {
                InsereBairro($bairro[$i]);
                $b = CheckBairro($bairro[$i]);
                $c = CheckCidade($cidade[$i]);
                $conection->query("insert into endereco(nome_logradouro, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco[$i]', '$b', '$logradouro[$i]', '$c', '$estado[$i]', $numero[$i])");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($valor, $id_novo_endereco)");
            }elseif (!$complemento[$i] && CheckBairro($bairro[$i]) && CheckCidade($cidade[$i])) {
                $b = CheckBairro($bairro[$i]);
                $c = CheckCidade($cidade[$i]);
                $conection->query("insert into endereco(nome_logradouro, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco[$i]', '$b', '$logradouro[$i]', '$c', '$estado[$i]', $numero[$i])");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("insert into endereco_cliente(id_cliente, id_endereco) values($valor, $id_novo_endereco)");
            }

            UnsetFileds();
    };
 
    function UnsetFileds(){
        global $endereco, $complemento, $bairro, $cidade, $logradouro, $numero, $estado, $id_novo_cliente, $id_resultado, $i, $cliente_id;
        unset($endereco, $complemento, $bairro, $cidade, $logradouro, $numero, $estado, $id_novo_cliente, $id_resultado, $i, $cliente_id);
    };            
?>