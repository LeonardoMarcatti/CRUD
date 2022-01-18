<?php
    namespace Testes\Projetos\PHP\CRUD\View;

    require_once '../Controller/gerarNovaSenha.php';


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
        <link rel="stylesheet" href="assets/crud.css">
        <script src="assets/crud.js" defer></script>
        <title>Nova Senha</title>
    </head>
    <body id="fundo">
        <div id="form_container">
            <form action="" method="post" id="form" class="col-lg-4 offset-lg-4 col-sm-12">
                <div class="mb-3">
                    <label for="pass" class="form-label">Senha:</label>
                    <input type="password" name="pass" id="pass" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="pass2" class="form-label">Repita senha:</label>
                    <input type="password" name="pass2" id="pass2" class="form-control">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-danger">Atualizar</button>
                </div>
            </form>
        </div>
    </body>
</html>

