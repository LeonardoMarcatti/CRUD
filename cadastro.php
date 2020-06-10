<?php
    setlocale(LC_ALL, "pt_BR.utf-8");
    $novo_cadastro = '';
    $server = 'localhost';
    $db = 'CRUD';
    $user = 'root';
    $password = '';
    try {
        $conection = new PDO("mysql:host=$server; dbname=$db", "$user", "$password");
    } catch (Throwable $th) {
        echo 'Erro linha: ' . $th->getLine() . "<br>";
        echo 'Código: ' . $th->getMessage();
    };

    //Função para novo cadastro.
    if (isset($_POST['nome']) && isset($_POST['username']) && isset($_POST['senha'])) {
        $nomecompleto = $_POST['nome'];
        $username = md5($_POST['username']);
        $senha = md5($_POST['senha']);
        $sql = "INSERT INTO users(nome_de_usuario, senha, nome) VALUES('$username', '$senha', '$nomecompleto')";
        $novo_cadastro = $conection->query($sql);
        CheckFile($_FILES['myfile']);
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
            $sql = "insert into image(caminho, iduser) values('$name', $max)";
            $conection->query($sql);
        } else{
            echo "Erro";
        };
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
        <title>CRUD - Cadastro</title>
    </head>
    <body id="fundo">
        <?php
            echo "<div class=\"container-fluid\">
            <form action=\"cadastro.php\" method=\"post\" class=\"col-lg-4 offset-lg-4 col-10 offset-1\" id=\"form\" enctype=\"multipart/form-data\">
                <div class=\"form-row\">
                    <div class=\"form-group col-lg-12 col-12\">
                        <label for=\"nome\">Nome Completo:</label>
                        <input type=\"text\" name=\"nome\" id=\"nome\" required=\"\" class=\"form-control\">
                    </div>
                    <div class=\"form-group col-lg-12 col-12\">
                        <label for=\"username\">Username:</label>
                        <input type=\"text\" name=\"username\" id=\"username\" required=\"\" class=\"form-control\">
                    </div>
                    <div class=\"form-group col-lg-12 col-12\">
                        <label for=\"myfile\">Foto:</label>
                        <input type=\"file\" class=\"form-control-file\" id=\"myfile\" name=\"myfile\">
                    </div>
                </div>
                <div class=\"form-row\">
                    <div class=\"form-group col-lg-12 col-12\">
                        <label for=\"senha\">Senha:</label>
                        <input type=\"password\" name=\"senha\" id=\"senha\" required=\"\" class=\"form-control\">
                    </div>
                    <div class=\"form-group col-lg-12 col-12\">
                        <label for=\"senha\">Repita sua senha:</label>
                        <input type=\"password\" name=\"repete_senha\" id=\"repete_senha\" required=\"\" class=\"form-control\">
                    </div>
                </div>
                <div class=\"form-row\">
                    <div class=\"form-group\">
                        <input type=\"submit\" value=\"Cadastre-se\" class=\"btn btn-success\" id=\"btn_cadastre_user\">
                    </div>
                </div>";
                if ($novo_cadastro != '') {
                    echo "<p id=\"mensagem_cadastro\" class=\"text-center\">Cadastro efetuado com sucesso!</p>";
                };            

                echo "<p class=\"text-right\">Faça seu <a href=\"login.php\">login</a></p>
            </form>
        </div>";
        ?>

        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="crud.js"></script>
    </body>
</html>