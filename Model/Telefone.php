<?php
  namespace Testes\Projetos\PHP\CRUD\Model;

    class DDD{
      private int $id;
      private string $numero;

      public function setID($id){
        $this->id = $id;
      }

      public function getID(){
        return $this->id;
      }

      public function setNumero($numero){
        $this->numero = $numero;
      }

      public function getNumero(){
        return $this->numero;
      }
    };

    class DDD_DAO{
      private $pdo;

      public function __construct(\PDO $conection){
          $this->pdo = $conection;
      }

      public function addDDD(DDD $d){
        $sql = 'insert into ddd(number) values(:numero)';
        $insert = $this->pdo->prepare($sql);
        $insert->bindValue(':numero', $d->getNumero());
        $insert->execute();
      }

      public function checkDDD(DDD $d){
        $sql = 'select id from ddd where number = :numero';
        $result = $this->pdo->prepare($sql);
        $result->bindValue(':numero', $d->getNumero());
        $result->execute();
        if ($result->rowCount() > 0) {
          return $result->fetch()['id'];
        } else {
          return false;
        };
      }
    };

    class TipoTelefoneDAO{
      private $pdo;

      public function __construct(\PDO $conection){
        $this->pdo = $conection;
      }

      public function getAllTipoTelefones(){
        $lista = array();
        $sql = 'select * from tipo_telefone order by id asc';
        $result = $this->pdo->prepare($sql);
        $result->execute();
        foreach ($result as $key => $value) {
          $lista[] = $value;
        };
        return $lista;
      }

    };

    class Telefone{
      private int $id, $ddd;
      private string $number, $tipo;

      public function setID($id){
       $this->id = $id;
      }

      public function getID(){
        return $this->id;
      }

      public function setNumber($number){
        $this->number = $number;
      }

      public function getNumber(){
        return $this->number;
      }

      public function setDDD($ddd){
        $this->ddd = $ddd;
      }

      public function getDDD(){
        return $this->ddd;
      }

      public function setTipo($tipo){
        $this->tipo = $tipo;
      }

      public function getTipo(){
        return $this->tipo;
      }
    };

    class TelefoneDAO{
      private $pdo;

      public function __construct(\PDO $conection){
          $this->pdo = $conection;
      }

      public function checkTelefone(Telefone $t){
        $sql = 'select id from telefone where number = :number and ddd = :ddd and tipo = :tipo';
        $result = $this->pdo->prepare($sql);
        $result->bindValue(':number', $t->getNumber());
        $result->bindValue(':ddd', $t->getDDD());
        $result->bindValue(':tipo', $t->getTipo());
        $result->execute();
        if ($result->rowCount() > 0) {
          return $result->fetch()['id'];
        } else {
          return false;
        };
      }

      public function add(Telefone $t){
        $sql = 'insert into telefone(number, ddd, tipo) values(:number, :ddd, :tipo)';
        $insert = $this->pdo->prepare($sql);
        $insert->bindValue(':number', $t->getNumber());
        $insert->bindValue(':ddd', $t->getDDD());
        $insert->bindValue(':tipo', $t->getTipo());
        $insert->execute();
      }
      
    };

    class ClienteTelefone{
      private int $idcliente;
      private int $idtelefone;

      public function setIDCliente($idcliente){
        $this->idcliente = $idcliente;
      }

      public function getIDCliente(){
        return $this->idcliente;
      }

      public function setIDTelefone($idtelefone){
        $this->idtelefone = $idtelefone;
      }

      public function getIDTelefone(){
        return $this->idtelefone;
      }
    };

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
    };
?>