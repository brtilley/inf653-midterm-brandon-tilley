<?php 
    
    // Database connection
    include_once __DIR__ . '/../config/Database.php';

    class Quote {

    private $conn;
    private $table = 'quotes';

    public $id;
    public $category_id;
    public $author_id;
    public $author;
    public $category;
    public $quote;

    public function __construct($db)
        {
            $this->conn = $db;
        }

    // Creating read function
    public function read()
        {
        
        // Query for all quotes
        if (isset($this->author_id) && isset($this->category_id))
            {
                $query = "SELECT
                    q.id,
                    q.quote,
                    a.author as author,
                    c.category as category
                    FROM " . $this->table . " q
                    INNER JOIN authors a on q.author_id = a.id
                    INNER JOIN categories c on q.category_id = c.id
                    WHERE a.id = :author_id AND c.id = :category_id";
            }
            else if (isset($this->author_id))
                {
                   $query = "SELECT
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category
                        FROM " . $this->table . " q
                        INNER JOIN authors a on q.author_id = a.id
                        INNER JOIN categories c on q.category_id = c.id
                        WHERE a.id = :author_id";
                }
            else if(isset($this->category_id))
                {
                    $query = "SELECT
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category
                        FROM " . $this->table . " q
                        INNER JOIN authors a on q.author_id = a.id
                        INNER JOIN categories c on q.category_id = c.id
                        WHERE c.id = :category_id";
                } else 
                    {
                        $query = "SELECT
                            q.id,
                            q.quote,
                            a.author as author,
                            c.category as category
                            FROM " . $this->table . " q
                            INNER JOIN authors a on q.author_id = a.id
                            INNER JOIN categories c on q.category_id = c.id
                            ORDER BY q.id ASC";
                    }
      
                // Creating prepare statement
                $stmt = $this->conn->prepare($query);
                if($this->author_id)
                    {
                        $stmt->bindParam(':author_id', $this->author_id);
                    }
                    if($this->category_id)
                        {
                            $stmt->bindParam(':category_id', $this->category_id);
                        }
                    $stmt->execute();
                    return $stmt;
        }

    // Query for single quote
    public function read_single()
        {

            $query = "SELECT
                q.id,
                q.quote,
                a.author as author,
                c.category as category
                FROM " . $this->table . " q
                INNER JOIN authors a on q.author_id = a.id
                INNER JOIN categories c on q.category_id = c.id
                WHERE q.id = :id
                LIMIT 1 OFFSET 0";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Setting the properties if there is data set
            if($row)
                {
                    $this->id = $row['id'];
                    $this->quote = $row['quote'];
                    $this->category = $row['category'];
                    $this->author = $row['author'];
                    return true;
                } else
                    {
                        // Return an error in there is a problem
                        return false;
                    }
        }
      
    // Updating the post
    public function create()
        {

            // Create query
            $query = 'INSERT INTO ' . $this->table. ' (quote, category_id, author_id)
                VALUES
                (:quote,
                :author_id,
                :category_id)';

            // Creating prepare statement
            $stmt = $this->conn->prepare($query);

            // Cleaning the data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Binding the data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            //Execute the query
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

    // Updating the post
    public function update()
        {
        
        // Create the query
        $query = 'UPDATE ' . $this->table . '
            SET
            id = :id,
            quote = :quote,
            author_id = :author_id,
            category_id = :category_id
            WHERE
            id = :id';
          
        // Creating prepare statement
        $stmt = $this->conn->prepare($query);

        // Cleaning the data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Binding the data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        //Execute the query
        if($stmt->execute()){
        if ($stmt->rowCount()==0)
            {
                return false;
            } else
                {
                    return true;
                } else 
                    {

                        // Return an error in there is a problem
                        printf("Error: %s.\n", $stmt->error);
                        return false;
                    }
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

            //Execute the query
            if($stmt->execute())
                {
                    if ($stmt->rowCount() == 0)
                        {
                            return false;
                        } else 
                            {
                                return true;
                            }
                } else 
                    {

                        // Return an error in there is a problem
                        printf("Error: %s.\n", $stmt->error);
                        return false;
                    }
            } 
    }
    }
?>