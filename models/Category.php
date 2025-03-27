<?php

    // Database connection
    include_once __DIR__ . '/../config/Database.php';

    class Category {
        private $conn;
        private $table = 'categories';

        public $id;
        public $category;

        public function __construct($db) 
            {
                $this->conn = $db;
            }

        // Creating read function
        public function read()
            {

            // Query for all categories
            $query = "SELECT
                id,
                category
                FROM " . $this->table . "
                ORDER BY id ASC";
        
            // Creating prepare statement
            $stmt = $this->conn->prepare($query);

            // Executing statement
            $stmt->execute();

            // Returning statement
            return $stmt;
            }

        public function read_single()
            {

            // Query for single category
            $query = "SELECT
                id,
                category
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
                    $this->category = $row['category'];
                    return true;
                } else 
                    {
                        return false;
                    }
            }

        public function create() 
            {

            // Create query
            $query = "INSERT INTO " . $this->table ." (category) VALUES (:category)";

            // Creating prepare statement
            $stmt= $this->conn->prepare($query);

            // Cleaning the data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Binding the data
            $stmt->bindParam(':category', $this->category);

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

        // Updating the post
        public function update()
            {

        // Create the query
        $query = 'UPDATE ' . $this->table . '
            SET
            category = :category
            WHERE
            id = :id';
    
        // Creating prepare statement
        $stmt = $this->conn->prepare($query);

        // Cleaning the data
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Binding the data
        $stmt->bindParam(':category', $this->category);
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