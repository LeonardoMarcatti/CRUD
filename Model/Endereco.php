<?php
    namespace Testes\Projetos\PHP\CRUD\Model;

    use PDO;
    class TipoLogradouro{
        private int $id;
        private string $name;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }
    };

    class TipoLogradouroDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function getAllLogradouros(){
            $sql = 'select * from tipo_logradouro';
            $select = $this->pdo->prepare($sql);
            $select->execute();
            $log = array();
            foreach ($select as $key => $value) {
                $tipo = new TipoLogradouro();
                $tipo->setID($value['id']);
                $tipo->setName($value['name']);
                $log[] = $tipo;
            };
            return $log;
        }
    };

    class Bairro{
        private int $id;
        private string $name;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }
    };

    Class BairroDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function checkBairro($bairro){
            $sql = 'select id from bairro where name = :name';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':name', $bairro);
            $result->execute();
            if ($result->rowCount() > 0) {
                return $result->fetch(PDO::FETCH_ASSOC)['id'];
            } else {
                return false;
            };            
        }

        public function addNewBairro(Bairro $b){
            $sql = 'insert into bairro(name) values(:name)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':name', $b->getName());
            $insert->execute();
        }

        public function getAllBairros(){
            $sql = 'select * from bairro order by id asc';
            $result = $this->pdo->prepare($sql);
            $result->execute();
            $bairros = array();
            foreach ($result as $key => $value) {
                $bairro = new Bairro();
                $bairro->setID($value['id']);
                $bairro->setName($value['name']);
                $bairros[] = $bairro;
            };
            return $bairros;
        }
    };

    class Cidade{
        private int $id;
        private string $name;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }
    }

    class CidadeDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function checkCidade($name){
            $sql = 'select id from cidade where name = :name';
            $result = $this->pdo->prepare($sql);
            $result->bindValue(':name', $name);
            $result->execute();
            if ($result->rowCount() > 0) {
                return $result->fetch(PDO::FETCH_ASSOC)['id'];
            } else {
                return false;
            }; 
        }

        public function addNewCidade(Cidade $c){
            $sql = 'insert into cidade(name) values(:name)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':name', $c->getName());
            $insert->execute();
        }
    }

    class Estado{
        private int $id;
        private string $name;

        public function setID($id){
            $this->id = $id;
        }

        public function getID(){
            return $this->id;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }
    };

    class EstadoDAO{
        private $pdo;

        public function __construct(PDO $conection){
            $this->pdo = $conection;
        }

        public function getAllEstados(){
            $sql = 'select * from estado order by id asc';
            $result = $this->pdo->prepare($sql);
            $result->execute();
            $estados = array();
            foreach ($result as $key => $value) {
                $estado = new Estado();
                $estado->setID($value['id']);
                $estado->setName($value['name']);
                $estados[] = $estado;
            };
            return $estados;
        }
    };

    class Endereco{
        
        private int $id, $tipo, $numero, $bairro, $cidade, $estado;
        private string $endereco, $complement;
        
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

        public function setComplement($complement){
           $this->complement = $complement;
        }

        public function getComplement(){
            return $this->complement;
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
    };

    class EnderecoCliente{
        private int $idcliente, $idendereco;

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
    };
?>