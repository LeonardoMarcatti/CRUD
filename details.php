<?php
    setlocale(LC_ALL, "pt_BR.utf-8");
    $cod = filter_input(INPUT_GET, 'cod', FILTER_VALIDATE_INT);
    require_once('functions.php');
?>

<!DOCTYPE html>
<html lang="pt_BR">
    <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="crud.css"> 
        <title>CRUD - Detalhes</title>    
    </head>
    <body>
        <?php
            echo "<div id=\"barra\" class=\"col- container-fluid\"><a href=\"crud.php\" id=\"volta_crud\" b4>Voltar</a><a href=\"logout.php\" id=\"sair\">Sair</a></div>";
            if (isset($cod)) {
                $result = getDetails($cod);
                foreach ($result as $key => $value) {
                    if ($key == 0) {
                        echo "<h3 class=\"col- container-fluid\">$value[nome]</h3>
                        <ul class=\"col- container-fluid\"><li>Sexo: $value[genero]</li></ul>";
                    };
                    if (isset($_SESSION['flash_details']) &&  $_SESSION['flash_details'] != '') { ?>
                        <h5 id="flash"><?=$_SESSION['flash_details'];?></h5>
                        <?php unset($_SESSION['flash']); 
                    };
                    echo "<ol class=\"shadow col-\">";
                    if ($value['complemento'] != '') {
                        echo "<li>$value[tipo_logradouro] $value[logradouro] Nº $value[numero]  - $value[complemento] - $value[bairro] - $value[cidade] - $value[estado]</li>
                        <li>Email: $value[email]</li>
                        <li>Telefone: ($value[ddd]) $value[telefone]</li>
                        <a href=\"update.php?idendereco=$value[id_endereco]&idcliente=$value[id]&idtel=$value[id_telefone]&idemail=$value[id_email]\" id=\"alterar\">Alterar</a>";
                    } else {
                        echo "<li>$value[tipo_logradouro] $value[logradouro] Nº $value[numero] - $value[bairro] - $value[cidade]  - $value[estado]</li>
                        <li>Email: $value[email]</li>
                        <li>Telefone: ($value[ddd]) $value[telefone]</li>
                        <a href=\"update.php?idendereco=$value[id_endereco]&idcliente=$value[id]&idtel=$value[id_telefone]&idemail=$value[id_email]\" id=\"alterar\">Alterar</a>";
                    };                        
                    echo "</ol>";
                };
                echo "</ol>";
            } else {
                header('location: crud.php');
                exit;
            };
            echo "<a href=\"addendereco.php?idcliente=$cod\" id=\"addendereco\"><input type=\"button\" value=\"Adicionar Endereço\" class=\"btn btn-success\"></a>";
        ?>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="crud.js"></script>
    </body>
</html>
