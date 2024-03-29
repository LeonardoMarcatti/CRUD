<?php
     namespace Testes\Projetos\PHP\CRUD\View;

     \session_start();

?>

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" defer></script>
        <link rel="stylesheet" href="assets/crud.css">
        <script src="assets/crud.js" defer></script>
        <title>CRUD Login</title>
    </head>
    <body id=fundo>
        <div id="form_container">
        <?php
            if (!empty($_SESSION['flashMensagem'])) {?>
                <div id="flashBarra">
                    <p><?=$_SESSION['flashMensagem']?></p>
                </div>
        <?php  
                unset($_SESSION['flashMensagem']);
            }; ?>
        <?php
            if (!empty($_SESSION['flashError'])) {?>
                <div id="flashBarraError">
                    <p><?=$_SESSION['flashError']?></p>
                </div>
        <?php  
                unset($_SESSION['flashError']);
            }; ?>
            <form action="../Controller/validateLogin.php" method="post" class="col-lg-4 offset-lg-4 col-12" id="form">
                <div class="mb-3">
                    <label for="user">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required="">
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required="">
                </div>
                <button type="submit" class="btn btn-success">Login</button>
                <p id="cad"><a href="logup.php" id="cadastre_user">Log<sup>up</sup></a></p>
                <div class="mb-3">
                    <p><a href="esqueci.php" id="cadastre_user"><i class="fas fa-key"></i>Forgot your password?</a></p>
                </div>
            </form>
        </div>
    </body>
</html>