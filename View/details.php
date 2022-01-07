<?php
    namespace Testes\Projetos\PHP\CRUD\View;
    
    include_once '../View/assets/session.php';
    require_once '../Controller/detailsClient.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="assets/crud.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous" defer></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous" defer></script>
        <title>CRUD - Detalhes</title>    
    </head>
    <body>
        <div id="barra" class="col- container-fluid"><a href="../View/crud.php" id="volta_crud">Voltar</a><a href="../Controller/logout.php" id="sair">Sair</a></div>
        <?php
            foreach ($client_info as $key => $value) {
                if ($key == 0) { ?>
                    <h3 class="col- container-fluid"><?=$value['name']?></h3>
                    <ul class="col- container-fluid"><li>Sexo: <?=$value['gender']?></li></ul>
            <?php    };
                if (isset($_SESSION['flash_details']) &&  $_SESSION['flash_details'] != '') { ?>
                    <h5 id="flash"><?=$_SESSION['flash_details']?></h5>
                    <?php unset($_SESSION['flash_details']); 
                }; ?>
                <ol class="shadow col-">
                <?php 
                    if ($value['complemento'] != '') { ?>
                        <li>
                            <?=$value['tipo_logradouro'] . ' ' . $value['logradouro'] . ' Nº ' . $value['numero'] . ' - ' . $value['complemento'] .' - ' . $value['bairro'] . ' - ' .$value['cidade'] . ' - ' .$value['estado']?>
                        </li>
                        <li>Email: <?=$value['email']?></li>
                        <li>Telefone: (<?=$value['ddd']?>) <?=$value['telefone']?></li>
                        <a href="update.php?idendereco=<?=$value['id_endereco']?>&idcliente=<?=$value['id']?>&idtel=<?=$value['id_telefone']?>&idemail=<?=$value['id_email']?>">Alterar</a>
                <?php } else { ?>
                    <li><?=$value['tipo_logradouro'] . ' ' . $value['logradouro'] . ' Nº ' .  $value['numero'] . ' - ' . $value['bairro'] . ' - ' . $value['cidade'] . ' - ' . $value['estado']?></li>
                    <li>Email: <?=$value['email']?></li>
                    <li>Telefone: (<?=$value['ddd']?>) <?=$value['telefone']?></li>
                    <a href="update.php?idendereco=<?=$value['id_endereco']?>&idcliente=<?=$value['id']?>&idtel=<?=$value['id_telefone']?>&idemail=<?=$value['id_email']?>">Alterar</a>
                <?php };  ?>
                </ol>                    
            <?php  }; ?>
            
        <a href="addendereco.php?idcliente=<?=$id?>" id="addendereco"><input type="button" value="Adicionar Endereço" class="btn btn-success"></a>
    </body>
</html>
