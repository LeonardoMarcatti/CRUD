<?php
    setlocale(LC_ALL, "pt_BR.utf-8");
    session_start();
    $idcliente = $_GET['idcliente'];
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
        <title>Adicionar Endereço</title>    
    </head>
    <body>
    <div id=barra><a href=crud.php id=volta_crud>Voltar</a><a href=logout.php id=sair>Sair</a></div>
    <div class="container-fluid"> 
        <form id="cadastra_clientes_form" method="post" enctype="multipart/form-data">
            <fieldset id="endereco_completo">
                <div class="form-row form-group">
                    <legend>Endereço</legend>
                <div class="col-lg-2 col-12">
                    <label for="logradouro:">Logradouro:</label>
                    <select class="custom-select" id="logradouro" name="logradouro[]" required="">
                        <option label="Rua" value="2">Rua</option>
                        <option label="Avenida" value="3">Avenida</option>
                        <option label="Alameda" value="4">Alameda</option>
                        <option label="Praça" value="5">Praça</option>
                        <option label="Beco" value="1">Beco</option>
                        <option label="Via" value="6">Via</option>
                    </select>
                </div>
                    <div class="col-lg-6 col-12">
                        <label for="endereco:">Nome:</label>
                        <input type="text" name="endereco[]" id="endereco" class="form-control"  required="">
                    </div>
                    <div class="col-lg-1 col-12">
                        <label for="numero:">Número:</label>
                        <input type="number" name="numero[]"  min="0" id="numero" class="form-control" required="">
                    </div>
                    <div class="col-lg-3 col-12">
                        <label for="complemento:">Complemento:</label>
                        <input type="text" name="complemento[]" id="complemento" value="" class="form-control">
                    </div>
                </div>
                <div class="form-row form-group">
                    <div class="col-lg-5 col-12">
                        <label for="bairro:">Bairro:</label>
                        <input type="text" name="bairro[]" id="bairro" class="form-control" required="">
                    </div>
                    <div class="col-lg-5 col-12">
                        <label for="cidade:">Cidade:</label>
                        <input type="text" name="cidade[]" id="cidade" class="form-control" required="" >
                    </div>
                    <div class="col-lg-2 col-12">
                        <label for="estado:">Estado:</label>
                        <select class="custom-select" id="uf" name="estado[]" required="">
                            <option label="AC" value="1">AC</option>
                            <option label="AL" value="2">AL</option>
                            <option label="AP" value="3">AP</option>
                            <option label="AM" value="4">AM</option>
                            <option label="BA" value="5">BA</option>
                            <option label="CE" value="6">CE</option>
                            <option label="DF" value="7">DF</option>
                            <option label="ES" value="8">ES</option>
                            <option label="GO" value="9">GO</option>
                            <option label="MA" value="10">MA</option>
                            <option label="MT" value="11">MT</option>
                            <option label="MS" value="12">MS</option>
                            <option label="MG" value="13">MG</option>
                            <option label="PA" value="14">PA</option>
                            <option label="PB" value="15">PB</option>
                            <option label="PR" value="16">PR</option>
                            <option label="PE" value="17">PE</option>
                            <option label="PI" value="18">PI</option>
                            <option label="RJ" value="19">RJ</option>
                            <option label="RN" value="20">RN</option>
                            <option label="RS" value="21">RS</option>
                            <option label="RO" value="22">RO</option>
                            <option label="RR" value="23">RR</option>
                            <option label="SC" value="24">SC</option>
                            <option label="SP" value="25">SP</option>
                            <option label="SE" value="26">SE</option>
                            <option label="TO" value="27">TO</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <div class="form-row form-group">
                <div class="col-lg-2 col-4">
                    <button type="submit" id="submit_clientes" class="btn btn-block btn-success">Adicionar</button>
                </div>
                <div class="col-lg-2 col-4">
                    <button type="reset" id="reset_cliente"  class="btn btn-block btn-warning">Limpar</button>
                </div>
            </div>
        </form>
    </div>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript"></script>
    </body>
</html>