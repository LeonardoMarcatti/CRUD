<?php
    setlocale(LC_ALL, "pt_BR.utf-8");
    session_start();

    if (!isset($_GET['idendereco'])) {
        header('location: login.php');
        exit;
    };
    
    include_once 'functions.php';
    include_once 'classes/telefone.php';
    
    use CRUD\classes\TipoTelefoneDAO;
    use CRUD\classes\TipoLogradouroDAO;
    use CRUD\classes\EstadoDAO;
    use CRUD\classes\ClienteTelefoneDAO;

    $tipos_telefone = new TipoTelefoneDAO($conection);
    $lista_tipos = $tipos_telefone->getAll();

    $tipo_log = new TipoLogradouroDAO($conection);
    $lista_log = $tipo_log->getAll();

    $estados = new EstadoDAO($conection);
    $lista_estados = $estados->getAll();

    $cliente_telefone_dao = new ClienteTelefoneDAO($conection);
?>

<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="crud.css">
        <title>CRUD - Alteração</title>    
    </head>
    <body>
        <?php
            echo "<div id=\"barra\" class=\"col- container-fluid\"><a href=\"crud.php\" id=\"volta_crud\" b4>Voltar</a><a href=\"logout.php\" id=\"sair\">Sair</a></div> <div class=\"container-fluid\" id=\"update\">
                    <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">
                    <fieldset id=\"endereco_completo\">
                        <div class=\"form-row form-group\">
                            <legend>Endereço</legend>
                            <div class=\"col-lg-1 col-12\">
                                <label for=\"logradouro:\">Logradouro:</label>
                                <select class=\"custom-select\" id=\"logradouro\" name=\"logradouro\" required=\"\">";
                                $id_meu_logradouro = GetValue('id_logradouro');
                                    foreach ($lista_log as $key => $value){
                                        if ($id_meu_logradouro == $value->getID()) {
                                            echo "<option value=\"" . $value->getID() . "\" selected=\"\">" . $value->getNome() . "</option>";
                                        } else {
                                            echo "<option value=\"" . $value->getID() . "\">" . $value->getNome() . "</option>";
                                        };
                                    };
                                echo "</select>
                            </div>
                            <div class=\"col-lg-6 col-12\">
                                <label for=\"endereco:\">Nome:</label>
                                <input type=\"text\" name=\"endereco\" id=\"endereco\" value=\""; echo GetValue('logradouro'); echo "\" class=\"form-control\" required=\"\">
                            </div>
                            <div class=\"col-lg-1 col-12\">
                                <label for=\"numero:\">Número:</label>
                                <input type=\"number\" name=\"numero\" min=\"0\" id=\"numero\"value=\""; echo GetValue('numero'); echo "\" class=\"form-control\" required=\"\">
                            </div>
                            <div class=\"col-lg-4 col-12\">
                                <label for=\"complemento:\">Complemento:</label>
                                <input type=\"text\" name=\"complemento\" id=\"complemento\" value=\""; echo GetValue('complemento'); echo "\" class=\"form-control\">
                            </div>
                        </div>
                        <div class=\"form-row form-group\">
                            <div class=\"col-lg-5 col-12\">
                                <label for=\"bairro:\">Bairro:</label>
                                <input type=\"text\" name=\"bairro\" id=\"bairro\" value=\""; echo GetValue('bairro'); echo "\" class=\"form-control\" required=\"\">
                            </div>
                            <div class=\"col-lg-5 col-12\">
                                <label for=\"cidade:\">Cidade:</label>
                                <input type=\"text\" name=\"cidade\" id=\"cidade\" value=\""; echo GetValue('cidade'); echo"\" class=\"form-control\" required=\"\">
                            </div>
                            <div class=\"col-lg-2 col-12\">
                                <label for=\"estado:\">Estado:</label>
                                <select class=\"custom-select\" id=\"estado\" name=\"estado\" required=\"\">";
                                foreach ($lista_estados as $key => $value) {
                                    $estado_selecionado = GetValue('estado');
                                    if ($value->getNome() == $estado_selecionado) {
                                        echo "<option value=\"" . $value->getID() . "\" selected=\"\">" . $value->getNome() . "</option>";
                                    } else {
                                        echo "<option value=\"" . $value->getID() . "\">" . $value->getNome() . "</option>";
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
                                <input type=\"number\" name=\"ddd\" id=\"ddd\" value=\""; echo GetValue('ddd'); echo"\" class=\"form-control\" pattern=\"[0-9]{2}\" required=\"\">
                                <small>Formato: XX</small>
                            </div>
                        <div class=\"col-lg-3 col-12\">
                            <label for=\"telefone:\">Telefone:</label>
                            <input type=\"tel\" name=\"telefone\" id=\"telefone\" value=\""; echo GetValue('telefone'); echo"\" class=\"form-control\" pattern=\"[0-9]{4}-[0-9]{4}\" required=\"\">
                            <small>Formato: XXXX-XXXX</small>
                        </div>
                        <div class=\"col-lg-2 col-12\">
                            <label for=\"tipo_telefone:\">Tipo:</label>
                            <select class=\"custom-select\" id=\"tipo_telefone\" name=\"tipo_telefone\" required=\"\">";
                            $tipo_telefone = GetValue('tipo_telefone');
                            foreach ($lista_tipos as $key => $value) {
                                if ($value['id'] == $tipo_telefone) {
                                    echo "<option value=\"" . $value['id'] . "\" selected=\"\">" . $value['tipo'] . "</option>";
                                } else {
                                    echo "<option value=\"" . $value['id'] . "\">" . $value['tipo'] . "</option>";
                                };
                            };
                            echo "
                            </select>
                        </div>
                            <div class=\"col-lg-6 col-12\">
                                <label for=\"email\">E-mail:</label>
                                <input type=\"email\" name=\"email\" id=\"email\"value=\""; echo GetValue('email'); echo"\"  class=\"form-control\">
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
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script type="text/javascript"></script>
    </body>
</html>