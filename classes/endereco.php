<?php
    class TipoLogradouro{
        private int $id;
        private string $nome;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getNome(){
            return $this->nome;
        }
    };

    class TipoLogradouroDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function getAll(){
            $sql = 'select * from tipo_logradouro';
            $select = $this->pdo->prepare($sql);
            $select->execute();
            $log = array();
            foreach ($select as $key => $value) {
                $tipo = new TipoLogradouro();
                $tipo->setID($value['id']);
                $tipo->setNome($value['nome']);
                $log[] = $tipo;
            };
            return $log;
        }
    };

    class Bairro{
        private int $id;
        private string $nome;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getNome(){
            return $this->nome;
        }
    };

    Class BairroDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function checkBairro($bairro){
            $sql = 'select id from bairro where nome = :nome';
            $result = $this->pdo->prepare($sql);
            $result->bindParam(':nome', $bairro);
            $result->execute();
            $id = $result->fetch()['id'];
            if ($id) {
                return $id;
            } else {
                return false;
            };            
        }

        public function add(Bairro $b){
            $sql = 'insert into bairro(nome) values(:nome)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindParam(':nome', $b->getNome());
            $insert->execute();
        }

        public function getAll(){
            $sql = 'select * from bairro order by id asc';
            $result = $this->pdo->prepare($sql);
            $result->execute();
            $bairros = array();
            foreach ($result as $key => $value) {
                $bairro = new Bairro();
                $bairro->setID($value['id']);
                $bairro->setNome($value['nome']);
                $bairros[] = $bairro;
            };
            return $bairros;
        }
    };

    class Cidade{
        private int $id;
        private string $nome;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getNome(){
            return $this->nome;
        }
    }

    class CidadeDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function checkCidade($nome){
            $sql = 'select id from cidade where nome = :nome';
            $result = $this->pdo->prepare($sql);
            $result->bindParam(':nome', $nome);
            $result->execute();
            $id = $result->fetch()['id'];
            return $id;            
        }

        public function add(Cidade $c){
            $sql = 'insert into cidade(nome) values(:nome)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindParam(':nome', $c->getNome());
            $insert->execute();
        }
    }

    class Estado{
        private int $id;
        private string $nome;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getNome(){
            return $this->nome;
        }
    };

    class EstadoDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function getAll(){
            $sql = 'select * from estado order by id asc';
            $result = $this->pdo->prepare($sql);
            $result->execute();
            $estados = array();
            foreach ($result as $key => $value) {
                $estado = new Estado();
                $estado->setID($value['id']);
                $estado->setNome($value['nome']);
                $estados[] = $estado;
            };
            return $estados;
        }
    };

    class Endereco{
        private int $id;
        private int $tipo;
        private string $endereco;
        private int $numero;
        private string $complemento;
        private int $bairro;
        private int $cidade;
        private int $estado;        
        
        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setTipo($tipo){
            $this->tipo = $tipo;
        }

        public function getTipo(){
           return $this->tipo;
        }

        public function setEndereco($endereco){
           $this->endereco = $endereco;
        }

        public function getEndereco(){
           return $this->endereco;
        }

        public function setnumero($numero){
            $this->numero = $numero;
        }

        public function getnumero(){
            return $this->numero;
        }

        public function setComplemento($complemento){
           $this->complemento = $complemento;
        }

        public function getComplemento(){
            return $this->complemento;
        }

        public function setBairro($bairro){
           $this->bairro = $bairro;
        }

        public function getBairro(){
           return $this->bairro;
        }

        public function setCidade($cidade){
            $this->cidade = $cidade;
        }

        public function getCidade(){
            return $this->cidade;
        }

        public function setEstado($estado){
            $this->estado = $estado;
        }

        public function getEstado(){
            return $this->estado;
        }
    };

    class EnderecoDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function checkEndereco(Endereco $e){
            $sql = 'select id from endereco where tipo_logradouro = :logradouro and nome_logradouro = :endereco and numero = :numero and complemento = :complemento and bairro = :bairro and cidade = :cidade and estado = :estado';
            $result = $this->pdo->prepare($sql);
            $result->bindParam(':logradouro', $e->getTipo());
            $result->bindParam(':endereco', $e->getEndereco());
            $result->bindParam(':numero', $e->getnumero());
            $result->bindParam(':complemento', $e->getComplemento());
            $result->bindParam(':bairro', $e->getBairro());
            $result->bindParam(':cidade', $e->getCidade());
            $result->bindParam(':estado', $e->getEstado());
            $result->execute();
            $id = $result->fetch()['id'];
            return $id;
        }

        public function add(Endereco $e){
            $sql = 'insert into endereco(tipo_logradouro, nome_logradouro, numero, complemento, bairro, cidade, estado) values(:logradouro, :endereco, :numero, :complemento, :bairro, :cidade, :estado)';
            $result = $this->pdo->prepare($sql);
            $result->bindParam(':logradouro', $e->getTipo());
            $result->bindParam(':endereco', $e->getEndereco());
            $result->bindParam(':numero', $e->getnumero());
            $result->bindParam(':complemento', $e->getComplemento());
            $result->bindParam(':bairro', $e->getBairro());
            $result->bindParam(':cidade', $e->getCidade());
            $result->bindParam(':estado', $e->getEstado());
            $result->execute();
            $id = $result->fetch()['id'];
            return $id;
        }


    };

    class EnderecoCliente{
        private int $idcliente;
        private int $idendereco;

        public function setIDCliente($idcliente){
            $this->idcliente = $idcliente;
        }

        public function getIDCliente(){
            return $this->idcliente;
        }

        public function setIDEndereco($idendereco){
            $this->idendereco = $idendereco;
        }

        public function getIDEndereco(){
            return $this->idendereco;
        }
    };

    class EnderecoClienteDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function add(EnderecoCliente $ec){
            $sql = 'insert into endereco_cliente(id_cliente, id_endereco) values(:idcliente, :idendereco)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindParam(':idcliente', $ec->getIDCliente());
            $insert->bindParam('idendereco', $ec->getIDEndereco());
            $insert->execute();
        }

        public function update(EnderecoCliente $ec, $id_endereco_atual){
            $sql = "update endereco_cliente set id_endereco = :id_endereco where id_cliente = :id_cliente and id_endereco = $id_endereco_atual";
            $update = $this->pdo->prepare($sql);
            $update->bindParam(':id_cliente', $ec->getIDCliente());
            $update->bindParam(':id_endereco',$ec->getIDEndereco());
            $update->execute();
        }
    };
?>