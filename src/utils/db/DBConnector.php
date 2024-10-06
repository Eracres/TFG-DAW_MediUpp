<?php

    // Conexión a la BBDD
    class DBConnector {
        private static $instance = null;
        private $conn;

        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "tfg_mediupp_local";
        private $port = "3306";
        private $charset = "utf8";

        private function __construct() {
            try {
                $dsn = "mysql:host=$this->servername;dbname=$this->dbname;charset=$this->charset;port=$this->port";
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error en la conexión a la base de datos: " . $e->getMessage());
            }
        }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function getConnection() {
            return $this->conn;
        }

        public function closeConnection() {
            $this->conn = null;
        }
    }