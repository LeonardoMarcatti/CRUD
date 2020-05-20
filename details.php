<?php
    session_start();
    setlocale(LC_ALL, "pt_BR.utf-8");
    $cod = $_GET['cod'];
    require_once('functions.php');
?>

<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="crud.css"> 
        <title>CRUD - Detalhes</title>    
    </head>
    <body>
        <?php
            echo "<div id=\"barra\" class=\"col- container-fluid\"><a href=\"crud.php\" id=\"volta_crud\" b4>Voltar</a><a href=\"logout.php\" id=\"sair\">Sair</a></div>";
            if (isset($cod)) {
                $query = "select * from v_tudo where id = $cod";
                $result = $conection->query($query);
                foreach ($result as $key => $value) {
                    if ($key == 0) {
                        echo "<h3 class=\"col- container-fluid\">$value[nome]</h3>
                        <ul class=\"col- container-fluid\"><li>Sexo: $value[genero]</li></ul>";
                    };
                    echo "<ol class=\"shadow col-\">";
                    if ($value['complemento'] != '') {
                        echo "<li>$value[tipo_logradouro] $value[logradouro] Nº $value[numero]  - $value[complemento] - $value[bairro] - $value[cidade] - $value[estado]</li>
                        <li>Email: $value[email]</li>
                        <li>Telefone: ($value[ddd]) $value[telefone]</li>
                        <a href=\"update.php?codendereco=$value[id_endereco]&u_idcliente=$cod&u_id_ddd=$value[id_ddd]&u_id_telefone=$value[id_telefone]&u_id_email=$value[id_email]&u_tt=$value[tipo_telefone]\" id=\"alterar\">Alterar</a>";
                    } else {
                        echo "<li>$value[tipo_logradouro] $value[logradouro] Nº $value[numero] - $value[bairro] - $value[cidade]  - $value[estado]</li>
                        <li>Email: $value[email]</li>
                        <li>Telefone: ($value[ddd]) $value[telefone]</li>
                        <a href=\"update.php?codendereco=$value[id_endereco]&u_idcliente=$cod&u_id_ddd=$value[id_ddd]&u_id_telefone=$value[id_telefone]&u_id_email=$value[id_email]&u_tt=$value[tipo_telefone]\" id=\"alterar\">Alterar</a>";
                    };                        
                    echo "</ol>";
                };
                echo "</ol>";
            } else {
                header('location: login.php');
            };
            echo "<a href=\"addendereco.php?idcliente=$cod\" id=\"addendereco\"><input type=\"button\" value=\"Adicionar Endereço\" class=\"btn btn-success\"></a>";
        ?>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript"></script>
    </body>
</html>
