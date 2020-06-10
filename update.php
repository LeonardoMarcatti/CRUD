<?php
    namespace update;
    setlocale(LC_ALL, "pt_BR.utf-8");
    session_start();
    if (!isset($_GET['codendereco'])) {
        header('location: login.php');
        exit;
    };
    include('functions.php');

    $cod_endereco = $_GET['codendereco'];
    $update_idcliente = $_GET['u_idcliente'];
    $update_id_ddd = $_GET['u_id_ddd'];
    $update_id_telefone = $_GET['u_id_telefone'];
    $update_id_email = $_GET['u_id_email'];
    $update_tt = $_GET['u_tt'];

    $meu_estado = "select id_estado, estado from v_tudo where id_endereco = $cod_endereco";
    $id_meu_estado = ($conection->query($meu_estado))->fetch()['id_estado'];
    $nome_meu_estado = ($conection->query($meu_estado))->fetch()['estado'];

    $sql_estados = "select id, nome from estado order by id asc";
    $lista_estados = $conection->query($sql_estados);

    $meu_logradouro = "select id_logradouro from v_tudo where id_endereco = $cod_endereco";
    $id_meu_logradouro = ($conection->query($meu_logradouro))->fetch()['id_logradouro'];

    $sql_logradouro = "select id, nome from tipo_logradouro order by id asc";
    $lista_logradouros = $conection->query($sql_logradouro);

    $sql_tipos_telefone = "select * from tipo_telefone order by id asc";
    $lista_tipos_telefone = $conection->query($sql_tipos_telefone);
    $id_meu_tipo = $conection->query("select * from tipo_telefone where id = $update_tt")->fetch()['id'];


    if (isset($_POST['u_logradouro'], $_POST['u_endereco'], $_POST['u_numero'], $_POST['u_bairro'], $_POST['u_cidade'], $_POST['u_estado'], $_POST['u_ddd'], $_POST['u_telefone'], $_POST['u_tipo_telefone'], $_POST['u_email'])){
        $logradouro_novo = $_POST['u_logradouro'];
        $endereco_novo = $_POST['u_endereco'];
        $numero_novo = $_POST['u_numero'];
        $complemento_novo = $_POST['u_complemento'];
        $bairro_novo = $_POST['u_bairro'];
        $cidade_novo = $_POST['u_cidade'];
        $estado_novo = $_POST['u_estado'];
        $ddd_novo = $_POST['u_ddd'];
        $telefone_novo = $_POST['u_telefone'];
        $tipo_novo = $_POST['u_tipo_telefone'];
        $email_novo = $_POST['u_email'];

        UpdateEndereco();
        UpdateEmail();
        UpdateTelefone();
    };

    function UpdateTelefone(){
        global $conection, $update_idcliente, $telefone_novo, $tipo_novo, $update_id_telefone;
        $checked_tel = CheckTelefone();
        if (CheckTelefone()) {
            $sql = "update cliente_telefone set id_telefone = $checked_tel where id_cliente = $update_idcliente and id_telefone = $update_id_telefone";
            $conection->exec($sql);
        } else {
            if (Checkddd()) {
                $checkedddd = Checkddd();
                InsereTelefone($telefone_novo, $checkedddd, $tipo_novo);
                $id_novo_tel = CheckTelefone();
                $sql = "update cliente_telefone set id_telefone = '$id_novo_tel' where id_cliente = $update_idcliente and id_telefone = $update_id_telefone";
                $conection->exec($sql);
            } else{
                Insereddd();
                $checkedddd = Checkddd();
                InsereTelefone($telefone_novo, $checkedddd, $tipo_novo);
                $id_novo_tel = CheckTelefone();
                $sql = "update cliente_telefone set id_telefone = '$id_novo_tel' where id_cliente = $update_idcliente and id_telefone = $update_id_telefone";
                $conection->exec($sql);
            };
        };        
    };

    function UpdateEmail(){
        global $conection, $email_novo, $update_idcliente;
        $check_email = "select endereco from email where cliente_id = $update_idcliente";
        $result = ($conection->query($check_email))->fetch()['endereco'];
        if($result!= $email_novo){
            $update_email = "update email set endereco = '$email_novo' where cliente_id = $update_idcliente";
            $conection->exec($update_email);
        };
    };


    function CheckEndereco(){
        global $conection, $logradouro_novo, $endereco_novo, $numero_novo, $complemento_novo, $bairro_novo, $cidade_novo, $estado_novo;
        $sql = "select e.id, t.id as 'tipo_logradouro', e.nome_logradouro, e.numero, e.complemento, b.nome, es.id as 'id_estado', c.nome, es.nome from endereco e join tipo_logradouro t on e.tipo_logradouro = t.id join bairro b on e.bairro = b.id join cidade c on e.cidade = c.id join estado es on e.estado = es.id";
        if (empty($complemento_novo)) {
            $sql .= " where t.id = $logradouro_novo and e.nome_logradouro = '$endereco_novo' and e.numero = $numero_novo and e.complemento is null and b.nome = '$bairro_novo' and c.nome = '$cidade_novo' and es.id = '$estado_novo'";
        } else {
            $sql .= " where t.id = $logradouro_novo and e.nome_logradouro = '$endereco_novo' and e.complemento = '$complemento_novo' and e.numero = $numero_novo and b.nome = '$bairro_novo' and c.nome = '$cidade_novo' and es.id = '$estado_novo'";
        };
        $id_endereco = $conection->query($sql)->fetch()['id'];
        return $id_endereco;
    };
    

    function UpdateEndereco(){
        global $conection, $cod_endereco, $logradouro_novo, $endereco_novo, $numero_novo, $complemento_novo, $bairro_novo, $cidade_novo, $estado_novo, $cod_endereco, $update_idcliente;

        if (CheckEndereco()) {
            $update_sql = "update endereco_cliente set id_endereco = " .  CheckEndereco(). " where id_cliente = $update_idcliente and id_endereco = $cod_endereco";
            $conection->exec($update_sql);

        } else {
            if ($complemento_novo && CheckBairro($bairro_novo) && CheckCidade($cidade_novo)) {
                $b = CheckBairro($bairro_novo);
                $c = CheckCidade($cidade_novo);
                $conection->query("insert into endereco(nome_logradouro, complemento, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco_novo', '$complemento_novo', '$b', '$logradouro_novo', '$c', '$estado_novo', $numero_novo)");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("update endereco_cliente set id_endereco = $id_novo_endereco where id_cliente = $update_idcliente and id_endereco = $cod_endereco");

            }elseif (!$complemento_novo && !CheckBairro($bairro_novo) && !CheckCidade($cidade_novo)) {
                InsereBairro($bairro_novo);
                InsereCidade($cidade_novo);
                $b = CheckBairro($bairro_novo);
                $c = CheckCidade($cidade_novo);
                $conection->query("insert into endereco(nome_logradouro, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco_novo', '$b', '$logradouro_novo', '$c', '$estado_novo', $numero_novo)");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("update endereco_cliente set id_endereco = $id_novo_endereco where id_cliente = $update_idcliente and id_endereco = $cod_endereco");

            }elseif ($complemento_novo && !CheckBairro($bairro_novo) && !CheckCidade($cidade_novo)) {
                InsereBairro($bairro_novo);
                InsereCidade($cidade_novo);
                $b = CheckBairro($bairro_novo);
                $c = CheckCidade($cidade_novo);
                $conection->query("insert into endereco(nome_logradouro, complemento, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco_novo', '$complemento_novo', '$b', '$logradouro_novo', '$c', '$estado_novo', $numero_novo)");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("update endereco_cliente set id_endereco = $id_novo_endereco where id_cliente = $update_idcliente and id_endereco = $cod_endereco");

            } elseif ($complemento_novo && CheckBairro($bairro_novo) && !CheckCidade($cidade_novo)) {
                InsereCidade($cidade_novo);
                $b = CheckBairro($bairro_novo);
                $c = CheckCidade($cidade_novo);
                $conection->query("insert into endereco(nome_logradouro, complemento, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco_novo', '$complemento_novo', '$b', '$logradouro_novo', '$c', '$estado_novo', $numero_novo)");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("update endereco_cliente set id_endereco = $id_novo_endereco where id_cliente = $update_idcliente and id_endereco = $cod_endereco");

            } elseif ($complemento_novo && !CheckBairro($bairro_novo) && CheckCidade($cidade_novo)) {
                InsereBairro($bairro_novo);
                $b = CheckBairro($bairro_novo);
                $c = CheckCidade($cidade_novo);
                $conection->query("insert into endereco(nome_logradouro, complemento, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco_novo', '$complemento_novo', '$b', '$logradouro_novo', '$c', '$estado_novo', $numero_novo)");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("update endereco_cliente set id_endereco = $id_novo_endereco where id_cliente = $update_idcliente and id_endereco = $cod_endereco");

            } elseif (!$complemento_novo && CheckBairro($bairro_novo) && !CheckCidade($cidade_novo)) {
                InsereCidade($cidade_novo);
                $b = CheckBairro($bairro_novo);
                $c = CheckCidade($cidade_novo);
                $conection->query("insert into endereco(nome_logradouro, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco_novo', '$b', '$logradouro_novo', '$c', '$estado_novo', $numero_novo)");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("update endereco_cliente set id_endereco = $id_novo_endereco where id_cliente = $update_idcliente and id_endereco = $cod_endereco");

            } elseif (!$complemento_novo && !CheckBairro($bairro_novo) && CheckCidade($cidade_novo)) {
                InsereBairro($bairro_novo);
                $b = CheckBairro($bairro_novo);
                $c = CheckCidade($cidade_novo);
                $conection->query("insert into endereco(nome_logradouro, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco_novo', '$b', '$logradouro_novo', '$c', '$estado_novo', $numero_novo)");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("update endereco_cliente set id_endereco = $id_novo_endereco where id_cliente = $update_idcliente and id_endereco = $cod_endereco");

            }elseif (!$complemento_novo && CheckBairro($bairro_novo) && CheckCidade($cidade_novo)) {
                $b = CheckBairro($bairro_novo);
                $c = CheckCidade($cidade_novo);
                $conection->query("insert into endereco(nome_logradouro, bairro, tipo_logradouro, cidade, estado, numero) values('$endereco_novo', '$b', '$logradouro_novo', '$c', '$estado_novo', $numero_novo)");
                $id_novo_endereco = $conection->query("select max(id) as 'id' from endereco")->fetch()['id'];
                $conection->query("update endereco_cliente set id_endereco = $id_novo_endereco where id_cliente = $update_idcliente and id_endereco = $cod_endereco");

            };
        };
        header('location: details.php?cod=' . $update_idcliente);
    };

?>
<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="crud.css">
        <title>CRUD - Alteração</title>    
    </head>
    <body>
        <?php
            echo "<div id=\"barra\" class=\"col- container-fluid\"><a href=\"crud.php\" id=\"volta_crud\" b4>Voltar</a><a href=\"logout.php\" id=\"sair\">Sair</a></div> <div class=\"container-fluid\" id=\"update\">
                    <form action=\"\" method=\"post\">
                    <fieldset id=\"endereco_completo\">
                        <div class=\"form-row form-group\">
                            <legend>Endereço</legend>
                            <div class=\"col-lg-1 col-12\">
                                <label for=\"logradouro:\">Logradouro:</label>
                                <select class=\"custom-select\" id=\"logradouro\" name=\"u_logradouro\" required=\"\">";
                                global $lista_logradouros;
                                    foreach ($lista_logradouros as $key => $value) {
                                        global $id_meu_logradouro;
                                        if ($id_meu_logradouro == $value['id'] ) {
                                            echo "<option value=\"$value[id]\" selected=\"\">$value[nome]</option>";
                                        } else {
                                            echo "<option value=\"$value[id]\">$value[nome]</option>";
                                        };
                                    };
                                echo "</select>
                            </div>
                            <div class=\"col-lg-6 col-12\">
                                <label for=\"endereco:\">Nome:</label>
                                <input type=\"text\" name=\"u_endereco\" id=\"endereco\" value=\""; echo GetValue('logradouro'); echo "\" class=\"form-control\" required=\"\">
                            </div>
                            <div class=\"col-lg-1 col-12\">
                                <label for=\"numero:\">Número:</label>
                                <input type=\"number\" name=\"u_numero\" min=\"0\" id=\"numero\"value=\""; echo GetValue('numero'); echo "\" class=\"form-control\" required=\"\">
                            </div>
                            <div class=\"col-lg-4 col-12\">
                                <label for=\"complemento:\">Complemento:</label>
                                <input type=\"text\" name=\"u_complemento\" id=\"complemento\" value=\""; echo GetValue('complemento'); echo "\" class=\"form-control\">
                            </div>
                        </div>
                        <div class=\"form-row form-group\">
                            <div class=\"col-lg-5 col-12\">
                                <label for=\"bairro:\">Bairro:</label>
                                <input type=\"text\" name=\"u_bairro\" id=\"bairro\" value=\""; echo GetValue('bairro'); echo "\" class=\"form-control\" required=\"\">
                            </div>
                            <div class=\"col-lg-5 col-12\">
                                <label for=\"cidade:\">Cidade:</label>
                                <input type=\"text\" name=\"u_cidade\" id=\"cidade\" value=\""; echo GetValue('cidade'); echo"\" class=\"form-control\" required=\"\">
                            </div>
                            <div class=\"col-lg-2 col-12\">
                                <label for=\"estado:\">Estado:</label>
                                <select class=\"custom-select\" id=\"estado\" name=\"u_estado\" required=\"\">";
                                global $lista_estados, $id_meu_estado;
                                foreach ($lista_estados as $key => $value) {
                                    if ($value['id'] == $id_meu_estado) {
                                        echo "<option value=\"$value[id]\" selected=\"\">$value[nome]</option>";
                                    } else {
                                        echo "<option value=\"$value[id]\">$value[nome]</option>";
                                    };
                                };
                                echo "</select>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset id=\"contato\">
                        <div class=\"form-row form-group\">
                            <legend>Contato</legend>
                            <div class=\"col-lg-1 col-12\">
                                <label for=\"ddd:\">DDD:</label>
                                <input type=\"number\" name=\"u_ddd\" id=\"ddd\" value=\""; echo GetValue('ddd'); echo"\" class=\"form-control\" pattern=\"[0-9]{2}\" required=\"\">
                                <small>Formato: XX</small>
                            </div>
                        <div class=\"col-lg-3 col-12\">
                            <label for=\"telefone:\">Telefone:</label>
                            <input type=\"tel\" name=\"u_telefone\" id=\"telefone\" value=\""; echo GetValue('telefone'); echo"\" class=\"form-control\" pattern=\"[0-9]{4}-[0-9]{4}\" required=\"\">
                            <small>Formato: XXXX-XXXX</small>
                        </div>
                        <div class=\"col-lg-2 col-12\">
                            <label for=\"tipo_telefone:\">Tipo:</label>
                            <select class=\"custom-select\" id=\"tipo_telefone\" name=\"u_tipo_telefone\" required=\"\">";
                            global $lista_tipos_telefone, $id_meu_tipo;
                            foreach ($lista_tipos_telefone as $key => $value) {
                                if ($value['id'] == $id_meu_tipo) {
                                    echo "<option value=\"$value[id]\" selected=\"\">$value[tipo]</option>";
                                } else {
                                    echo "<option value=\"$value[id]\">$value[tipo]</option>";
                                };
                            };
                            echo "
                            </select>
                        </div>
                            <div class=\"col-lg-6 col-12\">
                                <label for=\"email\">E-mail:</label>
                                <input type=\"email\" name=\"u_email\" id=\"email\"value=\""; echo GetValue('email'); echo"\"  class=\"form-control\" required=\"\">
                            </div>
                        </div>
                    </fieldset>
                    <div class=\"form-row form-group\">
                        <div class=\"col-lg-2 col-4\">
                            <button type=\"submit\" id=\"submit_clientes\" class=\"btn btn-block btn-success\">Alterar</button>
                        </div>
                    </div>
                </form>
            </div>";
        ?>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript"></script>
    </body>
</html>