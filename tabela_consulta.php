<?php
    include_once 'functions.php';
    
    echo "<table class=\"table table-bordered table-striped table-hover text-center col-lg-6 offset-lg-3 col-sm-12\">
        <thead class=\"thead-dark\">
            <tr>
                <th scope=\"col-1\">ID</th>
                <th scope=\"col-\" colspan=\"2\">Nome</th>
            </tr>
        </thead>
        <tbody>";
            $query = 'select * from cliente';
            if (!empty($_GET['consulta_nome'])) {
                $nome = '%' . $_GET['consulta_nome'] . '%';
                $query .= " where nome like :nome";
                $result = $conection->prepare($query);
                $result->bindParam(':nome', $nome);
                $result->execute();
            } elseif (!empty($_GET['consulta_id'])) {
                $id = $_GET['consulta_id'];
                $query .= " where id = :id";
                $result = $conection->prepare($query);
                $result->bindParam(':id', $id);
                $result->execute();
            } else{
                $result = $conection->prepare($query);
                $result->execute();
            };            
            
            foreach ($result as $key => $value) {
                echo "<tr>
                <th class=\"col-\" scope=\"row\"><a href=\"details.php?cod=$value[id]\">$value[id]</a></th>
                <td class=\"col-1\" scope=\"col-\"><a href=\"details.php?cod=$value[id]\">$value[nome]</a></td>
                <td class=\"col-\" scope=\"col-\"><a href=\"exclude.php?del=$value[id]\"><i class=\"fas fa-trash-alt\"></i></a></</td>
                </tr>";
            };
        echo"</tbody>
    </table>";
?>