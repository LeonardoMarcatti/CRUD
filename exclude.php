<?php
    setlocale(LC_ALL, "pt_BR.utf-8");
    session_start();
    include_once('functions.php');
    $cliente_id = $_GET['cod'];
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
        <title>Exclusão</title>    
    </head>
    <body>
        <?php
            echo "<div id=barra class=\"col- container-fluid\"><a href=crud.php id=volta_crud>Voltar</a><a href=logout.php id=sair>Sair</a></div>

            <h2>Exclusão de Cliente</h2>
            <p>Deseja realmente excluir o cliente "; echo GetValue('nome'); echo " ? </p>
            
            <div class=\"col- container-fluid\">
                <form action=\"\" method=\"post\">
                <input type=\"text\" name=\"delete_id\" id=\"delete_id\" value=\""; echo GetValue('id'); echo"\" hidden=\"\">
                    <div class=\"form-row form-group\">
                        <div class=\"col-lg-1 col-3\">
                            <button type=\"submit\" id=\"sim\" class=\"btn btn-danger btn-block\">Sim</button>
                        </div>
                        <div class=\"col-lg-1 col-3\">
                            <a href=crud.php><button type=\"button\" id=\"Não\" class=\"btn btn-primary btn-block\">Não</button></a>
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