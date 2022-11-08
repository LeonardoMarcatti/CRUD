<?php
    namespace Testes\Projetos\PHP\CRUD\Config;

    use PDO;
    use Throwable;

    class Connection
    {
        private $conn;
        private static $instance;

        private function __construct(){}

        private static function getInstance(){
            if (empty(self::$instance)) {
                self::$instance = new self;
            };
            return self::$instance;
        }

        public static function getConnection()
        {
            $db = self::getInstance();
            try {
                $db->connection = new PDO("mysql:host=localhost; dbname=CRUD", 'leo', 'Aa119539$');
                $db->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Throwable $th) {
                echo 'Erro linha: ' . $th->getLine() . "<br>";
                echo ('Código: ' . $th->getMessage());
            };
            return $db->connection;
        }
    };
