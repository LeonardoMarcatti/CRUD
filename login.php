<?php 
    require_once 'conection.php';
    session_start();
    if (isset($_POST['user']) && isset($_POST['password'])) {
        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $sql = "select * from users";
        $result = $conection->prepare($sql);
        $result->execute();
        $all = $result->fetchAll();

        foreach ($all as $key => $value) {
            if (password_verify($user, $value['nome_de_usuario'])) {
                $_SESSION['user'] = $value['nome_de_usuario'];
                header('location: crud.php');
                exit;
            };
        };
    };
?>
<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16"> 
        <link rel="stylesheet" href="crud.css">  
        <title>CRUD Login</title>    
    </head>
    <body id=fundo>
        <?php
            echo 
            "<div class=\"container-fluid\">
                <form action=\"login.php\" method=\"post\" class=\"col-lg-4 offset-lg-4 col-sm-12\" id=\"form\">
                    <div class=\"form-group\">
                        <label for=\"user\">Usuário</label>
                        <input type=\"text\" name=\"user\" id=\"user\" class=\"form-control\" required=\"\">
                    </div>
                    <div class=\"form-group\">
                    <label for=\"password\">Senha</label>
                        <input type=\"password\" name=\"password\" id=\"password\" class=\"form-control\" required=\"\">
                    </div>
                        <button type=\"submit\" class=\"btn btn-success\">Login</button>
                        <p class=\"text-right\"><a href=\"cadastro.php\" id=\"cadastre_user\">Cadastre-se</a></p>
                </form>
            </div>";            
        ?>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript"></script>
    </body>
</html>