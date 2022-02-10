<?php
    namespace Testes\Projetos\PHP\CRUD\View;
    
    include_once '../View/assets/session.php';
    require_once '../Controller/detailsClient.php';
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
        <title>CRUD - Detalhes</title>    
    </head>
    <body>
        <div id="barra" class="col- container-fluid"><a href="../View/crud.php" id="volta_crud">Back</a><a href="../Controller/logout.php" id="sair">Logout</a></div>
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
                        <a href="update.php?idendereco=<?=$value['id_endereco']?>&idcliente=<?=$value['id']?>&idtel=<?=$value['id_telefone']?>&idemail=<?=$value['id_email']?>">Update</a>
                <?php } else { ?>
                    <li><?=$value['tipo_logradouro'] . ' ' . $value['logradouro'] . ' Nº ' .  $value['numero'] . ' - ' . $value['bairro'] . ' - ' . $value['cidade'] . ' - ' . $value['estado']?></li>
                    <li>Email: <?=$value['email']?></li>
                    <li>Telefone: (<?=$value['ddd']?>) <?=$value['telefone']?></li>
                    <a href="update.php?idendereco=<?=$value['id_endereco']?>&idcliente=<?=$value['id']?>&idtel=<?=$value['id_telefone']?>&idemail=<?=$value['id_email']?>">Update</a>
                <?php };  ?>
                </ol>                    
            <?php  }; ?>
            
        <a href="addendereco.php?idcliente=<?=$id?>" id="addendereco"><input type="button" value="Add Address" class="btn btn-success"></a>
    </body>
</html>
