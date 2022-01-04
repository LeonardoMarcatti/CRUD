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
        <?php
            $query = 'select * from cliente';
            if (!empty($_GET['consulta_nome'])) {
                $nome = '%' . $_GET['consulta_nome'] . '%';
                $query .= " where nome like :nome";
                $result = $connection->prepare($query);
                $result->bindParam(':nome', $nome);
                $result->execute();
            } elseif (!empty($_GET['consulta_id'])) {
                $id = $_GET['consulta_id'];
                $query .= " where id = :id";
                $result = $connection->prepare($query);
                $result->bindParam(':id', $id);
                $result->execute();
            } else{
                $result = $connection->prepare($query);
                $result->execute();
                
            };            
            foreach ($result as $key => $value) {?>
                <tr>
                    <th scope="row"><a href="details.php?cod=<?=$value['id']?>"><?= $value['id']?></a></th>
                    <td><a href="details.php?cod=<?=$value['id']?>"><?=$value['nome']?></a></td>
                    <td><a href="exclude.php?del=<?=$value['id']?>"><i class="fas fa-trash-alt"></i></a></</td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>