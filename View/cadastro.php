<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=yes">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="icon" href="https://image.flaticon.com/icons/png/512/1216/1216733.png" type="image/png" sizes="16x16">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" defer></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous" defer></script>
        <script type="text/javascript" src="assets/crud.js" defer></script>
        <link rel="stylesheet" href="assets/crud.css">
        <title>CRUD - Cadastro</title>
    </head>
    <body id="fundo">
        <div class="container-fluid">
            <form action="../Controller/addUser.php" method="post" class="col-lg-4 offset-lg-4 col-10 offset-1" id="form" enctype="multipart/form-data">
                <div class=" col-lg-12 col-12 mb-3">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" name="name" id="name" required="" class="form-control">
                </div>
                <div class=" col-lg-12 col-12 mb-3">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required="" class="form-control">
                </div>
                <div class=" col-lg-12 col-12 mb-3">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required="" class="form-control">
                </div>
                <div class=" col-lg-12 col-12 mb-3">
                    <label for="myfile">Foto:</label>
                    <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*">
                </div>
                <div class="col-lg-12 col-12 mb-3">
                    <label for="senha">Senha:</label>
                    <input type="password" name="pass" id="pass" required="" class="form-control">
                </div>
                <div class=" col-lg-12 col-12">
                    <label for="senha">Repita sua senha:</label>
                    <input type="password" name="pass2" id="pass2" required="" class="form-control">
                </div>
                <div class="mb-3">
                    <input type="submit" value="Cadastrar" class="btn btn-success" id="btn_cadastre_user">
                    <p id="faca_login">Faça seu <a href="login.php">login</a></p>
                </div>
            </form>
        </div> 
    </body>
</html>