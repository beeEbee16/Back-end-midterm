<?php
    class Database {
        // DB Params
        private $conn;
        private $host;
        private $port;
        private $dbname;
        private $username;
        private $password;

        public function __construct() {
            $this->username = getEnv('DBUSERNAME');
            $this->password = getEnv('DBPASSWORD');
            $this->dbname = getEnv('DBNAME');
            $this->host = getEnv('DBHOST');
            $this->port = getEnv('DBPORT');
        }

        // DB Connect
        public function connect() {
            if ($this->conn) {
                return $this->conn;
            } else {

                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};sslcert=blank;";

                try {
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                } catch(PDOException $e) {
                    echo 'Connection Error: ' . $e->getMessage();
                }
            }
        }
    }
 