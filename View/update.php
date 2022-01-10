<?php
    namespace Testes\Projetos\PHP\CRUD\View;

    require_once '../View/assets/session.php';
    include_once '../Controller/updateClient.php';
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" defer></script>
        <script src="assets/crud.js" defer></script>
        <title>CRUD - Alteração</title>
    </head>
    <body>
        <div id="barra" class="col-12 container-fluid"><a href="../View/crud.php" id="volta_crud">Voltar</a><a href="../Controller/logout.php" id="sair">Sair</a></div>
        <div class="container-fluid" id="update">
            <form action="" method="post">
                <fieldset id="endereco_completo">
                    <div class="row">
                        <legend>Endereço</legend>
                        <div class="col-lg-2 col-12">
                            <label for="logradouro:">Logradouro:</label>
                            <select class="form-select" id="logradouro" name="logradouro" required="">
                            <?php 
                                $current_log_id = $current_address_details['id_logradouro'];
                                foreach ($log_list as $key => $value){
                                    if ($current_log_id == $value->getID()) { ?>
                                        <option value="<?=$value->getID()?>" selected=""><?=$value->getName()?></option>
                                    <?php } else { ?>
                                        <option value="<?=$value->getID()?>"><?=$value->getName()?></option>
                            <?php };
                                }; ?>
                            </select>
                        </div>
                        <div class="col-lg-5 col-12">
                            <label for="endereco:">Nome:</label>
                            <input type="text" name="endereco" id="endereco" value="<?=$current_address_details['logradouro']?>"class="form-control" required="">
                        </div>
                        <div class="col-lg-1 col-12">
                            <label for="numero:">Número:</label>
                            <input type="number" name="numero" min="0" id="numero"value="<?=$current_address_details['numero']?>" class="form-control" required="">
                        </div>
                        <div class="col-lg-4 col-12">
                            <label for="complemento:">Complemento:</label>
                            <input type="text" name="complemento" id="complemento" value="<?=$current_address_details['complemento']?>" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-5 col-12">
                            <label for="bairro:">Bairro:</label>
                            <input type="text" name="bairro" id="bairro" value="<?=$current_address_details['bairro']?>" class="form-control" required="">
                        </div>
                        <div class="col-lg-5 col-12">
                            <label for="cidade:">Cidade:</label>
                            <input type="text" name="cidade" id="cidade" value="<?=$current_address_details['cidade']?>" class="form-control" required="">
                        </div>
                        <div class="col-lg-2 col-12">
                            <label for="estado:">Estado:</label>
                            <select class="form-select" id="estado" name="estado" required="">
                            <?php
                            foreach ($state_list as $key => $value) {
                                if ($value->getID() == $current_state_id) { ?>
                                    <option value="<?=$value->getID()?>" selected> <?=$value->getName()?> </option>
                                <?php   } else { ?>
                                <option value="<?=$value->getID()?>"><?=$value->getName()?></option>
                            <?php };
                            }; ?>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <fieldset id="contato">
                    <div class="row form-group">
                        <legend>Contato</legend>
                        <div class="col-lg-1 col-12">
                            <label for="ddd:">DDD:</label>
                            <input type="number" name="ddd" id="ddd" value="<?=$current_address_details['ddd']?>" class="form-control" pattern="[0-9]{2}" required="">
                            <small>Formato: XX</small>
                        </div>
                    <div class="col-lg-3 col-12">
                        <label for="telefone:">Telefone:</label>
                        <input type="tel" name="telefone" id="telefone" value="<?=$current_address_details['telefone']?>" class="form-control" required="">
                    </div>
                    <div class="col-lg-2 col-12">
                        <label for="tipo_telefone:">Tipo:</label>
                        <select class="form-select" id="tipo_telefone" name="tipo_telefone" required="">";
                        <?php 
                            foreach ($telefone_types as $key => $value) {
                            if ($current_address_details['tipo_telefone'] == $value['id']) { ?>
                                <option value="<?=$value['id']?>" selected><?=$value['tipo']?> </option>
                            <?php } else { ?>
                                <option value="<?=$value['id']?>"><?=$value['tipo']?></option>
                        <?php    };
                        }; ?>
                        </select>
                    </div>
                        <div class="col-lg-6 col-12">
                            <label for="email">E-mail:</label>
                            <input type="email" name="email" id="email" value="<?=$current_address_details['email']?>" class="form-control">
                        </div>
                    </div>
                </fieldset>
                <div class="row form-group">
                    <div class="col-lg-2 col-4">
                        <button type="submit" id="submit_clientes" class="btn btn-block btn-success">Alterar</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>