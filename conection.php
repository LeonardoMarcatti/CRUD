<?php
    $server = 'localhost';
    $db = 'CRUD';
    $user = 'root';
    $password = 'a';
    
    try {
        $conection = new PDO("mysql:host=$server; dbname=$db", "$user", "$password");
    } catch (Throwable $th) {
        echo 'Erro linha: ' . $th->getLine() . "<br>";
        echo ('Código: ' . $th->getMessage());
    };
?>