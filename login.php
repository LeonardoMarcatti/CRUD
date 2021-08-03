<?php
    require_once 'conection.php';
    session_start();
    if (isset($_POST['user']) && isset($_POST['password'])) {
        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $sql = "select * from users";
        $result = $conection->prepare($sql);
        $result->execute();
        $all = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($all as $key => $value) {
            if (password_verify($password, $value['senha']) && $value['nome'] == $user) {
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
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="crud.css">
    <title>CRUD Login</title>
</head>
    <body id=fundo>
        <div class="container-fluid">
            <form action="login.php" method="post" class="col-lg-4 offset-lg-4 col-sm-12" id="form">
                <div class="mb-3">
                    <label for="user">Usuário</label>
                    <input type="text" name="user" id="user" class="form-control" required="">
                </div>
                <div class="mb-3">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" class="form-control" required="">
                </div>
                <button type="submit" class="btn btn-success">Login</button>
                <p class="text-right"><a href="cadastro.php" id="cadastre_user">Cadastre-se</a></p>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous"></script>
        <script>
            
        </script>
    </body>
</html>