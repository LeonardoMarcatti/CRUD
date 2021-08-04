<?php
    setlocale(LC_ALL, "pt_BR.utf-8");
    $del_id = filter_input(INPUT_GET, 'del', FILTER_VALIDATE_INT);
    include_once('functions.php');    
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
        <div id=barra class="col- container-fluid"><a href=crud.php id=volta_crud>Voltar</a><a href=logout.php id=sair>Sair</a></div>
        <div class="container-fluid">
            <div id="exclude_menu">
                <h2>Exclusão de Cliente</h2>
                <p>Deseja realmente excluir o cliente <?=GetValue('nome');?>?</p>   
                <form action="" method="post">
                    <input type="text" name="delete_id" id="delete_id"  hidden="" value=" <?=GetValue('id')?> ">
                    <div class="form-row form-group">
                        <div class="col-lg-1 col-3">
                            <button type="submit" id="sim" class="btn btn-danger btn-block">Sim</button>
                        </div>
                        <div class="col-lg-1 col-3">
                            <a href=crud.php><button type="button" id="Não" class="btn btn-primary btn-block">Não</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous"></script>
        <script>
            
        </script>
    </body>
</html>