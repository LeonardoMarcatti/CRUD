<?php 
    setlocale(LC_ALL, "pt_BR.utf-8");
    require_once 'functions.php';
    require_once 'conection.php';
    
?>
<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <title>PHP - Teste</title>
    </head>
    <body>
        <form action="functions.php" method="post">
            <label for="cadastra_nome">Nome:</label>
            <input type="text" name="nome" id="nome" >
            <br>
            <label for="sobre_nome">Sobrenome:</label>
            <input type="text" name="sobrenome" id="sobre_nome">
            <br>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="masculino" name="sex" class="custom-control-input" value="M">
                <label class="custom-control-label" for="masculino">Masculino</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="feminino" name="sex" class="custom-control-input" value="F">
                <label class="custom-control-label" for="feminino">Feminino</label>
            </div>
            <br>
            <label for="ddd">DDD:</label>
            <input type="number" name="ddd" id="ddd">
            <br>
            <label for="tel">Tel:</label>
            <input type="tel" name="tel" id="tel" pattern="[0-9]{4}-[0-9]{4}">
            <br>
            <label for="tipo_telefone:">Tipo:</label>
            <select id="tipo" name="tipo">
                <option value="4">Celular </option>
                <option value="2">Residencial</option>
                <option value="3">Comercial</option>
                <option value="1">Outro</option>
            </select>
            <br>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" placeholder="Deixe vazio se não possuir email">            
            <fieldset id="endereco_completo">
                <div class="form-row form-group">
                                <legend>Endereço</legend>
                                <div class="col-lg-1 col-12">
                                    <label for="logradouro:">Logradouro:</label>
                                    <select class="custom-select" id="logradouro" name="logradouro">
                                        <option label="Rua" value="2">Rua</option>
                                        <option label="Avenida" value="3">Avenida</option>
                                        <option label="Alameda" value="4">Alameda</option>
                                        <option label="Praça" value="5">Praça</option>
                                        <option label="Beco" value="1">Beco</option>
                                        <option label="Via" value="6">Via</option>
                                    </select>
                                </div>
                                <div class="col-lg-7 col-12">
                                    <label for="endereco:">Nome:</label>
                                    <input type="text" name="endereco" id="endereco" class="form-control" >
                                </div>
                                <div class="col-lg-1 col-12">
                                    <label for="numero:">Número:</label>
                                    <input type="number" name="numero"  min="0" id="numero" class="form-control">
                                </div>
                                <div class="col-lg-3 col-12">
                                    <label for="complemento:">Complemento:</label>
                                    <input type="text" name="complemento" id="complemento" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-row form-group">
                                <div class="col-lg-5 col-12 ">
                                    <label for="bairro:">Bairro:</label>
                                    <input type="text" name="bairro" id="bairro" class="form-control">
                                </div>
                                <div class="col-lg-5 col-12 ">
                                    <label for="cidade:">Cidade:</label>
                                    <input type="text" name="cidade" id="cidade" class="form-control" >
                                </div>
                                <div class="col-lg-2 col-12">
                                    <label for="estado:">Estado:</label>
                                    <select class="custom-select" id="uf" name="estado">
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
                        <button type="submit">Enviar</button>
        </form>
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script type="text/javascript"></script>
    </body>
</html>