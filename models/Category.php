<?php
    class Post {
        // DB stuff
        private $conn;
        private $table = 'categories';

        // Post Properties
        public $id;
        public $category;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Posts
        public function read() {
            // Create query
            $query = 'SELECT 
                    c.id,
                    c.category
                FROM
                    ' . $this->table . ' c
                ORDER BY
                    c.category';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Post
        public function read_single() {
            // Create query
            $query = 'SELECT 
                    c.id,
                    c.category
                FROM
                    ' . $this->table . ' c
                WHERE
                    c.id = ?';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindparam(1, $this->id);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Create Post
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . ' (category)
                VALUES (:category)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind data
            $stmt->bindParam(':category', $this->category);

            // Execute query
            if($stmt->execute()) {
                return $this->conn->lastInsertId();;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return 0;
        }

        // Update Post
        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                SET
                    category = :category
                WHERE
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Delete Post
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }
            
            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

         // Determine if ID exists
         public function id_exists($id, $tableName) {
            if (!is_numeric($id)) {
                return false;
            }

            // Create query
            $query = 'SELECT 
                    id
                FROM ' . $tableName . 
                ' WHERE
                    id = ?';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindparam(1, $id);

            // Execute query
            $stmt->execute();

            return ($stmt->rowCount() === 0) ? false : true;
        }
    }