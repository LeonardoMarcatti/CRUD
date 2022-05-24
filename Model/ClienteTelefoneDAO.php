<?php
    namespace Testes\Projetos\PHP\CRUD\Model;
    
Class ClienteTelefoneDAO{
    private $pdo;

    public function __construct(\PDO $conection){
        $this->pdo = $conection;
    }

    public function add(ClienteTelefone $ct){
    $sql = "insert into client_telefone(id_cliente, id_telefone) values(:id_cliente, :id_telefone)";
    $insert = $this->pdo->prepare($sql);
    $insert->bindValue(':id_cliente', $ct->getIDCliente());
    $insert->bindValue(':id_telefone', $ct->getIDTelefone());
    $insert->execute();
    }

    public function update(ClienteTelefone $ct, $tel_atual){
    $sql = "update client_telefone set id_telefone = :id_telefone where id_cliente = :id_cliente and id_telefone = :id_telefone_atual";
    $update = $this->pdo->prepare($sql);
    $update->bindValue(':id_cliente', $ct->getIDCliente());
    $update->bindValue(':id_telefone', $ct->getIDTelefone());
    $update->bindValue(':id_telefone_atual', $tel_atual);
    $update->execute();
    }
}