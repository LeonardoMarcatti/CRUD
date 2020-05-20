<?php
    include_once('functions.php');
    
    echo "<table class=\"table table-bordered table-striped table-hover text-center col-lg-6 offset-lg-3 col-sm-12\">
        <thead class=\"thead-dark\">
            <tr>
                <th scope=\"col-1\">ID</th>
                <th scope=\"col-\" colspan=\"2\">Nome</th>
            </tr>
        </thead>
        <tbody>";
            $query = 'SELECT * FROM cliente';
            if (isset($_GET['consulta_nome']) && $_GET['consulta_nome']!= '') {
                $query .= " where nome like '%$_GET[consulta_nome]%'";
            } elseif (isset($_GET['consulta_id']) && $_GET['consulta_id']!= '') {
                $query .= " where id = $_GET[consulta_id]";
            };
            
            $result = $conection->query($query);
            foreach ($result as $key => $value) {
                echo "<tr>
                <th class=\"col-\" scope=\"row\"><a href=\"details.php?cod=$value[id]\">$value[id]</a></th>
                <td class=\"col-1\" scope=\"col-\"><a href=\"details.php?cod=$value[id]\">$value[nome]</a></td>
                <td class=\"col-\" scope=\"col-\"><a href=\"exclude.php?cod=$value[id]\"><i class=\"fas fa-trash-alt\"></i></a></</td>
                </tr>";
            };
        echo"</tbody>
    </table>";
?>