<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    use PDO;

    class EnderecoClienteDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function add(EnderecoCliente $ec){
            $sql = 'insert into endereco_client(id_cliente, id_endereco) values(:idcliente, :idendereco)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':idcliente', $ec->getIDCliente());
            $insert->bindValue('idendereco', $ec->getIDEndereco());
            $insert->execute();
        }

        public function update(EnderecoCliente $ec, $id_endereco_atual){
            $sql = "update endereco_client set id_endereco = :id_endereco where id_cliente = :id_cliente and id_endereco = :id_endereco_atual";
            $update = $this->pdo->prepare($sql);
            $update->bindValue(':id_cliente', $ec->getIDCliente());
            $update->bindValue(':id_endereco',$ec->getIDEndereco());
            $update->bindValue(':id_endereco_atual', $id_endereco_atual);
            $update->execute();
        }
    }