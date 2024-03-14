<?php
    class Post {
        // DB stuff
        private $conn;
        private $table = 'quotes';

        // Post Properties
        public $id;
        public $quote;
        public $author;
        public $category;
        public $author_id;
        public $category_id;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Posts
        public function read() {
            $where = '';

            // Create query
            $query = 'SELECT 
                    q.id,
                    q.quote,
                    a.author,
                    c.category
                FROM
                    ' . $this->table . ' q
                INNER JOIN
                    authors a ON a.id = q.author_id
                INNER JOIN
                    categories c ON c.id = q.category_id';

                if ($this->author_id > 0) {
                    $where = ' a.id = :author_id';
                }  
                
                if ($this->category_id > 0) {
                    if ($where === '') {
                        $where .= ' c.id = :category_id';
                    } else {
                        $where .= ' AND c.id = :category_id';
                    }
                }

                if ($where !== '') {
                    $query .= ' WHERE' . $where;
                }

                $query .= ' ORDER BY
                    q.id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind parameters
            if ($this->author_id > 0) {
                $stmt->bindparam(':author_id', $this->author_id);
            }  
            if ($this->category_id > 0) {
                $stmt->bindparam(':category_id', $this->category_id);
            }  

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Post
        public function read_single() {
            // Create query
            $query = 'SELECT 
                    q.id,
                    q.quote,
                    a.author,
                    c.category
                FROM
                    ' . $this->table . ' q
                INNER JOIN
                    authors a ON a.id = q.author_id
                INNER JOIN
                    categories c ON c.id = q.category_id
                WHERE
                    q.id = ?';

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
            $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id)
                VALUES (:quote, :author_id, :category_id)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Update Post
        public function update($hasQuote, $hasAuthor, $hasCategory) {
            $hasItem = 0;
            // Create query
            $query = 'UPDATE ' . $this->table . '
                SET ';
            if ($hasQuote) {
                $query = $query . 'quote = :quote';
                $hasItem = 1;
            } 
            if ($hasAuthor) {
                if ($hasItem !== 0) {
                    $query = $query . ',';
                }
                $query = $query . 'author_id = :author_id';
                $hasItem = 1;
            } 
            if ($hasCategory) {
                if ($hasItem !== 0) {
                    $query = $query . ',';
                }
                $query = $query . 'category_id = :category_id';
            }         
            $query = $query . ' WHERE
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            if ($hasQuote) {
                $stmt->bindParam(':quote', $this->quote);
            }
            if ($hasAuthor) {
                $stmt->bindParam(':author_id', $this->author_id);
            }
            if ($hasCategory) {
                $stmt->bindParam(':category_id', $this->category_id);
            }

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

        // Get Single Post
        public function author_exists($id) {
            // Create query
            $query = 'SELECT 
                    id
                FROM
                    author 
                WHERE
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
