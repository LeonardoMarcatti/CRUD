<?php
    setlocale(LC_ALL, "pt_BR.utf-8");
    require_once 'conection.php';

    //Função para novo cadastro.
    if (isset($_POST['nome']) && isset($_POST['username']) && isset($_POST['senha'])) {
        $nomecompleto = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $username = password_hash(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING), PASSWORD_BCRYPT);
        $senha = password_hash(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING), PASSWORD_BCRYPT);
        $sql = "INSERT INTO users(nome_de_usuario, senha, nome) VALUES(:username, :senha, :nomecompleto)";
        $insert_data = $conection->prepare($sql);
        $insert_data->bindValue(':username', $username);
        $insert_data->bindValue(':senha', $senha);
        $insert_data->bindValue(':nomecompleto', $nomecompleto);
        $insert_data->execute();
        CheckFile($_FILES['myfile']);
        echo "<p id=\"mensagem\">Cadastro efetuado com sucesso!</p>";
    };

    function CheckFile($val1){
        $type = $val1['type'];
       if ($type == 'image/jpeg') {
        Submit($_FILES['myfile']);
       } else {
          return false;
       };
    };

    function GeraCodigo(){
        $alfanum = 'ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
        $tamanho = 20;
        $cod = '';
        for ($i=0; $i < $tamanho; $i++) { 
            $char = substr($alfanum, rand(0, 36), 1);
            $cod .= $char;
        };
        return $cod;
    };

    function Submit($file){    
        global $conection;
        $tmp = $file['tmp_name'];
        $local = 'img/users/';
        $name =  GeraCodigo() . '_' . $file['name'];
        if (move_uploaded_file($tmp, "$local" . "$name")) {
            $max = $conection->query("select max(id) as 'id' from users")->fetch()['id'];
            $sql = "insert into image(caminho, iduser) values(:name, :max)";
            $insert = $conection->prepare($sql);
            $insert->bindParam(':name', $name);
            $insert->bindParam(':max', $max);
            $insert->execute();
        } else{
            echo "Erro";
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
        <title>CRUD - Cadastro</title>
    </head>
    <body id="fundo">
            <div class="container-fluid">
            <form action="" method="post" class="col-lg-4 offset-lg-4 col-10 offset-1" id="form" enctype="multipart/form-data">
                <div class="mb-3">
                    <div class=" col-lg-12 col-12">
                        <label for="nome">Nome Completo:</label>
                        <input type="text" name="nome" id="nome" required="" class="form-control">
                    </div>
                    <div class=" col-lg-12 col-12">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" required="" class="form-control">
                    </div>
                    <div class=" col-lg-12 col-12">
                        <label for="myfile">Foto:</label>
                        <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col-lg-12 col-12">
                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha" required="" class="form-control">
                    </div>
                    <div class=" col-lg-12 col-12">
                        <label for="senha">Repita sua senha:</label>
                        <input type="password" name="repete_senha" id="repete_senha" required="" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="">
                        <input type="submit" value="Cadastre-se" class="btn btn-success" id="btn_cadastre_user">
                        <p id="faca_login">Faça seu <a href="login.php">login</a></p>
                    </div>
                </div> 
            </form>
        </div>     
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="crud.js"></script>
    </body>
</html>