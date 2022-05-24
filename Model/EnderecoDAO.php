<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    use PDO;

    class EnderecoDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function checkEndereco(Endereco $e){
            $sql = 'select id from endereco where tipo_logradouro = :logradouro and name_logradouro = :endereco and numero = :numero and complement = :complement and bairro = :bairro and cidade = :cidade and estado = :estado';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':logradouro', $e->getTipo());
            $result->bindValue(':endereco', $e->getEndereco());
            $result->bindValue(':numero', $e->getnumero());
            $result->bindValue(':complement', $e->getComplement());
            $result->bindValue(':bairro', $e->getBairro());
            $result->bindValue(':cidade', $e->getCidade());
            $result->bindValue(':estado', $e->getEstado());
            $result->execute();
            if ($result->rowCount() > 0) {
                return $result->fetch(PDO::FETCH_ASSOC)['id'];
            } else {
                return false;
            };  
        }

        public function addNewEndereco(Endereco $e){
            $sql = 'insert into endereco(tipo_logradouro, Name_logradouro, numero, complement, bairro, cidade, estado) values(:logradouro, :endereco, :numero, :complement, :bairro, :cidade, :estado)';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':logradouro', $e->getTipo());
            $result->bindValue(':endereco', $e->getEndereco());
            $result->bindValue(':numero', $e->getnumero());
            $result->bindValue(':complement', $e->getComplement());
            $result->bindValue(':bairro', $e->getBairro());
            $result->bindValue(':cidade', $e->getCidade());
            $result->bindValue(':estado', $e->getEstado());
            $result->execute();
        }

        public function getEnderecoDetails(Endereco $e)
        {
            $sql = "select * from v_tudo where id_endereco =:id";
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':id', $e->getID());
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }
    }

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