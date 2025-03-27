<?php

    // Database connection
    include_once __DIR__ . '/../config/Database.php';

    class Author {
        private $conn;
        private $table = 'authors';

        public $id;
        public $author;

        public function __construct($db) 
            {
                $this->conn = $db;
            }

        // Creating read function
        public function read()
            {

            // Query for all authors
            $query = "SELECT
                id,
                author
                FROM ".$this->table."
                ORDER BY id ASC";
        
            // Creating prepare statement
            $stmt = $this->conn->prepare($query);

            // Executing statement
            $stmt->execute();

            // Returning statement
            return $stmt;
            }

        // Create single read query        
        public function read_single()
            {

            // Query for single author
            $query = "SELECT
                id,
                author
                FROM " . $this->table ."
                WHERE id = :id
                LIMIT 1 OFFSET 0";
        
            // Creating prepare statement
            $stmt= $this->conn->prepare($query);

            // Cleaning the data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Binding the data
            $stmt->bindParam(':id', $this->id);

            // Executing the data
            $stmt->execute();

            // Retreiving the data
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Setting the properties if there is data set
            if($row)
                {
                    $this->id = $row['id'];
                    $this->author = $row['author'];
                    return true;
                } else 
                    {
                        return false;
                    }
            }

        public function create() 
            {

            // Create query
            $query = "INSERT INTO " . $this->table ." (author) VALUES (:author)";

            // Creating prepare statement
            $stmt= $this->conn->prepare($query);

            // Cleaning the data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Binding the data
            $stmt->bindParam(':author', $this->author);

            // Executing the data
            $stmt->execute();
            if($stmt->execute())
                {
                    return true;
                } else 
                    {
                        printf("Error: %s. \n", $stmt->error);
                        return false;
                    }
                }

        // Update the post
        public function update()
            {

        // Create query
        $query = 'UPDATE ' . $this->table . '
            SET
            author = :author
            WHERE
            id = :id';
    
        // Creating prepare statement
        $stmt = $this->conn->prepare($query);

        // Cleaning the data
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Binding the data
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if($stmt->execute())
            {
                return true;
            }

        // Return an error in there is a problem
        printf("Error: %s.\n", $stmt->error);

        return false;

            }

        //Delete post
        public function delete()
            {

                // Create query
                $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

                // Creating prepare statement
                $stmt = $this->conn->prepare($query);

                // Cleaning the data
                $this->id = htmlspecialchars(strip_tags($this->id));

                // Binding the data
                $stmt->bindParam(':id', $this->id);

                // Execute the query
                if($stmt->execute())
                    {
                        return true;
                    } else 
                        {

                        // Return an error in there is a problem
                        printf("Error: %s.\n", $stmt->error);
                        return false;
                        }
            }
    }
?>