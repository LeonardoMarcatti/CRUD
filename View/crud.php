<?php
    namespace Testes\Projetos\PHP\CRUD\View;
    
    require_once '../View/assets/session.php';
    require_once '../Controller/help.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=yes">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" defer></script>
        <script src="assets/crud.js" defer></script>
        <script src="assets/table.js" defer></script>
        <link rel="stylesheet" href="assets/crud.css">
        <title>CRUD</title>
    </head>
    <body>
        <div id=barra class="container-fluid">
            <div class="row justify-content-evenly">
                <div class="col">
                    <a href=""></a>
                </div>
                <div class="col-lg-auto">
                    <img id="user_image" title="<?=$image_info['name']?>" src="../img/users/<?=$image_info['image']?>">
                </div>
                <div class="col-lg">
                    <a href=../Controller/logout.php id=sair>Sair</a>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs" id="abas" role="tab">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="menu_consulta">Consulta e Alteração</a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" data-bs-toggle="tab" role="tab" aria-controls="consulta_clientes" data-bs-target="#consulta_clientes" type="button" id="menu_consulta_clientes" aria-selected="false">Clientes</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown" role="tab">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="menu_cadastro">Cadastro</a>
                <div class="dropdown-menu">
                    <a class="nav-link" data-bs-toggle="tab" role="tab" aria-controls="clientes" data-bs-target="#cadastra_clientes" type="button"  aria-selected="false" id="menu_cadastro_clientes">Clientes</a>
                </div>
            </li>
        </ul>
        <div class="tab-content" id="todas_tabs">
            <div class="tab-pane fade show active" id="consulta_clientes" role="tabpanel" aria-labelledby="consulta_clientes_tab">
                <div class="container-fluid">
                    <form id="consulta_clientes_form" method="post" action="">
                        <div class="row g-3 justify-content-center">
                            <div class="col-1">
                                <label for="consulta_id">ID:</label>
                                <input type="number" name="id" id="id" min="1" placeholder="0" class="form-control">
                            </div>
                            <div class="col-5">
                                <label for="consulta_nome">Nome:</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="col-2 align-self-end">
                                <button type="submit" id="btn_consulta" class="btn btn-block btn-outline-success">Consultar</button>
                                <button type="reset" id="btn_reset_consulta"  class="btn btn-block btn-outline-warning">Limpar</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-6 offset-3">
                        <table class="table table-bordered table-striped table-hover text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th class="col-1">ID</th>
                                    <th class="col-9">Nome</th>
                                    <th class="col-2">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>   
                </div>
            </div>
            <div class="tab-pane fade" id="cadastra_clientes" role="tabpanel" aria-labelledby="clientes-tab">
                <div class="container-fluid">
                <form id="cadastra_clientes_form" action="../Controller/addClient.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" class="form-control" required=""> 
                        </div>
                        <div class="col-lg-6 col-12">
                            <label for="sobre_nome">Sobrenome:</label>
                            <input type="text" name="sobrenome" id="sobrenome" class="form-control" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input type="radio" id="masculino" name="sex" class="form-check-input" value="M" required="">
                                <label class="form-check-label" for="masculino">Masculino</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="feminino" name="sex" class="form-check-input" value="F" required="">
                                <label class="form-check-label" for="feminino">Feminino</label>
                            </div>
                        </div>
                    </div>
                        <fieldset id="endereco_completo">
                            <div class="row">
                                <legend>Endereço</legend>
                                <div class="col-lg-2 col-12">
                                    <label for="logradouro:">Logradouro:</label>
                                    <select class="form-select" id="logradouro" name="logradouro" required="">
                                        <?php
                                            foreach ($tipo as $key => $value) { ?>
                                                <option value="<?=$value->getID()?>"><?=$value->getName()?></option>
                                        <?php }; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label for="endereco:">Nome:</label>
                                    <input type="text" name="endereco" id="endereco" class="form-control"  required="">
                                </div>
                                <div class="col-lg-1 col-12">
                                    <label for="numero:">Número:</label>
                                    <input type="number" name="numero"  min="0" id="numero" class="form-control" required="">
                                </div>
                                <div class="col-lg-3 col-12">
                                    <label for="complemento:">Complemento:</label>
                                    <input type="text" name="complemento" id="complemento" value="" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-12 ">
                                    <label for="bairro:">Bairro:</label>
                                    <input type="text" name="bairro" id="bairro" class="form-control" required="">
                                </div>
                                <div class="col-lg-5 col-12 ">
                                    <label for="cidade:">Cidade:</label>
                                    <input type="text" name="cidade" id="cidade" class="form-control" required="" >
                                </div>
                                <div class="col-lg-2 col-12">
                                    <label for="estado:">Estado:</label>
                                    <select class="form-select" id="uf" name="estado" required="">
                                        <?php
                                            foreach ($lista_estados as $key => $value) {
                                                echo "<option label=\"" . $value->getName() . "\" value=\"" . $value->getID() . "\">" . $value->getName() . "</option>";
                                            };
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset id="contato">
                            <div class="row form-group">
                                <legend>Contato</legend>
                                <div class="col-lg-1 col-3">
                                    <label for="ddd:">DDD:</label>
                                    <input type="number" name="ddd" id="ddd" class="form-control" pattern="[0-9]{2}" required="">
                                    <small>Formato: XX</small>
                                </div>
                            <div class="col-lg-5 col-9">
                                <label for="telefone:">Telefone:</label>
                                <input type="tel" name="telefone" id="telefone" class="form-control" required="">
                            </div>
                            <div class="col-lg-2 col-12">
                                <label for="tipo_telefone:">Tipo:</label>
                                <select class="form-select" id="tipo_telefone" name="tipo_telefone" required="">
                                    <?php 
                                    foreach ($lista_tipos_telefone as $key => $value) { ?>
                                        <option value="<?= $value['id']?>"> <?= $value['tipo']?> </option>;
                                    <?php } ?>                                    
                                </select>
                            </div>
                                <div class="col-lg-4 col-12">
                                    <label for="email">E-mail:</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                            </div>
                        </fieldset>
                        <div class="row float-end g-2">
                            <div class="col">
                                <button type="submit" id="submit_clientes" class="btn btn-outline-success">Adicionar</button>
                            </div>
                            <div class="col">
                            <button type="reset" id="reset_cliente"  class="btn btn-outline-warning">Limpar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>