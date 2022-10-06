<?php
    class database {
        // DB Params
        private $host     = 'us-cdbr-east-06.cleardb.net';
        private $db_name  = 'heroku_895402f5f99a5b6';
        private $username = 'be39831b4bc158';
        private $password = '1aac28be';
        private $conn;

        // DB Connect
        public function connect() {
            $this->conn = null;

            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                define("APP_NAME", "SCANDIWEB API");
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }

            return $this->conn;
        }
    }