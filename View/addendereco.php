<?php
    namespace Testes\Projetos\PHP\CRUD\View;

    require_once '../View/assets/session.php';
    include_once '../Controller/addNewEndereco.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="assets/crud.css">
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous" defer></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" defer></script>
        <title>Adicionar Endereço</title>    
    </head>
    <body>
        <div id=barra><a href=crud.php id=volta_crud>Back</a><a href=../Controller/logout.php id=sair>Logout</a></div>
        <div class="container-fluid"> 
            <form id="add_address" method="post" action="">
                <fieldset id="endereco_completo">
                    <div class="form-row form-group">
                        <legend>Address</legend>
                        <div class="col-lg-2 col-12">
                            <label for="logradouro:">Way/Path type:</label>
                            <select class="custom-select" id="logradouro" name="logradouro" required="">
                                <?php
                                    foreach ($listaLogradouros as $key => $value) {?>
                                        <option value="<?=$value->getID()?>"><?=$value->getName()?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-12">
                            <label for="endereco:">Name:</label>
                            <input type="text" name="endereco" id="endereco" class="form-control"  required="">
                        </div>
                        <div class="col-lg-1 col-12">
                            <label for="numero:">Number:</label>
                            <input type="number" name="numero"  min="0" id="numero" class="form-control" required="">
                        </div>
                        <div class="col-lg-3 col-12">
                            <label for="complemento:">Complement:</label>
                            <input type="text" name="complemento" id="complemento" value="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row form-group">
                        <div class="col-lg-5 col-12">
                            <label for="bairro:">District/Neighborhood:</label>
                            <input type="text" name="bairro" id="bairro" class="form-control" required="">
                        </div>
                        <div class="col-lg-5 col-12">
                            <label for="cidade:">City:</label>
                            <input type="text" name="cidade" id="cidade" class="form-control" required="" >
                        </div>
                        <div class="col-lg-2 col-12">
                            <label for="estado:">State:</label>
                            <select class="custom-select" id="uf" name="estado" required="">
                                <?php
                                    foreach ($listaestados as $key => $value) { ?>
                                        <option value="<?=$value->getID()?>"><?=$value->getName()?></option>
                                <?php }; ?>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="form-row form-group">
                    <div class="col-lg-2 col-4">
                        <button type="submit" id="submit_clientes" class="btn btn-block btn-success">Add</button>
                    </div>
                    <div class="col-lg-2 col-4">
                        <button type="reset" id="reset_cliente"  class="btn btn-block btn-warning">Clear</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>