<?php 
    
    include_once __DIR__ . '/../config/Database.php';

    class Quote {

    // DB stuff
    private $conn;
    private $table = 'quotes';

    // Quote Properties
    public $id;
    public $quote;
    public $author;
    public $category;
    public $category_id;
    public $author_id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Quotes
    public function read() {
      // Create query
      if (isset($this->author_id) && isset($this->category_id)){
      $query = 'SELECT q.id, q.quote, a.author as author, c.category as category
                                FROM quotes q
                                INNER JOIN
                                  authors a ON q.author_id = a.id
                                INNER JOIN
                                  categories c ON q.category_id = c.id
                                WHERE
                                  a.id = :author_id AND c.id = :category_id';
      } else if (isset($this->author_id)){
      $query = 'SELECT q.id, q.quote, a.author as author, c.category as category
                                FROM quotes q
                                INNER JOIN
                                  authors a ON q.author_id = a.id
                                INNER JOIN
                                  categories c ON q.category_id = c.id
                                WHERE
                                  a.id = :author_id';
      } else if (isset($this->category_id)){
      $query = 'SELECT q.id, q.quote, a.author as author, c.category as category
                                FROM quotes q
                                INNER JOIN
                                  authors a ON q.author_id = a.id
                                INNER JOIN
                                  categories c ON q.category_id = c.id
                                WHERE
                                  c.id = :category_id';
      } else {
      $query = 'SELECT q.id, q.quote, a.author as author, c.category as category
                                FROM quotes q
                                INNER JOIN
                                  authors a ON q.author_id = a.id
                                INNER JOIN
                                  categories c ON q.category_id = c.id';
      }
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      if($this->author_id){
        $stmt->bindParam(':author_id', $this->author_id);
      }
      if($this->category_id){
        $stmt->bindParam(':category_id', $this->category_id);
      }
      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Quote
    public function read_single() {
          // Create query
          $query = 'SELECT q.id, q.quote, a.author as author, c.category as category
          FROM quotes q
          INNER JOIN
            authors a ON q.author_id = a.id
          INNER JOIN
            categories c ON q.category_id = c.id
          WHERE q.id = :id
          LIMIT 1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(':id', $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          if($row){
          $this->id = $row['id'];
          $this->quote = $row['quote'];
          $this->author = $row['author'];
          $this->category = $row['category'];
   //       $this->category_id = $row['category_id'];
   //       $this->author_id = $row['author_id'];
          return true;
    } else {
          return false;
    }
    }

    // Create Quote
    public function create() {
          // Create query
          $query = 'INSERT INTO quotes(quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)';

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

    // Update Quote
    public function update() {
          // Create query
          $query = 'UPDATE FROM quotes
          SET quote = :quote, author_id = :author_id, category_id = :category_id
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));
          $this->quote = htmlspecialchars(strip_tags($this->quote));
          $this->author_id = htmlspecialchars(strip_tags($this->author_id));
          $this->category_id = htmlspecialchars(strip_tags($this->category_id));

          // Bind data
          $stmt->bindParam(':id', $this->id);
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

    // Delete Quote
    public function delete() {
          // Create query
          $query = 'DELETE FROM quotes WHERE id = :id';

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
          printf("No Quotes Found. Error: %s.\n", $stmt->error);

          return false;
    }
    
  }