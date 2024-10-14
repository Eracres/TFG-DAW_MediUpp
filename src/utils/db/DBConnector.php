<?php
    // Singleton con la conexión a la BBDD
    class DBConnector {
        // Propiedades
        private $conn;
        private $statement;
        private $executed = false;
        
        private static $instance = null;

        // Modos de fetch como constantes
        const FETCH_ALL = null;
        const FETCH_ROW = null;
        const FETCH_COLUMN = null;

        private function __construct() { }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function initialize(
            $db_name, 
            $db_user  = 'root', 
            $db_pass  = '1234',
            $db_host  = 'localhost',
            $engine   = 'mysql',
            $port     = '3306',
            $charset  = 'utf8', 
            $options  = null
        ) {
            $conn_str = "$engine:host=$db_host;dbname=$db_name;charset=$charset;port=$port";

            if ($options == null) {
                $options = [
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ];
            }

            try {
                $this->conn = new PDO($conn_str, $db_user, $db_pass, $options);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                exit('No ha sido posible establecer la conexión a la BBDD');
            }
        }

        function execute(string $query, ...$params) {
            $this->statement = $this->conn->prepare($query);

            if($params == null){
                $this->executed = $this->statement->execute();
                return;
            }

            if($params != null && is_array($params[0])) {
                $parametros = $params[0]; // Si nos pasan un array lo usamos como parámetro
            }

            $this->executed = $this->statement->execute($parametros);
        }

        public function getData($fetch_type) {
            switch ($fetch_type) {
                case self::FETCH_ALL:
                    return $this->statement->fetchAll(PDO::FETCH_ASSOC);
                case self::FETCH_ROW:
                    return $this->statement->fetch(PDO::FETCH_ASSOC);
                case self::FETCH_COLUMN:
                    return $this->statement->fetchColumn();
                default:
                    throw new InvalidArgumentException("Modo de fetch no válido: $fetch_type");
            }
        }

        function getLastId(){
            return $this->conn->lastInsertId();
        }

        function getExecuted(){
            return $this->executed;
        }

        public function closeConnection() {
            $this->conn = null;
        }

        function __destruct(){
            $this->closeConnection();
        }
    }