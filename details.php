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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                        <?php unset($_SESSION['flash_details']); 
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
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous"></script>
        <script>
            
        </script>
    </body>
</html>
