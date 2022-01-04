<?php
  namespace Testes\Projetos\PHP\CRUD\Model;

    class DDD{
      private $id;
      private $numero;

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
        $sql = 'insert into ddd(numero) values(:numero)';
        $insert = $this->pdo->prepare($sql);
        $insert->bindValue(':numero', $d->getNumero());
        $insert->execute();
      }

      public function checkDDD(DDD $d){
        $sql = 'select id from ddd where numero = :numero';
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

      public function getAll(){
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
      private int $id;
      private string $numero;
      private int $ddd;
      private string $tipo;

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
        $sql = 'select id from telefone where numero = :numero and ddd = :ddd and tipo = :tipo';
        $result = $this->pdo->prepare($sql);
        $result->bindValue(':numero', $t->getNumero());
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
        $sql = 'insert into telefone(numero, ddd, tipo) values(:numero, :ddd, :tipo)';
        $insert = $this->pdo->prepare($sql);
        $insert->bindValue(':numero', $t->getNumero());
        $insert->bindValue(':ddd', $t->getDDD());
        $insert->bindValue(':tipo', $t->getTipo());
        $insert->execute();
      }

      public function getAll(){
        $array = [];
        $sql = 'select t.id, t.numero, d.numero as "ddd", tt.tipo from telefone t join ddd d on t.ddd = d.id join tipo_telefone tt on t.tipo = tt.id';
        $result = $this->pdo->prepare($sql);
        $result->execute();
        foreach ($result as $key => $value) {
            $u = new Telefone();
            $u->setID($value['id']);
            $u->setNumero($value['numero']);
            $u->setDDD($value['ddd']);
            $u->setTipo($value['tipo']);
            $array[] = $u;
        };
        return $array;
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
        $sql = "insert into cliente_telefone(id_cliente, id_telefone) values(:id_cliente, :id_telefone)";
        $insert = $this->pdo->prepare($sql);
        $insert->bindValue(':id_cliente', $ct->getIDCliente());
        $insert->bindValue(':id_telefone', $ct->getIDTelefone());
        $insert->execute();
      }

      public function update(ClienteTelefone $ct, $tel_atual){
        $sql = "update cliente_telefone set id_telefone = :id_telefone where id_cliente = :id_cliente and id_telefone = :id_telefone_atual";
        $update = $this->pdo->prepare($sql);
        $update->bindValue(':id_cliente', $ct->getIDCliente());
        $update->bindValue(':id_telefone', $ct->getIDTelefone());
        $update->bindValue(':id_telefone_atual', $tel_atual);
        $update->execute();
      }
    };
?>